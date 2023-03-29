<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TransferWineryObservations extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'transfer_to_winery_observations';
    protected $fillable = [
        'user_id',
        'transfer_to_winery_id',
        'purchase_product_id',
        'product_id',
        'observations',
        'date',
        'qty',
        'qty_falt',
    ];

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
    public function product() {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function purchase() {
        return $this->belongsTo('App\Models\PurchaseProduct','purchase_product_id');
    }
}
