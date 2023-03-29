<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(12, 'visible'));
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(12, 'create'));
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(12, 'update'));
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(12, 'delete'));
    }

    /**
     * Determine whether the user can restore the service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the service.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Service  $service
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
