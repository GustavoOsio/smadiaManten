<?php

namespace App\Policies;

use App\Helpers\MenuRol;
use App\Models\BudgetDashboard;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetDashboardPolicy
{
    use HandlesAuthorization;

    protected $role;

    public function __construct(BudgetDashboard $BudgetDashboard)
    {
        $this->BudgetDashboard = $BudgetDashboard;
    }

    public function view(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(28, 'visible'));
    }

    public function create(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(28, 'create'));
    }

    public function update(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(28, 'update'));
    }

    public function delete(User $user)
    {
        return in_array($user->role_id, MenuRol::permissions(28, 'delete'));
    }
}
