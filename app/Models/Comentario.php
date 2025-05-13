<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Comentario extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'comentarios';

    

    protected static function booted()
    {
        static::creating(function ($comentario) {
            $comentario->user_id = Auth::user()->id;
            HistoricoTarea::create([
                'descripcion' => 'Usuario agrega comentario el ' . now()->format('d/m/Y H:i'),
                'instancia_tareas_flujo_id' => $comentario->instancia_tareas_flujo_id,
                'user_id' => $comentario->user_id
            ]);
        });

        static::updating(function ($comentario) {
            $comentario->user_id =Auth::user()->id;
            HistoricoTarea::create([
                'descripcion' => 'Usuario modifica comentario el ' . now()->format('d/m/Y H:i'),
                'instancia_tareas_flujo_id' => $comentario->instancia_tareas_flujo_id,
                'user_id' => $comentario->user_id
            ]);
        });
    }
    
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
