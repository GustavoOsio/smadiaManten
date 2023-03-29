<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SaleProduct extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "sales_products";

    protected $fillable = [
        'sale_id',
        'product_id',
        'purchase_product_id',
        'qty',
        'price',
        'discount',
        'discount_cop',
        'tax',
    ];

    public function product()
    {
        return $this->belongsTo("App\Models\Product",'product_id');
    }

    public function purchase()
    {
        return $this->belongsTo("App\Models\PurchaseProduct","purchase_product_id");
    }

    public function sale()
    {
        return $this->belongsTo("App\Models\Sale","sale_id");
    }
}
