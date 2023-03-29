<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\InfirmaryNotes;
use Illuminate\Auth\Access\HandlesAuthorization;

class TextInformedConsentsPolicy
{
    use HandlesAuthorization;
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(76, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(76, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(76, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(76, 'delete'));
    }
}
