<?php

namespace Database\Seeders;

use App\Models\FlujoTrabajo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class FlujoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $flujo1 = new FlujoTrabajo();        
        $flujo1->id=1;
        $flujo1->nombre = 'General';
        $flujo1->descripcion = 'Flujo para tareas generales.';
        $flujo1->save();

        $flujo2 = new FlujoTrabajo();        
        $flujo2->id=2;
        $flujo2->nombre = 'Registro pagos clientes';
        $flujo2->descripcion = 'Este es un flujo de trabajo para registrar los pagos que realizan los clientes en las zonas rurales y que deben ser contabilizados para tener actualizada la cartera de clientes.';
        $flujo2->save();

        

    }
}
