<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Systems extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'systems';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
}
