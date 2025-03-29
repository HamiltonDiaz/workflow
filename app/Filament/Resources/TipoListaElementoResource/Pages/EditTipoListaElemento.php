<?php

namespace App\Filament\Resources\TipoListaElementoResource\Pages;

use App\Filament\Resources\TipoListaElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoListaElemento extends EditRecord
{
    protected static string $resource = TipoListaElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
