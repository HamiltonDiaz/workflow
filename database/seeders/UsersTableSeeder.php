<?php

namespace Database\Seeders;

use App\Models\Role;
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

        $rol1= new Role();
        $rol1->name="Admin";
        $rol1->guard_name="web";
        $rol1->save();

        $user1 = new User();
        $user1->name = "hamilton diaz rubio";
        $user1->email = "admin@test.com";
        $user1->password = Hash::make("123456");
        $user1->numero_documento = "123456789";
        $user1->tipo_documento = 4;        
        $user1->assignRole($rol1);
        $user1->save();


        $rol2= new Role();
        $rol2->name="Supervisor";
        $rol2->guard_name="web";
        $rol2->save();

        $user2 = new User();
        $user2->name = "lisseth fiesco";
        $user2->email = "admin2@test.com";
        $user2->password = Hash::make("123456");
        $user2->numero_documento = "987654321";
        $user2->tipo_documento = 4;        
        $user2->assignRole($rol2);
        $user2->save();

        
    }
}
