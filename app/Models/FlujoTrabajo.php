<?php

namespace App\Models;

use App\Traits\SoftDeleteManagementTrait;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlujoTrabajo extends Model
{
    use  HasFactory, SoftDeletes;
    use SoftDeleteManagementTrait; //Metodo propio
    protected $table = 'flujo_trabajo';


    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si tiene registros en otras tablas relacionadas
            if ($register->pasosFlujo()->exists() || $register->instanciaFlujoTrabajo()->exists()) {
                Notification::make()
                    ->title('Error al eliminar')
                    ->danger()
                    ->body('No se puede eliminar porque tiene registros asociados.')
                    ->send();
                return false; // Cancela la eliminación
            }
        });
    }


    public function pasosFlujo():HasMany
    {
        return $this->hasMany(PasoFlujo::class, 'flujo_trabajo_id');
    }

    public function instanciaFlujoTrabajo():HasMany
    {
        return $this->hasMany(InstanciaFlujoTrabajo::class, 'flujo_trabajo_id');
    }

}
