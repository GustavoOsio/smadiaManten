<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sucess extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'sucess';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'observation',
    ];

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
}
