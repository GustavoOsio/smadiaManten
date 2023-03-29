<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesComisionesPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(72, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(72, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(72, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(72, 'delete'));
    }
}
