<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\Models\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(2, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(2, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(2, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(2, 'delete'));
    }
}
