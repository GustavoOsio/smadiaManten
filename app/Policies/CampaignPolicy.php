<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
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
        return in_array($user->role_id, MenuRol::permissions(63, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(63, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(63, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(63, 'delete'));
    }
}
