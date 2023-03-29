<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
      'monitoring_id',
      'user_id',
      'responsable_id',
      'date',
      'comment'
    ];

    public function responsable() {
        return $this->belongsTo('App\User', 'responsable_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
