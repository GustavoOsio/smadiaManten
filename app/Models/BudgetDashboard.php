<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BudgetDashboard extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'budgetdashboard';
    protected $fillable =
        [
            'mouth',
            'year',
            'value',
            'patients'
        ];
}
