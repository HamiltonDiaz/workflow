<?php

namespace Database\Seeders;

use App\Models\PasoFlujo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $paso1 = new PasoFlujo();
        $paso1->id=2;
        $paso1->nombre = 'Recepción soporte';
        $paso1->descripcion = 'En este paso se recibe soporte del pago realizado por el proveedor.';
        $paso1->orden = 1;
        $paso1->es_final = 0;
        $paso1->flujo_trabajo_id=2;
        $paso1->save();

        
        $paso2 = new PasoFlujo();
        $paso2->id=3;
        $paso2->nombre = 'Validación de información';
        $paso2->descripcion = 'Verificar que la información del cliente coincida con los registros internos.';
        $paso2->orden = 1;
        $paso2->flujo_trabajo_id=2;
        $paso2->es_final = 0;
        $paso2->save();

        $paso3 = new PasoFlujo();
        $paso3->id=4;
        $paso3->nombre = 'Contabilización pago';
        $paso3->descripcion = 'Paso para realizar las actividades para contabilizar el pago.';
        $paso3->orden = 1;
        $paso3->flujo_trabajo_id=2;
        $paso3->es_final = 1;
        $paso3->save();
        

    }
}
