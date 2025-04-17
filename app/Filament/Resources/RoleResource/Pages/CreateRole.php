<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
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
}
