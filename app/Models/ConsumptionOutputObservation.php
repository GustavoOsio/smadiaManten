<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsumptionOutputObservation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'consumption_output_observation';
    protected $fillable = [
        'user_id',
        'consumption_output_id',
        'purchase_product_id',
        'product_id',
        'observations',
        'date',
        'qty',
        'lost',
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
