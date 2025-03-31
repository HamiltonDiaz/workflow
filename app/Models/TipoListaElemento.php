<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Notifications\Notification;

class TipoListaElemento extends Model
{

    use  HasFactory, SoftDeletes;
    protected $table = 'tipo_lista_elementos';


    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($register) {
            // Verifica si el usuario tiene registros en otras tablas relacionadas
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

    //Métodos de validación del modelo

    public static function deletedRegister($data)
    {
        $nombre = $data['nombre'];        
        $query = self::withTrashed()->where('nombre', $nombre);

        $existingRegister = $query->first();
        if ($existingRegister && $existingRegister->trashed()) {
            // Si es una actualización modificar el registro eliminado
            if (!empty($data['id'])) {
                if ($existingRegister->id != $data['id']) {
                    $existingRegister->nombre = $existingRegister->nombre . ' (reutilizado en el id ' . $data['id'] . ' el ' . now();
                    $existingRegister->save();
                }
            } else {
                //Se restaura el archivo eliminado
                $existingRegister->restore();
            }
            return $existingRegister;
        }
        return null;
    }

    public static function duplicatedRegister($data)
    {
        $nombre = $data['nombre'];
        $query = self::withoutTrashed()
            ->where('nombre', $nombre);//self:: es para llamar el mismo modelo de la clase

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
    public function listaElementos(): HasMany
    {
        return $this->hasMany(ListaElemento::class, 'tipo_lista_elemento_id');
    }
}
