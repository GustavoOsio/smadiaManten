<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Blood extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //

    public $timestamps = false;
}
