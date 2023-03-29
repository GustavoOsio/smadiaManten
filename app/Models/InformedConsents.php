<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InformedConsents extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'informed_consents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'contract_id',
        'service_id',
        'patient_id',
        'responsable_id',
        'type',
        'file',
        'link',
        'user',
        'password',
        'validate',
        'signatureBase64',
        'authorize',
        'signature',
        'status',
        'token',
        'date',
        'group_1',
        'group_2',
        'group_3'
    ];

    public function responsable() {
        return $this->belongsTo('App\User', 'responsable_id');
    }

    public function contract() {
        return $this->belongsTo('App\Models\Contract','contract_id');
    }

    public function service() {
        return $this->belongsTo('App\Models\Service','service_id');
    }

    public function patient() {
        return $this->belongsTo('App\Models\Patient','patient_id');
    }
}
