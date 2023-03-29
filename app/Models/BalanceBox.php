<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BalanceBox extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'balance_box';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'con_id',
        'type',
        'monto',
        'date',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
