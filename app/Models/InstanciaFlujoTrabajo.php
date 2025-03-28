<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstanciaFlujoTrabajo extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'instancia_flujo_trabajo';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'es_final',
        'flujo_trabajo_id'
    ];

    // Relaciones
    public function flujoTrabajo():BelongsTo
    {
        return $this->belongsTo(FlujoTrabajo::class, 'flujo_trabajo_id');
    }
    
    public function instanciaPasoFlujo():HasMany
    {
        return $this->hasMany(InstanciaPasoFlujo::class, 'instancia_flujo_trabajo_id');
    }
   


}
