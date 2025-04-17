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
        $flujo = new FlujoTrabajo();        
        $flujo->id=1;
        $flujo->nombre = 'Registro pagos clientes';
        $flujo->descripcion = 'Este es un flujo de trabajo para registrar los pagos que realizan los clientes en las zonas rurales y que deben ser contabilizados para tener actualizada la cartera de clientes.';
        $flujo->save();

        // $flujo2 = new FlujoTrabajo();
        // $flujo->id(2);
        // $flujo2->nombre = 'Flujo Secundario';
        // $flujo2->descripcion = 'Flujo de trabajo secundario del sistema';
        // $flujo2->activo = true;
        // $flujo2->save();

    }
}
