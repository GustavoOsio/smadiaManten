<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ScheduleHistorial extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "schedule_historial";
    protected $fillable = [
        'patient_id',
        'schedule_id',
        'date',
        'status',
        'professional',
        'contract',
        'service',
        'comment',
        'start',
        'end',
        'comment_update',
        'date_update',
        'user',
    ];
}
