<?php

namespace App\Traits;

/**
 * Trait BuscarOrdenTrait
 * 
 * Este trait proporciona funcionalidad para buscar y gestionar órdenes secuenciales en un flujo.
 * 
 * @package App\Traits
 */
trait BuscarOrdenTrait
{
    /**
     * Busca números de orden disponibles para un flujo específico
     *
     * Este método determina qué números de orden están disponibles en un flujo dado,
     * considerando los órdenes ya existentes y opcionalmente excluyendo un orden actual.
     * 
     * @param mixed $idBusqueda       El ID de la tabla que agrupa los registros el cual se buscan órdenes disponibles
     * @param int|null $ordenActual    El número de orden actual que se debe excluir de la búsqueda (opcional)
     * @param string $llaveBusqueda    La columna que se utilizará como clave para la búsqueda
     * 
     * @return array Retorna un array con los números de orden disponibles:
     *               - Si no hay registros, retorna [1]
     *               - Si hay registros, retorna un array con todos los números disponibles
     *               - Si no hay números disponibles, retorna [máximo + 1]
     * 
     * @example
     * // Buscar órdenes disponibles para el flujo 1
     * $ordenesDisponibles = BuscarOrdenTrait::buscarOrden(1, null, 'flujo_id');
     * 
     * // Buscar órdenes disponibles excluyendo el orden actual 3
     * $ordenesDisponibles = BuscarOrdenTrait::buscarOrden(1, 3, 'flujo_id');
     */
    public static function buscarOrden($idBusqueda, $ordenActual = null, $llaveBusqueda)
    {
        $resultado = self::where($llaveBusqueda, $idBusqueda)
            ->where('deleted_at', null)
            ->count();

        // Si no hay registros, retornar array con el número 1
        if ($resultado == 0) {
            return [1];
        }

        $maximo = self::where($llaveBusqueda, $idBusqueda)
            ->where('deleted_at', null)
            ->max('orden');

        // Obtener todos los órdenes existentes excepto el actual (si existe)
        $query = self::where($llaveBusqueda, $idBusqueda)
            ->where('deleted_at', null);
        if ($ordenActual) {
            $query->where('orden', '!=', $ordenActual);
        }
        $ordenesExistentes = $query->pluck('orden')->toArray();

        // Crear array con números disponibles
        $numerosDisponibles = [];
        for ($i = 1; $i <= $maximo + 1; $i++) {
            if (!in_array($i, $ordenesExistentes) || $i == $ordenActual) {
                $numerosDisponibles[] = $i;
            }
        }

        return empty($numerosDisponibles) ? [$maximo + 1] : $numerosDisponibles;
    }
}
