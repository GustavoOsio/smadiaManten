<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Retention extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'retention';
    protected $fillable =
        [
            'name',
            'value',
        ];
}
