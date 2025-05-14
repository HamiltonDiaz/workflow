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

class InstanciaPasoFlujo extends Model
{
    use  HasFactory, SoftDeletes;
    use SoftDeleteManagementTrait, BuscarOrdenTrait; //Metodo propio
    protected $table = 'instancia_paso_flujo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'es_final',
        'instancia_flujo_trabajo_id',
        'estado',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si tiene registros en otras tablas relacionadas
            if ($register->instanciaTareasFlujo()->exists()) {
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
    public function instanciaFlujoTrabajo(): BelongsTo
    {
        return $this->belongsTo(InstanciaFlujoTrabajo::class, 'instancia_flujo_trabajo_id');
    }

    public function listaElementos(): BelongsTo
    {
        return $this->belongsTo(ListaElemento::class, 'estado')
        ->where('tipo_lista_elemento_id',GlobalEnums::ESTADO_INSTANCIAS_PASOS->value());;
    }

    public function instanciaTareasFlujo(): HasMany
    {
        return $this->hasMany(InstanciaTareaFlujo::class, 'instancia_paso_flujo_id');
    }
}
