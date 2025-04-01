<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permission extends ModelsPermission
{
    use HasFactory, SoftDeletes;

       /**
     * Relación con los roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }

    /**
     * Relación con los usuarios
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id');
    }
}
