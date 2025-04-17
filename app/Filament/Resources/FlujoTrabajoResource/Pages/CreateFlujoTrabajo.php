<?php

namespace App\Filament\Resources\FlujoTrabajoResource\Pages;

use App\Filament\Resources\FlujoTrabajoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlujoTrabajo extends CreateRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = FlujoTrabajoResource::class;

    protected function beforeCreate(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre'],'nombre');

    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record'=>$this->record->id]);
    }
}
