<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(22, 'visible'));
    }

    /**
     * Determine whether the user can create medicines.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(22, 'create'));
    }

    /**
     * Determine whether the user can update the medicine.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Medicine  $medicine
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(22, 'update'));
    }

    /**
     * Determine whether the user can delete the medicine.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Medicine  $medicine
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(22, 'delete'));
    }

    /**
     * Determine whether the user can restore the medicine.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Medicine  $medicine
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the medicine.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Medicine  $medicine
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
