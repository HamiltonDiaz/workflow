<?php

namespace App\Enums;

enum PermissionActionEnum: string
{
    case VIEW = 'view';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case EXPORT = 'export';
    case IMPORT = 'import';
    case PUBLISH = 'publish';
    
    
    /**
     * Obtener todas las acciones como array para selects
     */
    public static function asSelectArray(): array
    {
        return [
            self::VIEW->value => 'Ver',
            self::CREATE->value => 'Crear',
            self::UPDATE->value => 'Actualizar',
            self::DELETE->value => 'Eliminar',
            self::EXPORT->value => 'Exportar',
            self::IMPORT->value => 'Importar',
            self::PUBLISH->value => 'Publicar',            
        ];
    }
    
    /**
     * Obtener la etiqueta en español para un valor dado
     */
    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::VIEW->value => 'Ver',
            self::CREATE->value => 'Crear',
            self::UPDATE->value => 'Actualizar',
            self::DELETE->value => 'Eliminar',
            self::EXPORT->value => 'Exportar',
            self::IMPORT->value => 'Importar',
            self::PUBLISH->value => 'Publicar',            
            default => $value,
        };
    }
}