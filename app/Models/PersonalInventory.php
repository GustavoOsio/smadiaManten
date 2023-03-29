<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PersonalInventory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'personal_inventory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
    ];
    public function product() {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
