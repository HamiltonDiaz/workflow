<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\Role;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = RoleResource::class;    


    protected function beforeCreate(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['name','guard_name'],'name');
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record'=>$this->record->id]);
    }

        protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('copy_permissions')
                ->label('Copiar rol')
                ->icon('heroicon-m-clipboard')
                ->form([
                    Select::make('role_to_copy')
                        ->label('Seleccionar rol')
                        ->options(Role::pluck('name', 'id'))
                        ->required()
                ])
                ->action(function (array $data) {
                    $roleToClone = Role::find($data['role_to_copy']);
                    if ($roleToClone) {
                        $this->data['permissions'] = $roleToClone->permissions->pluck('id')->toArray();
                        Notification::make()
                            ->title('Permisos copiados correctamente')
                            ->success()
                            ->send();
                    }
                }),
        ];
    }
}
