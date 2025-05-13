<?php

namespace Database\Seeders;

use App\Enums\GlobalEnums;
use App\Models\InstanciaPasoFlujo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstanciaPasoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasoGeneral = new InstanciaPasoFlujo();
        $pasoGeneral->id=1;
        $pasoGeneral->nombre = 'Paso general';
        $pasoGeneral->descripcion = 'En este paso se realizan tareas generales.';
        $pasoGeneral->orden = 1;
        $pasoGeneral->es_final = 1;
        $pasoGeneral->instancia_flujo_trabajo_id=1;
        $pasoGeneral->estado = GlobalEnums::ACTIVO_INSTANCIA_PASO->value(); 
        $pasoGeneral->save();
    }
}
