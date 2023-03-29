<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderReceipt extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'order_receipt';
    protected $fillable = [
        'user_id',
        'order_form_id',
        'observations',
    ];
    public function order() {
        return $this->belongsTo('App\Models\OrderForm','order_form_id');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function products() {
        return $this->hasMany('App\Models\OrderFormProducts','order_receipt_id');
    }
}
