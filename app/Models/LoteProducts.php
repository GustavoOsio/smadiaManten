<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LoteProducts extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'lote_products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'lote',
        'cant',
        'date',
    ];
    
    public function product() {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
