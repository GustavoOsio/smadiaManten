<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PurchaseProduct extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'cellar_id',
        'purchase_id',
        'product_id',
        'qty',
        'lote',
        'expiration',
        'price',
        'tax',
        'missing',
        'full_amount',
        'inventory',
        'qty_inventory',
        'qty_inventory_personal',
        'inventory_personal_id',
        'qty_inventory_ever',
        'qty_inventory_personal_ever',
        'observations_ajust',
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function cellar() {
        return $this->belongsTo('App\Models\Cellar');
    }

    public function purchase() {
        return $this->belongsTo('App\Models\Purchase');
    }
}
