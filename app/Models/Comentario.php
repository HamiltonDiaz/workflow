<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'comentarios';

    
    protected $fillable = [
        'descripcion',
        'instancia_tareas_flujo_id',
        'user_id'
    ];

    // Relaciones
    public function instanciaTareaFlujo():BelongsTo
    {
        return $this->belongsTo(InstanciaTareaFlujo::class, 'instancia_tareas_flujo_id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
