<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\Permission;

class CreatePermission extends CreateRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = PermissionResource::class;

    protected function beforeCreate(): void
    {    
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['name','guard_name'],'name');
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record'=>$this->record->id]);
    }
}
