<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\Permission;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    protected function beforeCreate(): void
    {
    
        //Configuración de campos
        $this->data['guard_name'] = "web";

        
        //TODO: Esto es para hacer validaciones antes de guardar
        $existingRegister = Permission::withTrashed()
            ->where('name', $this->data['name'])
            ->where('guard_name', $this->data['guard_name'] ?? 'web')
            ->first();

        if ($existingRegister) {
            if ($existingRegister->trashed()) {
                $existingRegister->restore();
                Notification::make()
                    ->title('Creado')
                    ->success()
                    ->send();
                $this->redirect($this->getResource()::getUrl('index'));
            } else {
                Notification::make()
                    ->title('Error')
                    ->body("El registro '{$this->data['name']}' ya existe.")
                    ->danger()
                    ->send();
            }
            $this->halt();
        }
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
