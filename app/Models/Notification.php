<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_notification';
    protected $fillable =['Consent_ID3','id_user','action'];

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

    public function setConsent_ID3Attribute($value){
        $this->attributes['Consent_ID3'] = $this->encrypt($value);
    }

    public function getConsent_ID3Attribute($value){
        return $this->decrypt($value);
    }
}
