<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderProduct extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'qty',
        'type',
        'missing'
    ];
    public function purchase() {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
