<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\Models\Expenses;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensesPolicy
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
        return in_array($user->role_id, MenuRol::permissions(33, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(33, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(33, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(33, 'delete'));
    }
}
