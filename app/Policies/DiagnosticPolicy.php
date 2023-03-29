<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\Diagnostic;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiagnosticPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the diagnostic.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Diagnostic  $diagnostic
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(7, 'visible'));
    }

    /**
     * Determine whether the user can create diagnostics.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(7, 'create'));
    }

    /**
     * Determine whether the user can update the diagnostic.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Diagnostic  $diagnostic
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(7, 'update'));
    }

    /**
     * Determine whether the user can delete the diagnostic.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Diagnostic  $diagnostic
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(7, 'delete'));
    }

    /**
     * Determine whether the user can restore the diagnostic.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Diagnostic  $diagnostic
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the diagnostic.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Diagnostic  $diagnostic
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
