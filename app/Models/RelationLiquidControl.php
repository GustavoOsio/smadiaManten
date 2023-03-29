<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationLiquidControl extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_liquid_control';
    protected $primaryKey = 'id';
    protected $fillable = [
        'liquid_control_id',
        'hour',
        'type',
        'type_element',
        'box',
    ];
}