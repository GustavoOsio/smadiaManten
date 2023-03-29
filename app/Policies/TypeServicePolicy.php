<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\TypeService;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypeServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the type service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TypeService  $typeService
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(14, 'visible'));
    }

    /**
     * Determine whether the user can create type services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(14, 'create'));
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
        return in_array($user->role_id, MenuRol::permissions(14, 'update'));
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
        return in_array($user->role_id, MenuRol::permissions(14, 'delete'));
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
