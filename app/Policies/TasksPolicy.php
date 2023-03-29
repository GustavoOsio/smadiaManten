<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TasksPolicy
{
    use HandlesAuthorization;

    //protected $role;
    /*
    public function __construct(Expenses $Expenses)
    {
        $this->Expenses = $Expenses;
    }
    */

    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(64, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(64, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(64, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(64, 'delete'));
    }
}
