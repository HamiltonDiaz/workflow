<?php

namespace App\Filament\Resources\TipoListaElementoResource\Pages;

use App\Filament\Resources\TipoListaElementoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\TipoListaElemento;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTipoListaElemento extends EditRecord
{
    use FilamentDuplicateCheckTrait; //Metodo propio

    protected static string $resource = TipoListaElementoResource::class;

    protected function beforeSave(): void
    {
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre'],'nombre');
    }    

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
