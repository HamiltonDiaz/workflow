<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstanciaPasoFlujo extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'instancia_paso_flujo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'es_final',
        'instancia_flujo_trabajo_id',
        'estado',
    ];

    // Relaciones
    public function instanciaFlujoTrabajo(): BelongsTo
    {
        return $this->belongsTo(InstanciaFlujoTrabajo::class, 'instancia_flujo_trabajo_id');
    }

    public function instanciaTareasFlujo(): HasMany
    {
        return $this->hasMany(InstanciaTareaFlujo::class, 'instancia_paso_flujo_id');
    }
}
