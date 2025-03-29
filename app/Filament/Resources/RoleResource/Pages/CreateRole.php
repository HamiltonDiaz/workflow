<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Filament\Notifications\Notification;
use App\Models\Role;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;    


    protected function beforeCreate(): void
    {

        $this->data['guard_name']="web";
        
        //TODO: Esto es para hacer validaciones antes de guardar
        $existingRole = Role::withTrashed()
            ->where('name', $this->data['name'])
            ->where('guard_name', $this->data['guard_name'] ?? 'web')
            ->first();

        if ($existingRole) {
            if ($existingRole->trashed()) {
                $existingRole->restore();
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
        return $this->getResource()::getUrl('index');//TODO: Esto es para redireccionar cuando crea un registro
    }
}
