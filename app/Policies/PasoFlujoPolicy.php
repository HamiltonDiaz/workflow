<?php

namespace App\Policies;

use App\Models\PasoFlujo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PasoFlujoPolicy
{

    protected string $model;

    public function __construct()
    {
        $className = PasoFlujo::class;
        $parts = explode('\\', $className);
        $this->model = strtolower(end($parts));
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can($this->model . '.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PasoFlujo $pasoFlujo): bool
    {
        return $user->can($this->model . '.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can($this->model . '.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PasoFlujo $pasoFlujo): bool
    {
        return $user->can($this->model . '.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PasoFlujo $pasoFlujo): bool
    {
        return $user->can($this->model . '.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PasoFlujo $pasoFlujo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PasoFlujo $pasoFlujo): bool
    {
        return false;
    }
}
