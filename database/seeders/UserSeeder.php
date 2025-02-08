<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=> "pedro",
            "phone"=> "22222222222",
            "user"=> "Alandev662",
            "password"=> "Cesar1axel@",
            "Consent_ID1"=> true,
            "Consent_ID2"=> false,
            "Consent_ID3"=> false
        ]);
    }
}
