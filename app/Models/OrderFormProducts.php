<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderFormProducts extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'order_form_products';
    protected $fillable = [
        'order_form_id',
        'product_id',
        'qty',
        'price',
        'tax',

        'qty_fal',
        'lote',
        'expiration',
        'invima',
        'date_invima',
        'renov_invima',
        'packing',
        'transport',
        'inconfirmness',
        'temperature',
        'accepted',
        'status',
        'order_receipt_id'
    ];
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
