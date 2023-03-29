<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Item extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'contract_id',
        'budget_id',
        'service_id',
        'name',
        'qty',
        'price',
        'percent',
        'discount_value',
        'total'
    ];

    public function contract() {
        return $this->belongsTo('App\Models\Contract');
    }

    public function service() {
        return $this->belongsTo('App\Models\Service');
    }

    public function budget() {
        return $this->belongsTo('App\Models\Budget');
    }
}
