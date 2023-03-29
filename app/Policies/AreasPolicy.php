<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use App\Models\Anamnesis;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreasPolicy
{
    use HandlesAuthorization;
    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(69, 'visible'));
    }
    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(69, 'create'));
    }
    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(69, 'update'));
    }
    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(69, 'delete'));
    }
}
