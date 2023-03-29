<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(29, 'visible'));
    }

    /**
     * Determine whether the user can create center costs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(29, 'create'));
    }

    /**
     * Determine whether the user can update the center cost.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CenterCost  $centerCost
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(29, 'update'));
    }

    /**
     * Determine whether the user can delete the center cost.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CenterCost  $centerCost
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(29, 'delete'));
    }

    /**
     * Determine whether the user can restore the center cost.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CenterCost  $centerCost
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the center cost.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CenterCost  $centerCost
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
