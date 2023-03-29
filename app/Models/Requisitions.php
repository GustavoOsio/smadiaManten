<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Requisitions extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "requisitions";

    protected $fillable = [
        'product',
        'observations',
    ];

    public function products() {
        return $this->hasMany('App\Models\RequisitionsProducts');
    }

}
