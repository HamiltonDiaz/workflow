<?php

namespace App\Models;

use App\Traits\SoftDeleteManagementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TareaFlujo extends Model
{
    use  HasFactory, SoftDeletes;    
    use SoftDeleteManagementTrait; //Metodo propio
    protected $table = 'tareas_flujo';

    protected $fillable = [
        'titulo',
        'descripcion',
        'es_editable',        
        'orden',
        'es_final',
        'pasos_flujo_id',
        
    ];

    // Relaciones
    public function pasoFlujo():BelongsTo
    {
        return $this->belongsTo(PasoFlujo::class,'pasos_flujo_id');
    }

    public static function buscarOrden($pasoId, $ordenActual = null)
    {        
        $resultado = self::where('pasos_flujo_id', $pasoId)
                    ->where('deleted_at', null)            
                    ->count();
        
        // Si no hay registros, retornar array con el número 1
        if ($resultado == 0) {
            return [1];
        }       

        $maximo = self::where('pasos_flujo_id', $pasoId)
                ->where('deleted_at', null)    
                ->max('orden');

        // Obtener todos los órdenes existentes excepto el actual (si existe)
        $query = self::where('pasos_flujo_id', $pasoId)
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
