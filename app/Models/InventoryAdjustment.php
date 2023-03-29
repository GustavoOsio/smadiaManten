<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InventoryAdjustment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'inventory_adjustment';
    protected $fillable = [
        'user_id',
        'approved_id',
        'type',
        'observations',
        'motivo',
        'status'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
    public function aproved() {
        return $this->belongsTo('App\User','approved_id');
    }
}
