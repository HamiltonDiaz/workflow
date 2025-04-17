<?php

namespace App\Filament\Resources\InstanciaPasoFlujoResource\Pages;

use App\Filament\Resources\InstanciaPasoFlujoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInstanciaPasoFlujo extends CreateRecord
{
    //TODO: Si el flujo solo tiene un paso no puede dejar copiar el workflow a las instancias
    protected static string $resource = InstanciaPasoFlujoResource::class;
}
