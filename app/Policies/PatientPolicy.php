<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(15, 'visible'));
    }

    /**
     * Determine whether the user can create type services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(15, 'create'));
    }

    /**
     * Determine whether the user can update the type service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TypeService  $typeService
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(15, 'update'));
    }

    /**
     * Determine whether the user can delete the type service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TypeService  $typeService
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(15, 'delete'));
    }

    /**
     * Determine whether the user can restore the type service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TypeService  $typeService
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the type service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TypeService  $typeService
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
