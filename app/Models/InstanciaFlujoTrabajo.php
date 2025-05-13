<?php

namespace App\Models;

use App\Enums\GlobalEnums;
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
        'flujo_trabajo_id',
        'consecutivo'
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

        static::creating(function ($model) {
            $date = now()->format('Ymd');
            $lastConsecutive = static::where('consecutivo', 'like', $date . '%')
                ->orderBy('consecutivo', 'desc')
                ->first();
    
            if ($lastConsecutive) {
                // Extraer el número secuencial y aumentarlo
                $sequence = (int)substr($lastConsecutive->consecutivo, 8) + 1;
            } else {
                $sequence = 1;
            }
    
            // Generar el nuevo consecutivo
            do {
                $newConsecutive = $date . str_pad($sequence, 5, '0', STR_PAD_LEFT);
                $exists = static::where('consecutivo', $newConsecutive)->exists();
                if ($exists) {
                    $sequence++;
                }
            } while ($exists);
    
            $model->consecutivo = $newConsecutive;
        });        
    }    

    // Relaciones
    public function flujoTrabajo():BelongsTo
    {
        return $this->belongsTo(FlujoTrabajo::class, 'flujo_trabajo_id')
        ->where('id','!=' , GlobalEnums::FLUJO_GENERAL->value());
    }
    
    public function instanciaPasoFlujo():HasMany
    {
        return $this->hasMany(InstanciaPasoFlujo::class, 'instancia_flujo_trabajo_id');
    }
   


}
