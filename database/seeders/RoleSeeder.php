<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1= new Role();
        $rol1->id= 1;
        $rol1->name="Admin";
        $rol1->guard_name="web";
        $rol1->save();
        
        $rol2= new Role();
        $rol2->id= 2;
        $rol2->name="Auxiliar";
        $rol2->guard_name="web";
        $rol2->save();
    }
}
