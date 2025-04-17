<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstanciaTareaFlujo extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'instancia_tareas_flujo';


    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_vencimiento',
        'orden',
        'ruta_archivo',
        'es_final',
        'instancia_paso_flujo_id',
        'estado',
        'asignado_a',
        'asignado_por',
    ];

    // Relaciones
    public function instanciaPasoFlujo():BelongsTo
    {
        return $this->belongsTo(InstanciaPasoFlujo::class,'instancia_paso_flujo_id');
    }

    public function estado():BelongsTo
    {
        return $this->belongsTo(ListaElemento::class, 'estado');
    }

    public function asignadoA():BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function asignadoPor():BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_por');
    }

    public function comentarios():HasMany
    {
        return $this->hasMany(Comentario::class, 'instancia_tareas_flujo_id');
    }

    public function historial():HasMany
    {
        return $this->hasMany(HistoricoTarea::class, 'instancia_tareas_flujo_id');
    }

}
