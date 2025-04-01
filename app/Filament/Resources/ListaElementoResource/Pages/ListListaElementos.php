<?php

namespace App\Filament\Resources\ListaElementoResource\Pages;

use App\Filament\Resources\ListaElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListaElementos extends ListRecords
{
    protected static string $resource = ListaElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
