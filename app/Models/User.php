<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    protected $fillable = [
        'name',
        'phone',
        'password',
        'Consent_ID1',
        'Consent_ID2',
        'Consent_ID3',
        'user'
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Método para encriptar usando AES-256-CBC
    private function encrypt($value)
    {
        $key = env('AES_KEY');  
        $iv = env('AES_IV');
        return openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);
    }

    // Encriptamos los datos
    public function setPhoneAttribute($value){
        $this->attributes['phone'] = $this->encrypt($value); 
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = $this->encrypt($value);
    }

    public function setUserAttribute($value){
        $this->attributes['user'] = $this->encrypt($value);
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = $this->encrypt($value);
    }

    // Desencriptando de los datos 
    public function getPhoneAttribute($value){
        return $this->decrypt($value);  
    }

    public function getNameAttribute($value){
        return $this->decrypt($value);
    }

    public function getUserAttribute($value){
        return $this->decrypt($value);
    }

    public function getPasswordAttribute($value){
        return $this->decrypt($value);
    }

    
    // Método para desencriptar usando AES-256-CBC
    private function decrypt($value)
    {
        $key = env('AES_KEY');
        $iv = env('AES_IV');

        return openssl_decrypt($value, 'AES-256-CBC', $key, 0, $iv);
    }

    
}
