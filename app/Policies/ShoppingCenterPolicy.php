<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\ShoppingCenter;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShoppingCenterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the shopping center.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ShoppingCenter  $shoppingCenter
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(13, 'visible'));
    }

    /**
     * Determine whether the user can create shopping centers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(13, 'create'));
    }

    /**
     * Determine whether the user can update the shopping center.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ShoppingCenter  $shoppingCenter
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(13, 'update'));
    }

    /**
     * Determine whether the user can delete the shopping center.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ShoppingCenter  $shoppingCenter
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(13, 'delete'));
    }

    /**
     * Determine whether the user can restore the shopping center.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ShoppingCenter  $shoppingCenter
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the shopping center.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ShoppingCenter  $shoppingCenter
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
