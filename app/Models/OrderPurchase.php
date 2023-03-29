<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderPurchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "purchase_orders";

    protected $fillable = [
        'receive_id',
        'user_id',
        'provider_id',
        'method_of_payment',
        'delivery',
        'area',
        'comment',
        'status',
        'id_order',
        'id_purchase'
    ];

    public function products() {
        return $this->hasMany('App\Models\OrderProduct', 'purchase_order_id');
    }

    public function receive() {
        return $this->belongsTo('App\User', 'receive_id');
    }

    public function provider() {
        return $this->belongsTo('App\models\Provider');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
