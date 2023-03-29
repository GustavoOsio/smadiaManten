<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'name',
        'reference',
        'tax',
        'price',
        'cost',
        'stock',
        'presentation_id',
        'unit_id',
        'category_id',
        'inventory_id',
        'provider_id',
        'form',
        'status',
        'price_vent',
        'invima',
        'date_invima',
        'por_comision',
    ];

    public function presentation() {
        return $this->belongsTo('App\Models\Type', 'presentation_id');
    }

    public function unit() {
        return $this->belongsTo('App\Models\Type', 'unit_id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Type', 'category_id');
    }

    public function inventory() {
        return $this->belongsTo('App\Models\Type', 'inventory_id');
    }

    public function provider() {
        return $this->belongsTo('App\Models\Provider');
    }
}
