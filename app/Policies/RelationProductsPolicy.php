<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\Models\SaleProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RelationProductsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the bank.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Bank  $bank
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(56, 'visible'));
    }

    /**
     * Determine whether the user can create banks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(56, 'create'));
    }

    /**
     * Determine whether the user can update the bank.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Bank  $bank
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(56, 'update'));
    }

    /**
     * Determine whether the user can delete the bank.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Bank  $bank
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(56, 'delete'));
    }

    /**
     * Determine whether the user can restore the bank.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Bank  $bank
     * @return mixed
     */
    public function restore(User $user, SaleProduct $bank)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the bank.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Bank  $bank
     * @return mixed
     */
    public function forceDelete(User $user, SaleProduct $bank)
    {
        //
    }
}
