<?php

namespace Database\Seeders;

use App\Models\TareaFlujo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TareasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

     
        $tarea1 = new TareaFlujo();
        $tarea1->id=2;
        $tarea1->titulo="Escanear soportes";
        $tarea1->descripcion="Escanear los soportes de pago recibidos y subir en formato pdf y describe información del pago.";
        $tarea1->orden=1;
        $tarea1->es_final=0;
        $tarea1->es_editable=1;
        $tarea1->pasos_flujo_id=2;
        $tarea1->save();


        $tarea2 = new TareaFlujo();
        $tarea2->id=3;
        $tarea2->titulo="Verificación de información";
        $tarea2->descripcion="Verificar que la información del cliente coincida con los registros internos.";
        $tarea2->orden=1;
        $tarea2->es_final=0;
        $tarea2->es_editable=1;
        $tarea2->pasos_flujo_id=3;
        $tarea2->save();
        
        $tarea2 = new TareaFlujo();
        $tarea2->id=4;
        $tarea2->titulo="Contabilización del Pago";
        $tarea2->descripcion="Registrar el pago en el sistema contable correspondiente.";
        $tarea2->orden=1;
        $tarea2->es_final=0;
        $tarea2->es_editable=1;
        $tarea2->pasos_flujo_id=4;
        $tarea2->save();
        
    }
}
