<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['user_id', 'title', 'date', 'comment', 'status'];

    public function users() {
        return $this->belongsToMany('App\User')->orderBy('name');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
