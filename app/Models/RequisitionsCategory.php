<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RequisitionsCategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "requisitions_categories";

    protected $fillable = [
        'name',
    ];

    public function products() {
        return $this->hasMany('App\Models\RequisitionsProductCategory');
    }
}
