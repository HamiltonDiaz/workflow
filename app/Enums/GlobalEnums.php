<?php

namespace App\Enums;

enum GlobalEnums
{
    case TIPO_DOCUMENTO;
    case ESTADO_TAREAS;
    case ESTADO_INSTANCIAS_PASOS;
    case ACTIVO_INSTANCIA_PASO;
    case PAUSA_INSTANCIA_PASO;
    case COMPLETO_INSTANCIA_PASO;

    public function value(): string|int
    {
        return match ($this) {
            self::TIPO_DOCUMENTO => 2,
            self::ESTADO_TAREAS => 1,
            self::ESTADO_INSTANCIAS_PASOS => 3,
            self::ACTIVO_INSTANCIA_PASO=>10,
            self::COMPLETO_INSTANCIA_PASO=>11,
            self::PAUSA_INSTANCIA_PASO=>12,
        };
    }
}