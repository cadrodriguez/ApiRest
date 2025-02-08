<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaction';
    protected $fillable =['Consent_ID1','id_user'];

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

    public function setConsent_ID1Attribute($value){
        $this->attributes['Consent_ID1'] = $this->encrypt($value);
    }

    public function getConsent_ID1Attribute($value){
        return $this->decrypt($value);
    }
}
