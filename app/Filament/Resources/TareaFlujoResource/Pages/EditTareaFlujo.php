<?php

namespace App\Filament\Resources\TareaFlujoResource\Pages;

use App\Filament\Resources\TareaFlujoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\PasoFlujo;
use App\Models\TareaFlujo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTareaFlujo extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = TareaFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function beforeSave(): void
    {
        $this->validateEsFinal();
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['titulo','pasos_flujo_id'],'titulo');
    } 

    
    private function validateEsFinal()
    {

        $model= new TareaFlujo();       

        //Valida que el primer paso no sea final
        if($this->data['es_final']!=0 && $this->data['orden'] ==1 ){
            Notification::make()
                ->title('Error de validación')
                ->body('La primer tarea no puede ser final.')
                ->danger()
                ->send();                
            $this->halt();
        }
    
        //Valida si hay un paso superior
        $maximo= $model::where('pasos_flujo_id', $this->data['pasos_flujo_id'])
            ->where('id', '!=', $this->data['id'])
            ->where('deleted_at', null)
            ->max('orden');

        if($this->data['orden'] < $maximo  && $this->data['es_final']!=0){
            Notification::make()
                ->title('Error de validación')
                ->body('No es posible asignar este registro cómo final porque existe una tarea superior.')
                ->danger()
                ->send();                
            $this->halt();
        }
       
        // Verifica si existe un paso final para este flujo
        $exists = $model::where('pasos_flujo_id', $this->data['pasos_flujo_id'])
            ->where('es_final', 1)
            ->where('id', '!=', $this->data['id'])
            ->where('deleted_at', null)
            ->exists();

        if ($exists  && $this->data['es_final']!=0) {
            Notification::make()
                ->title('Error de validación')
                ->body('No se pueden crear más tareas porque ya existe una tarea final en este paso.')
                ->danger()
                ->send();                
            $this->halt();
        }        
        
        $esPasoFinal= PasoFlujo::where('id',$this->data['pasos_flujo_id'])
                ->where('es_final', 0)
                ->where('id', '!=', $this->data['id'])
                ->where('deleted_at', null)
                ->exists();
               
        if ($esPasoFinal && $this->data['es_final']!=0 ) {
            Notification::make()
                ->title('Error de validación')
                ->body('No puede asignarse esta tarea como final por que el paso padre no es final.')
                ->danger()
                ->send();                
            $this->halt();
        }
    }
}
