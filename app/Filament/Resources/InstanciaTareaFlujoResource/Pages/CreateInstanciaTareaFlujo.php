<?php

namespace App\Filament\Resources\InstanciaTareaFlujoResource\Pages;

use App\Enums\GlobalEnums;
use App\Filament\Resources\InstanciaTareaFlujoResource;
use App\Models\HistoricoTarea;
use App\Models\InstanciaFlujoTrabajo;
use App\Models\InstanciaPasoFlujo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateInstanciaTareaFlujo extends CreateRecord
{
    protected static string $resource = InstanciaTareaFlujoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {


        $flujoGeneral = new InstanciaFlujoTrabajo();
        $flujoGeneral->nombre = 'Flujo general - Tarea: ' . $this->data['titulo'] . ' - ' . now()->format('d/m/Y');
        $flujoGeneral->flujo_trabajo_id=GlobalEnums::FLUJO_GENERAL->value();
        $flujoGeneral->save();

        $pasoGeneral = new InstanciaPasoFlujo();
        $pasoGeneral->nombre = 'Paso general - Tarea: ' . $this->data['titulo'] . ' - ' . now()->format('d/m/Y');
        $pasoGeneral->orden = 1;
        $pasoGeneral->es_final = 1; 
        $pasoGeneral->instancia_flujo_trabajo_id = $flujoGeneral->id;
        $pasoGeneral->estado = GlobalEnums::ACTIVO_INSTANCIA_PASO->value();
        $pasoGeneral->save();

        $data['instancia_paso_flujo_id'] = $pasoGeneral->id;
        return $data;
    }
    
    protected function afterCreate(): void
    {
        // Crear registro histórico después de crear la tarea
        HistoricoTarea::create([
            'descripcion' => 'Se crea tarea general',
            'instancia_tareas_flujo_id' => $this->record->id,
            'user_id' => Auth::user()->id
        ]);
    }
}
