<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Contract extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'patient_id',
        'seller_id',
        'user_id',
        'amount',
        'balance',
        'comment',
        'comment_liquid',
        'date_liquid',
        'responsable_liquid',
        'amount_liquid',
        'status',
        'obsequio',
        'obsequioDos',
        'CantidadObsequio1',
        'CantidadObsequio2',
        'anestesia'
    ];

    public function items() {
        return $this->hasMany('App\Models\Item');
    }

    public function schedules() {
        return $this->hasMany('App\Models\Schedule')
            ->where('status', '=', 'completada')
            ->orderBy('service_id','desc');
    }

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function responsableLiquid() {
        return $this->belongsTo('App\User', 'responsable_liquid');
    }


    public function user() {
        return $this->belongsTo('App\User');
    }

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }

    public function incomes() {
        return $this->hasMany('App\Models\Income');
    }
}
