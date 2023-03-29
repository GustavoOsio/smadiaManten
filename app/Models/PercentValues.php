<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PercentValues extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'percent_values';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'value',
    ];
}
