<?php

namespace App\Filament\Resources\ListaElementoResource\Pages;

use App\Filament\Resources\ListaElementoResource;
use App\Models\ListaElemento;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditListaElemento extends EditRecord
{
    protected static string $resource = ListaElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $modelo= new ListaElemento;
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
}
