<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\InfirmaryNotes;
use Illuminate\Auth\Access\HandlesAuthorization;

class InformedConsentsPolicy
{
    use HandlesAuthorization;
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(75, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(75, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(75, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(75, 'delete'));
    }
}
