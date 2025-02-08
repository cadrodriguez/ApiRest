<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_email';
    protected $fillable =['Consent_ID2','id_user','action'];

    private function encrypt($value)
    {
        $key = env('AES_KEY');  
        $iv = env('AES_IV');
        return openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);
    }

    private function decrypt($value)
    {
        $key = env('AES_KEY');
        $iv = env('AES_IV');

        return openssl_decrypt($value, 'AES-256-CBC', $key, 0, $iv);
    }

    public function setConsent_ID2Attribute($value){
        $this->attributes['Consent_ID2'] = $this->encrypt($value);
    }

    public function getConsent_ID2Attribute($value){
        return $this->decrypt($value);
    }
}
