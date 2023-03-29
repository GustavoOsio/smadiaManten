<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class RequisitionsProductCategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "requisitions_products";
    protected $fillable = [
        'requisition_category_id',
        'name',
    ];

    public function category() {
        return $this->belongsTo('App\Models\RequisitionsCategory', 'requisition_category_id');
    }
}
