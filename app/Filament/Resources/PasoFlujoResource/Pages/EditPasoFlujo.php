<?php

namespace App\Filament\Resources\PasoFlujoResource\Pages;

use App\Filament\Resources\PasoFlujoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\PasoFlujo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPasoFlujo extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = PasoFlujoResource::class;

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
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre','flujo_trabajo_id'],'nombre');
    }

    private function validateEsFinal()
    {
        $model= new PasoFlujo();       

        //Valida que el primer paso no sea final
        // if($this->data['es_final']!=0 && $this->data['orden'] ==1 ){
        //     Notification::make()
        //         ->title('Error de validación')
        //         ->body('El primer paso no puede ser final.')
        //         ->danger()
        //         ->send();                
        //     $this->halt();
        // }
    
        //Valida si hay un paso superior
        $maximo= $model::where('flujo_trabajo_id', $this->data['flujo_trabajo_id'])
            ->where('id', '!=', $this->data['id'])
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
            ->where('id', '!=', $this->data['id'])
            ->where('deleted_at', null)
            ->exists();

        if ($exists && $this->data['es_final']!=0) {
            Notification::make()
                ->title('Error de validación')
                ->body('Ya existe un paso final para este flujo.')
                ->danger()
                ->send();                
            $this->halt();
        }
    }

}
