<?php

namespace App\Filament\Resources\FlujoTrabajoResource\Pages;

use App\Filament\Resources\FlujoTrabajoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlujoTrabajo extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = FlujoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre'],'nombre');
    }    
}
