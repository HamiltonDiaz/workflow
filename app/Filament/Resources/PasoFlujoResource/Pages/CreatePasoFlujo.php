<?php

namespace App\Filament\Resources\PasoFlujoResource\Pages;

use App\Filament\Resources\PasoFlujoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\PasoFlujo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreatePasoFlujo extends CreateRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = PasoFlujoResource::class;


    protected function beforeCreate(): void
    {
        $this->validateEsFinal();
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre','flujo_trabajo_id'],'nombre');

    }
    

    protected function getRedirectUrl(): string
    {        
        return $this->getResource()::getUrl('edit', ['record'=>$this->record->id]);

    }
    

    private function validateEsFinal()
    {
        $model= new PasoFlujo();       

        //Valida que el primer paso no sea final
        if($this->data['es_final']!=0 && $this->data['orden'] ==1 ){
            Notification::make()
                ->title('Error de validación')
                ->body('El primer paso no puede ser final.')
                ->danger()
                ->send();                
            $this->halt();
        }

        //Valida si hay un paso superior
        $maximo= $model::where('flujo_trabajo_id', $this->data['flujo_trabajo_id'])
                ->where('deleted_at', null)
                ->max('orden');

        if($this->data['orden'] < $maximo  && $this->data['es_final']!=0){
            Notification::make()
                ->title('Error de validación')
                ->body('No es posible asignar este registro cómo final porque existe un paso superior.')
                ->danger()
                ->send();                
            $this->halt();
        }
    
        // Verifica si existe un paso final para este flujo
        $exists = $model::where('flujo_trabajo_id', $this->data['flujo_trabajo_id'])
            ->where('es_final', 1)
            ->where('deleted_at', null)
            ->exists();

        if ($exists) {
            Notification::make()
                ->title('Error de validación')
                ->body('No se pueden crear más pasos porque ya existe un paso final en este flujo de trabajo.')
                ->danger()
                ->send();                
            $this->halt();
        }
    }
}
