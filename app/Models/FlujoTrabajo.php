<?php

namespace App\Models;

use App\Traits\SoftDeleteManagementTrait;
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


    public function pasosFlujo():HasMany
    {
        return $this->hasMany(PasoFlujo::class, 'flujo_trabajo_id');
    }

    public function instanciaFlujoTrabajo():HasMany
    {
        return $this->hasMany(InstanciaFlujoTrabajo::class, 'flujo_trabajo_id');
    }

}
