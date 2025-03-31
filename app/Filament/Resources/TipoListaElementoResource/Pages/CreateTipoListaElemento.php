<?php

namespace App\Filament\Resources\TipoListaElementoResource\Pages;

use App\Filament\Resources\TipoListaElementoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\TipoListaElemento;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoListaElemento extends CreateRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio

    protected static string $resource = TipoListaElementoResource::class;

    protected function beforeCreate(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre'],'nombre');

    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record'=>$this->record->id]);
    }
}
