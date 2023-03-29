<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Account extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'account',
        'type',
        'bank_id',
        'status'
    ];

    public function bank() {
        return $this->belongsTo('App\Models\Bank');
    }
}
