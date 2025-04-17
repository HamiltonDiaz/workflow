<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function beforeSave(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['name','guard_name'],'name');
    }
}
