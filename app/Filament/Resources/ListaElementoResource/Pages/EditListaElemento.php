<?php

namespace App\Filament\Resources\ListaElementoResource\Pages;

use App\Filament\Resources\ListaElementoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditListaElemento extends EditRecord
{
    protected static string $resource = ListaElementoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
