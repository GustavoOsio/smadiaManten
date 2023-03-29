<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ElectronicEquipment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        "name",
        "number",
        "brand",
        "model",
        "serial",
        "voltage",
        "location",
        "equips_active"
    ];
}
