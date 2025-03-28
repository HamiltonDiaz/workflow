<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListaElemento extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'lista_elementos';

    protected $fillable = [
        'nombre',
        'tipo_lista_elemento_id'
    ];


    public function tipoListaElemento():BelongsTo
    {
        return $this->belongsTo(User::class, 'tipo_lista_elemento_id');
    }


    public function user():HasMany
    {
        return $this->hasMany(User::class, 'tipo_documento');
    }

    public function instanciaPasoFlujo():HasMany
    {
        return $this->hasMany(InstanciaPasoFlujo::class, 'estado');
    }

    public function instanciaTareasFlujo():HasMany
    {
        return $this->hasMany(InstanciaTareaFlujo::class, 'estado');
    }

}
