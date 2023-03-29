<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SalesComisiones extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'sale_id',
        'product_id',
        'sales_product_id',
        'patient_id',
        'seller_id',
        'amount',
        'discount',
        'form_pay',
        'commission',
        'status',
    ];
    public function sale() {
        return $this->belongsTo('App\Models\Sale');
    }
    public function product() {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function sales_products() {
        return $this->belongsTo('App\Models\SaleProduct','sales_product_id');
    }
    public function patient() {
        return $this->belongsTo('App\Models\Patient','patient_id');
    }
    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }
}
