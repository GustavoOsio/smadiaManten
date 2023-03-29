<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //

    protected $fillable = ['name', 'superadmin', 'status'];

    public function users() {
        return $this->hasMany('App\User');
    }
    public function menus() {
        return $this->belongsToMany('App\Models\Menu');
    }
}
