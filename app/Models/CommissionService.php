<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CommissionService extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "commission_service";

    protected $fillable = ['user_id','service_id', 'commission_service'];

    public function service() {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
