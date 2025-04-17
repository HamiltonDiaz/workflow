<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = RoleResource::class;

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
