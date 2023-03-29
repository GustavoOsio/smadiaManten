<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ConsumptionOutput extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'consumption_output';
    protected $fillable = [
        'user_id',
        'approved_id',
        'cellar_id',
        'observations',
        'motivo',
        'status',
    ];
    public function cellar() {
        return $this->belongsTo('App\Models\Cellar', 'cellar_id');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function aproved() {
        return $this->belongsTo('App\User','approved_id');
    }
}
