<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ListaElemento;


class ListaElementosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        ListaElemento::create(['id' => 1, 'nombre' => 'pendiente', 'tipo_lista_elemento_id' => 1]);
        ListaElemento::create(['id' => 2, 'nombre' => 'en progreso', 'tipo_lista_elemento_id' => 1]);
        ListaElemento::create(['id' => 3, 'nombre' => 'finalizado', 'tipo_lista_elemento_id' => 1]);

        ListaElemento::create(['id' => 4, 'nombre' => 'Cédula de ciudadanía', 'tipo_lista_elemento_id' => 2]);
        ListaElemento::create(['id' => 5, 'nombre' => 'Tarjeta de identidad', 'tipo_lista_elemento_id' => 2]);
        ListaElemento::create(['id' => 6, 'nombre' => 'Registro civil', 'tipo_lista_elemento_id' => 2]);
        ListaElemento::create(['id' => 7, 'nombre' => 'Cédula de extranjería', 'tipo_lista_elemento_id' => 2]);
        ListaElemento::create(['id' => 8, 'nombre' => 'Pasaporte', 'tipo_lista_elemento_id' => 2]);
        ListaElemento::create(['id' => 9, 'nombre' => 'NIT', 'tipo_lista_elemento_id' => 2]);

        ListaElemento::create(['id' => 10, 'nombre' => 'activo', 'tipo_lista_elemento_id' => 3]);
        ListaElemento::create(['id' => 11, 'nombre' => 'completo', 'tipo_lista_elemento_id' => 3]);
        ListaElemento::create(['id' => 12, 'nombre' => 'pausado', 'tipo_lista_elemento_id' => 3]);
    }
}
