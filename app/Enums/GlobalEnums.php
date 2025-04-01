<?php

namespace App\Enums;

enum GlobalEnums
{
    case TIPO_DOCUMENTO;
    case ESTADO_TAREAS;
    case ESTADO_PASOS;

    public function value(): string|int
    {
        return match ($this) {
            self::TIPO_DOCUMENTO => 2,
            self::ESTADO_TAREAS => 1,
            self::ESTADO_PASOS => 3,
        };
    }
}