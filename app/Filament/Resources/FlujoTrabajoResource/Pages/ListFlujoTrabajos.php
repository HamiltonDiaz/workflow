<?php

namespace App\Filament\Resources\FlujoTrabajoResource\Pages;

use App\Filament\Resources\FlujoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlujoTrabajos extends ListRecords
{
    protected static string $resource = FlujoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
