<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Consumed extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "consumed";

    protected $fillable = ['schedule_id','contract_id', 'amount', 'sessions', 'session'];
}
