<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PayDoctors extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'pay_doctors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'assistant_id',
        'service_id',
        'schedule_id',
        'patient',
        'identification',
        'assistant',
        'service',
        'session',
        'date',
        'contract',
        'price',
        'discount',
        'pay_card',
        'card',
        'deducible',
        'totally',
        'commission',
    ];
}
