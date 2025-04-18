<?php

namespace App\Filament\Resources\InstanciaFlujoTrabajoResource\Pages;

use App\Filament\Resources\InstanciaFlujoTrabajoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstanciaFlujoTrabajo extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio
    protected static string $resource = InstanciaFlujoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {        
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre','flujo_trabajo_id'],'nombre');
    }

}
