<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PersonalInventoryObservations extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'personal_inventory_observations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'purchase_products_id',
        'qty',
        'date',
        'observations',
    ];

    public function productPurchase() {
        return $this->belongsTo('App\Models\PurchaseProduct','purchase_products_id');
    }

}
