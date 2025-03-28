<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoListaElemento extends Model
{
    
    use  HasFactory, SoftDeletes;
    protected $table = 'tipo_lista_elementos';


    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    
    
    public function listaElementos():HasMany
    {
        return $this->hasMany(ListaElemento::class, 'tipo_lista_elemento_id');
    }

    
    
}
