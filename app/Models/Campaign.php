<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Campaign extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = 'campaign';
    protected $fillable = [
        'name',
        'text',
        'status'
    ];
}
