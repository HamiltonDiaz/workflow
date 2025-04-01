<?php

namespace App\Traits;
/**
 * Trait SoftDeleteManagementTrait
 * 
 * Este trait es de elaboración propia y proporciona métodos para gestionar registros eliminados
 * de manera lógica (soft delete) en modelos de Eloquent. Incluye funcionalidades para verificar
 * y restaurar registros eliminados, así como para detectar duplicados basados en criterios específicos.
 */
trait SoftDeleteManagementTrait
{
    /**
     * Verifica si existe un registro eliminado con los mismos criterios y lo restaura si es necesario
     * 
     * @param array $data Datos del registro
     * @param array|null $fields Campos a usar para la verificación ['campo1', 'campo2',...]
     * @return mixed|null El registro restaurado o null
     */
    public function deletedRegister($data, ?array $fields = null)
    {

        if ($fields) {
            $query = static::withTrashed();
            // Aplicar condiciones dinámicamente según los campos
            foreach ($fields as $field) {
                if (isset($data[$field])) {
                    $query->where($field, $data[$field]);
                }
            }

            $existingRegister = $query->first();

            if ($existingRegister && $existingRegister->trashed()) {
                // Si es una actualización, modificar el registro eliminado
                if (!empty($data['id'])) {
                    if ($existingRegister->id != $data['id']) {
                        $existingRegister->nombre = $existingRegister->nombre . ' (reutilizado en el id ' . $data['id'] . ' el ' . now() . ')';
                        $existingRegister->save();
                    }
                } else {
                    $existingRegister->restore();
                }
                return $existingRegister;
            }
        }
        return null;
    }

    /**
     * Verifica si existe un registro duplicado con los mismos criterios
     * 
     * @param array $data Datos del registro
     * @param array|null $fields Campos a usar para la verificación ['campo1', 'campo2',...]
     * @return bool True si existe un duplicado, False en caso contrario
     */
    public function duplicatedRegister($data, ?array $fields = null)
    {
        if ($fields) {
            $query = static::withoutTrashed();

            // Aplicar condiciones dinámicamente según los campos
            foreach ($fields as $field) {
                if (isset($data[$field])) {
                    $query->where($field, $data[$field]);
                }
            }
            // Si es una actualización, ignorar el registro actual
            if (!empty($data['id'])) {
                $query->where('id', '!=', $data['id']);
            }
            return $query->exists();
        }
    }
}
