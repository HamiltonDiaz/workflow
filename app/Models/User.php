<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\GlobalEnums;
use App\Traits\SoftDeleteManagementTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles,SoftDeletes,SoftDeleteManagementTrait; //SoftDeleteManagementTrait: Metodo propio

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_documento',
        'numero_documento'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Relaciones
    public function listaElementos():BelongsTo
    {
        return $this->belongsTo(ListaElemento::class, 'tipo_documento')
        ->where('tipo_lista_elemento_id',GlobalEnums::TIPO_DOCUMENTO->value());
    }

    public function asignadoA():HasMany
    {
        return $this->hasMany(InstanciaTareaFlujo::class, 'asignado_a');
    }

    public function asignadoPor():HasMany
    {
        return $this->hasMany(InstanciaTareaFlujo::class, 'asignado_por');
    }

    public function historicoTareas():HasMany
    {
        return $this->hasMany(HistoricoTarea::class, 'user_id');
    }

    public function comentario():HasMany
    {
        return $this->hasMany(Comentario::class, 'user_id');
    }

    

}
