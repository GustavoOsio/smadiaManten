<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Laboratory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'name',
        'type',
        'status',
    ];
    public function diagnostics() {
        return $this->belongsTo('App\Models\DiagnosticAids','type');
    }
}
