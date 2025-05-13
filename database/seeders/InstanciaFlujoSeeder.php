<?php

namespace Database\Seeders;

use App\Models\InstanciaFlujoTrabajo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstanciaFlujoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flujoGeneral = new InstanciaFlujoTrabajo();
        $flujoGeneral->id=1;
        $flujoGeneral->nombre = 'Flujo general';
        $flujoGeneral->descripcion = 'Flujo para tareas generales';
        $flujoGeneral->flujo_trabajo_id=1;
        $flujoGeneral->save();
    }
}
