<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CommissionCentercost extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "commission_centercost";

    protected $fillable = ['user_id','center_cost_id', 'commission_income'];

    public function center() {
        return $this->belongsTo('App\Models\CenterCost', 'center_cost_id');
    }
}
