<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = UserResource::class;

    protected function beforeCreate(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['tipo_documento','numero_documento'],'numero_documento');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record'=>$this->record->id]);
    }
}
