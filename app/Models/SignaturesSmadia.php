<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesSmadia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'signatures_smadia';
    protected $primaryKey = 'id';
    protected $fillable = [
        'responsable_id',
        'signature',
        'base_64'
    ];

    public function user() {
        return $this->belongsTo('App\User','responsable_id');
    }
}
