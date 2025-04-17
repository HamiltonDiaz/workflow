<?php

namespace Database\Seeders;

use App\Models\FlujoTrabajo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TipoListaElementosSeeder::class,
            ListaElementosSeeder::class,
            UsersTableSeeder::class,
            FlujoTrabajo::class,
            PasosSeeder::class,
            TareasSeeder::class
        ]);
    }
}
