<?php

namespace App\Filament\Resources\TipoListaElementoResource\Pages;

use App\Filament\Resources\TipoListaElementoResource;
use App\Models\TipoListaElemento;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTipoListaElemento extends EditRecord
{
    protected static string $resource = TipoListaElementoResource::class;

    protected function beforeSave(): void
    {
        $modelo= new TipoListaElemento();
         //Validar si existe un registro activo
         if($modelo->duplicatedRegister($this->data)){
            Notification::make()
                ->title('Error')
                ->body("El registro '{$this->data['nombre']}' ya existe.")
                ->danger()
                ->send();
            $this->halt();
        }
        //Valida si el registro esta eliminado y lo restaura:
        $existingRegister=$modelo->deletedRegister($this->data);
        if($existingRegister){   
            Notification::make()
            ->title('Guardado')
            ->success()
            ->send();
            $this->redirect($this->getResource()::getUrl('edit', ['record'=>$existingRegister->id]));
            $this->halt();         
        }
    }    

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
