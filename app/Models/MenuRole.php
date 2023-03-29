<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MenuRole extends Pivot
{
    //

    protected $fillable = ['role_id', 'menu_id', 'visible', 'create', 'update', 'delete'];

    public $timestamps = false;
}
