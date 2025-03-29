<?php

namespace App\Filament\Resources\PasoFlujoResource\Pages;

use App\Filament\Resources\PasoFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPasoFlujos extends ListRecords
{
    protected static string $resource = PasoFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
