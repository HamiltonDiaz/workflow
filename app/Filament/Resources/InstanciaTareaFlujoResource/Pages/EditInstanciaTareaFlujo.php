<?php

namespace App\Filament\Resources\InstanciaTareaFlujoResource\Pages;

use App\Filament\Resources\InstanciaTareaFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstanciaTareaFlujo extends EditRecord
{
    protected static string $resource = InstanciaTareaFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function afterSave(): void
    {
        // Forzar la actualización de los RelationManagers
        $this->dispatch('refreshRelationManagers');
    }

    public function refreshRelationManagers(): void
    {
        $this->dispatch('refresh');
    }
}
