<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Purchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'cellar_id',
        'provider_id',
        'user_id',
        'bill',
        'total',
        'balance',
        'discount',
        'payment_method',
        'way_of_pay',
        'days',
        'expiration',
        'account_id',
        'bank',
        'account',
        'center_cost_id',
        'comment',
        'status',
        'order_form_id'
    ];

    public function products() {
        return $this->hasMany('App\Models\PurchaseProduct','purchase_id');
    }

    public function provider() {
        return $this->belongsTo('App\Models\Provider');
    }

    public function cellar() {
        return $this->belongsTo('App\Models\Cellar');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function center_cost() {
        return $this->belongsTo('App\Models\ShoppingCenter');
    }
}
