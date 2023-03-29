<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Areas extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'areas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'status',
        'cellar_id'
    ];
    public function cellar() {
        return $this->belongsTo('App\Models\Cellar', 'cellar_id');
    }
}
