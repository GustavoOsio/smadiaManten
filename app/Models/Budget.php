<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Budget extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'patient_id',
        'seller_id',
        'user_id',
        'amount',
        'comment',
        'additional',
        'date_expiration',
        'status',
        'obsequio',
        'obsequioDos',
        'CantidadObsequio1',
        'CantidadObsequio2',
        'anestesia'
    ];

    public function items() {
        return $this->hasMany('App\Models\Item');
    }

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }
}
