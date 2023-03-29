<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Type extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'name',
        'type',
        'status',
        'p_deducible_t',
        'p_deducible_no',
        'p_comision'
    ];
}
