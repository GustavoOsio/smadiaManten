<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderPurchaseConnection extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "order_purchase_connection";
    protected $fillable = [
        'order_purchase_id',
        'order_form_id',
        'product_id',
        'order_form_p_id',
        'order_rest',
    ];
}
