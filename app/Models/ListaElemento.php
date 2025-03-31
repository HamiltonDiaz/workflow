<?php

namespace App\Models;

use App\Traits\SoftDeleteManagementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;



class ListaElemento extends Model
{
    use  HasFactory, SoftDeletes,SoftDeleteManagementTrait; //SoftDeleteManagementTrait: Metodo propio
    protected $table = 'lista_elementos';

    protected $fillable = [
        'nombre',
        'tipo_lista_elemento_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si el usuario tiene registros en otras tablas relacionadas
            if ($register->user()->exists() || $register->instanciaPasoFlujo()->exists() || $register->instanciaTareasFlujo()->exists()) {
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
    public function tipoListaElemento(): BelongsTo
    {
        return $this->belongsTo(TipoListaElemento::class, 'tipo_lista_elemento_id');
    }


    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'tipo_documento');
    }

    public function instanciaPasoFlujo(): HasMany
    {
        return $this->hasMany(InstanciaPasoFlujo::class, 'estado');
    }

    public function instanciaTareasFlujo(): HasMany
    {
        return $this->hasMany(InstanciaTareaFlujo::class, 'estado');
    }
}
