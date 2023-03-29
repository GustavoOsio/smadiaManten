<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ShoppingCenter extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "shopping_centers";

    protected $fillable = [
        'name',
        'status'
    ];
}
