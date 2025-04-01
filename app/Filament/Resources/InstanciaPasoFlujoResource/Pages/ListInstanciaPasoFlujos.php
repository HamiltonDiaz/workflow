<?php

namespace App\Filament\Resources\InstanciaPasoFlujoResource\Pages;

use App\Filament\Resources\InstanciaPasoFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInstanciaPasoFlujos extends ListRecords
{
    protected static string $resource = InstanciaPasoFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
