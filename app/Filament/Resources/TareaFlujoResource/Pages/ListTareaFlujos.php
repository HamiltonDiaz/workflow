<?php

namespace App\Filament\Resources\TareaFlujoResource\Pages;

use App\Filament\Resources\TareaFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTareaFlujos extends ListRecords
{
    protected static string $resource = TareaFlujoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
