<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TareaFlujo extends Model
{
    use  HasFactory, SoftDeletes;    
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

    

}
