<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Email;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class AppController extends Controller
{
    private function encrypt($value)
    {
    $key = env('AES_KEY');  
    $iv = env('AES_IV'); 
    return openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);
    } 

    public function Get_Token(Request $request){

        $request->validate([
            'user' => 'required',
            'password' => 'required'
        ]);

        $user_encypt = $this->encrypt($request->user);
        $user = User::where('user',$user_encypt)->first();
        // if(Auth::attempt($credentials)){
        if ($user && Hash::check($request->password, $user->password)) {
            // $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token',$token,60 * 24);
            $Date_Finish = date('Y-m-d');
            return response(["token"=> $token,"Date_Finish" => $Date_Finish], Response::HTTP_OK)->withoutCookie($cookie);
        }else{
            return response(['message' => 'No Autorizado'],Response::HTTP_UNAUTHORIZED);
        } 
    }

    public function Create_User(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required | min:3 ',
            'phone' => 'required | min:10 | numeric | unique:users',
            'password' => 'required | min:8 | regex: /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            'Consent_ID1' => 'required',
            'Consent_ID2' => 'required',
            'user' => 'required | min:3 | unique:users',
            'Consent_ID3' => 'required'
        ]);

        if($validator-> fails()){

            $data = [
                'response' => 'false',
                'message' => 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }
        
        $Create_User = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'user' => $request->user,
            'password' => Hash::make($request->password),
            'Consent_ID1' => $request->Consent_ID1,
            'Consent_ID2' => $request->Consent_ID2,
            'Consent_ID3' => $request->Consent_ID3
        ]);
        
        $transaction = new Transaction();
        $transaction->id_user = $Create_User->id_user;
        $transaction->Consent_ID1 = Str::random(30);
        $transaction->save();

        $email = new Email();
        $email->id_user = $Create_User->id_user;
        $email->Consent_ID2 = Str::random(30);
        $email->action = $request->Consent_ID2;
        $email->save();

        $notification = new Notification();
        $notification->id_user = $Create_User->id_user;
        $notification->Consent_ID3 = Str::random(30);
        $notification->action = $request->Consent_ID2;
        $notification->save();

        $data = [
            'response' => 'true',
            'mesagge' => 'success',
            'id_user' => $Create_User->id_user,
            'status' => 200,
        ];

         return response()->json($data,200);
        // Otra forma de automatizar mensajes de apis, es ocupar respuestas http:
        // Me gusta por que esta mas acoplado a las apis estadarizadas
        // return response($data, Response::HTTP_CREATED);
    }

    public function Update_User($id, Request $request){

        $Update_User = User::where('id_user',$id)->first();

        if(!$Update_User){
            $data = [
                'response' => false,
                'mesagge' => 'error',
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required | min:3 ',
            'phone' => 'required | min:10 | numeric | unique:users',
            'password' => 'required | min:8 | regex: /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            'Consent_ID2' => 'required',
            'user' => 'required | min:3 | unique:users',
            'Consent_ID3' => 'required'
        ]);

        if($validator-> fails()){

            $data = [
                'response' => 'false',
                'message' => 'error',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data,400);
        }

        $Update_User->name = $request->name;
        $Update_User->phone = $request->phone;
        $Update_User->user = $request->user;
        $Update_User->password = $request->password;
        $Update_User->Consent_ID2 = $request->Consent_ID2;
        $Update_User->Consent_ID3 = $request->Consent_ID3;
        $Update_User->save();

        $email = Email::where('id_user',$Update_User->id_user)->first();
        $email->action = $request->Consent_ID2;
        $email->save();

        $notification = Notification::where('id_user',$Update_User->id_user)->first();
        $notification->action = $request->Consent_ID3;
        $notification->save();

        $data = [
            'response' => true,
            'mesagge' => 'success',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function Delete_User($id){

        $Delete_User = User::where('id_user',$id)->first();

        if(!$Delete_User){
            $data = [
                'response' => false,
                'mesagge' => 'error',
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $Delete_User->delete();
        $data = [
            'response' => true,
            'mesagge' => 'success',
            'status' => 200
        ];

        // User::destroy($id);

        return response()->json($data,200);
    }
}
