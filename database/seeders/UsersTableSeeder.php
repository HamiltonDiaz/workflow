<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = "hamilton diaz rubio";
        $user->email = "admin@test.com";
        $user->password = Hash::make("123456");
        $user->numero_documento = "123456789";
        $user->tipo_documento = 3;        
        $user->save();
        
    }
}
