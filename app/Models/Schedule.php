<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Schedule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'patient_id',
        'service_id',
        'personal_id',
        'user_id',
        'contract_id',
        'date',
        'start_time',
        'end_time',
        'comment',
        'status',
        'confirm_comment',
        'confirm'
    ];

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }

    public function service() {
        return $this->belongsTo('App\Models\Service');
    }

    public function profession() {
        return $this->belongsTo('App\User', 'personal_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function contract() {
        return $this->belongsTo('App\Models\Contract');
    }

    public function consumed() {
        return $this->hasOne('App\Models\Consumed')->orderBy('id','desc');
    }
}
