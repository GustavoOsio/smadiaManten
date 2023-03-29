<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\Provider;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(11, 'visible'));
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(11, 'create'));
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(11, 'update'));
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(11, 'delete'));
    }

    /**
     * Determine whether the user can restore the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
