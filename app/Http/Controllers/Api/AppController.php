<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    

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
