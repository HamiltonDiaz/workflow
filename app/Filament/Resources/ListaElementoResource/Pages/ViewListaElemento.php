<?php

namespace App\Filament\Resources\ListaElementoResource\Pages;

use App\Filament\Resources\ListaElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewListaElemento extends ViewRecord
{
    protected static string $resource = ListaElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
