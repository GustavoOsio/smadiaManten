<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\Issue;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Issue  $issue
     * @return mixed
     */
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(8, 'visible'));
    }

    /**
     * Determine whether the user can create issues.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(8, 'create'));
    }

    /**
     * Determine whether the user can update the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Issue  $issue
     * @return mixed
     */
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(8, 'update'));
    }

    /**
     * Determine whether the user can delete the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Issue  $issue
     * @return mixed
     */
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(8, 'delete'));
    }

    /**
     * Determine whether the user can restore the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Issue  $issue
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the issue.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Issue  $issue
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
