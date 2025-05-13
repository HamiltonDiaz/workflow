<?php

namespace App\Models;

use App\Enums\GlobalEnums;
use App\Traits\BuscarOrdenTrait;
use App\Traits\SoftDeleteManagementTrait;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Type\Integer;

class PasoFlujo extends Model
{
    use  HasFactory, SoftDeletes;
    use SoftDeleteManagementTrait, BuscarOrdenTrait; //Metodo propio
    protected $table = 'pasos_flujo';


    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'es_final',
        'flujo_trabajo_id',
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si tiene registros en otras tablas relacionadas
            if ($register->tareasFlujo()->exists()) {
                Notification::make()
                    ->title('Error al eliminar')
                    ->danger()
                    ->body('No se puede eliminar porque tiene registros asociados.')
                    ->send();
                return false; // Cancela la eliminación
            }
        });
    }

    // Relaciones
    public function flujoTrabajo():BelongsTo
    {
        return $this->belongsTo(FlujoTrabajo::class, 'flujo_trabajo_id')
        ->where('id','!=' , GlobalEnums::FLUJO_GENERAL->value());
    }
    
    public function tareasFlujo():HasMany
    {
        return $this->hasMany(TareaFlujo::class, 'pasos_flujo_id');
    }

}
