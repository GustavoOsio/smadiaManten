<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PurchaseOrder extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'receive_id',
        'user_id',
        'provider_id',
        'method_of_payment',
        'way_of_payment',
        'delivery',
        'area',
        'comment',
        'status',
        'id_purchase'
    ];

    public function products() {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function receive() {
        return $this->belongsTo('App\User', 'receive_id');
    }

    public function provider() {
        return $this->belongsTo('App\Models\Provider');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
