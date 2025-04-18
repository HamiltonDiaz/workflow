<?php

namespace App\Models;

use App\Traits\SoftDeleteManagementTrait;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstanciaFlujoTrabajo extends Model
{
    use  HasFactory, SoftDeletes;
    use SoftDeleteManagementTrait; //Metodo propio
    protected $table = 'instancia_flujo_trabajo';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'es_final',
        'flujo_trabajo_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si tiene registros en otras tablas relacionadas
            if ($register->instanciaPasoFlujo()->exists()) {
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
        return $this->belongsTo(FlujoTrabajo::class, 'flujo_trabajo_id');
    }
    
    public function instanciaPasoFlujo():HasMany
    {
        return $this->hasMany(InstanciaPasoFlujo::class, 'instancia_flujo_trabajo_id');
    }
   


}
