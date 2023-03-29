<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\ContactSource;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactSourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the contact source.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ContactSource  $contactSource
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(6, 'visible'));
    }

    /**
     * Determine whether the user can create contact sources.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(6, 'create'));
    }

    /**
     * Determine whether the user can update the contact source.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ContactSource  $contactSource
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(6, 'update'));
    }

    /**
     * Determine whether the user can delete the contact source.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ContactSource  $contactSource
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(6, 'delete'));
    }

    /**
     * Determine whether the user can restore the contact source.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ContactSource  $contactSource
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the contact source.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ContactSource  $contactSource
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
