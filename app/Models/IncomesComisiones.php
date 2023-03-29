<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class IncomesComisiones extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'user_id',
        'income_id',
        'patient_id',
        'seller_id',
        'amount',
        'description',
        'center_cost_id',
        'form_pay',
        'contract',
        'date',
        'pay_card',
        'totally',
        'commission',
    ];
    public function patient() {
        return $this->belongsTo('App\Models\Patient','patient_id');
    }
    public function center() {
        return $this->belongsTo('App\Models\CenterCost', 'center_cost_id');
    }
    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }
    public function income() {
        return $this->belongsTo('App\Models\Income', 'income_id');
    }
}
