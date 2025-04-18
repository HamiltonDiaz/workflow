<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoListaElemento;

class TipoListaElementosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Inserción usando el modelo y el método create()
                TipoListaElemento::create([
                    'id' => 1,
                    'nombre' => 'estados tareas',
                    'descripcion' => 'Se utiliza para definir los estados de las instancias de tareas',
                ]);
        
                TipoListaElemento::create([
                    'id' => 2,
                    'nombre' => 'tipos de documentos',
                    'descripcion' => null,
                ]);
        
                TipoListaElemento::create([
                    'id' => 3,
                    'nombre' => 'estados pasos flujos',
                    'descripcion' => 'Se utiliza para definir los estados de las instancias de pasos del flujo',
                ]);
    }
}
