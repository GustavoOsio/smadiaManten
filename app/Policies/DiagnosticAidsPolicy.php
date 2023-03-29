<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\DiagnosticAids;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiagnosticAidsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the laboratory.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratory  $laboratory
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(36, 'visible'));
    }

    /**
     * Determine whether the user can create laboratories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(36, 'create'));
    }

    /**
     * Determine whether the user can update the laboratory.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratory  $laboratory
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(36, 'update'));
    }

    /**
     * Determine whether the user can delete the laboratory.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratory  $laboratory
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(36, 'delete'));
    }

    /**
     * Determine whether the user can restore the laboratory.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratory  $laboratory
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the laboratory.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratory  $laboratory
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
