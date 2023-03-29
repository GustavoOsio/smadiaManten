<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'order_form';
    protected $fillable = [
        'user_id',
        'receive_id',
        'provider_id',
        'delivery',
        'cellar_id',
        'bill',
        'total',
        'discount',
        'payment_method',
        'way_of_pay',
        'days',
        'expiration',
        'account_id',
        'bank',
        'account',
        'center_cost_id',
        'status',
        'comment'
    ];

    public function products() {
        return $this->hasMany('App\Models\OrderFormProducts','order_form_id')
            ->whereIn('status',['new','older'])
            ->orderBy('id','asc');
    }
    public function products_new() {
        return $this->hasMany('App\Models\OrderFormProducts','order_form_id')
            ->whereIn('status',['new_2','complet'])
            ->orderBy('id','asc');
    }
    public function faltantes() {
        return $this->hasMany('App\Models\OrderFormProducts','order_form_id')
            ->where('status','fault');
    }
    public function new_fault() {
        return $this->hasMany('App\Models\OrderFormProducts','order_form_id')
            ->whereIn('status',['new','fault']);
    }
    public function newer() {
        return $this->hasMany('App\Models\OrderFormProducts','order_form_id')
            ->where('status','new');
    }
    public function connection() {
        return $this->hasMany('App\Models\OrderPurchaseConnection','order_form_id');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function receive() {
        return $this->belongsTo('App\User', 'receive_id');
    }
    public function provider() {
        return $this->belongsTo('App\Models\Provider');
    }
    public function center_cost() {
        return $this->belongsTo('App\Models\ShoppingCenter');
    }
    public function cellar() {
        return $this->belongsTo('App\Models\Cellar','cellar_id');
    }
}
