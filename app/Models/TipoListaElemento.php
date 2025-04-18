<?php

namespace App\Models;

use App\Traits\SoftDeleteManagementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Notifications\Notification;

class TipoListaElemento extends Model
{

    use  HasFactory, SoftDeletes, SoftDeleteManagementTrait; //SoftDeleteManagementTrait: Metodo propio
    protected $table = 'tipo_lista_elementos';


    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si tiene registros en otras tablas relacionadas
            if ($register->listaElementos()->exists()) {
                Notification::make()
                    ->title('Error al eliminar')
                    ->danger()
                    ->body('No se puede eliminar porque tiene registros asociados.')
                    ->send();
                return false; // Cancela la eliminación
            }
        });
    }


    //Relaciones    
    public function listaElementos(): HasMany
    {
        return $this->hasMany(ListaElemento::class, 'tipo_lista_elemento_id');
    }
}
