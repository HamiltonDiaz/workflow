<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\Role;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('copy_permissions')
                ->label('Copiar rol')
                ->icon('heroicon-m-clipboard')
                ->form([
                    Select::make('role_to_copy')
                        ->label('Seleccionar rol')
                        ->options(Role::where('id', '!=', $this->record->id)->pluck('name', 'id'))
                        ->required()
                ])
                ->action(function (array $data) {
                    $roleToClone = Role::find($data['role_to_copy']);
                    if ($roleToClone) {
                        // Obtener los datos actuales del formulario
                        $currentData = $this->form->getState();

                        // Obtener los permisos actuales y los nuevos
                        $currentPermissions = $this->record->permissions->pluck('id')->toArray() ?? [];

                        // Obtener los permisos del rol a clonar
                        $newPermissions = $roleToClone->permissions->pluck('id')->toArray();

                        // Combinar los permisos sin duplicados
                        $mergedPermissions = array_unique(array_merge($currentPermissions, $newPermissions));

                        // Actualizar el formulario manteniendo los datos actuales
                        $this->form->fill([
                            ...$currentData,
                            'permissions' => $mergedPermissions
                        ]);

                        Notification::make()
                            ->title('Permisos copiados y combinados correctamente')
                            ->success()
                            ->send();
                    }
                }),
            Actions\DeleteAction::make(),
        ];
    }
    protected function beforeSave(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['name', 'guard_name'], 'name');
    }
}
