<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;



class ListaElemento extends Model
{
    use  HasFactory, SoftDeletes;
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


    //Métodos de validación del modelo

    public static function deletedRegister($data)
    {
        $nombre = $data['nombre'];
        $tipo_elemento_id = $data['tipo_lista_elemento_id'];

        $query = self::withTrashed()
            ->where('nombre', $nombre)
            ->where('tipo_lista_elemento_id', $tipo_elemento_id);


        $existingRegister = $query->first();
        if ($existingRegister && $existingRegister->trashed()) {
            //Se restaura el archivo eliminado

            // Si es una actualización modificar el registro eliminado
            if (!empty($data['id'])) {
                if ($existingRegister->id!=$data['id']){
                    $existingRegister->nombre=$existingRegister->nombre . ' (reutilizado en el id ' . $data['id'] . ' el ' . now();
                    $existingRegister->save();
                }               
            }else{
                $existingRegister->restore();
            }
            //Cuando es edición se elmina el registro actual
            return $existingRegister;
        }
        return null;
    }

    public static function duplicatedRegister($data)
    {
        $nombre = $data['nombre'];
        $tipo_elemento_id = $data['tipo_lista_elemento_id'];

        $query = self::withoutTrashed()
            ->where('nombre', $nombre)
            ->where('tipo_lista_elemento_id', $tipo_elemento_id); 

        // Si es una actualización, ignorar el registro actual
        if (!empty($data['id'])) {
            $query->where('id', '!=', $data['id']);
        }

        if ($query->first()) {
            return true;
        }
        return false;
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
