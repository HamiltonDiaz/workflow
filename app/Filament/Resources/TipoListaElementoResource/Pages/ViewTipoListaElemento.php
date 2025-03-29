<?php

namespace App\Filament\Resources\TipoListaElementoResource\Pages;

use App\Filament\Resources\TipoListaElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTipoListaElemento extends ViewRecord
{
    protected static string $resource = TipoListaElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
