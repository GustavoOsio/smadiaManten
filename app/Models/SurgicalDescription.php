<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SurgicalDescription extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'surgical_description';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'diagnosis',
        'preoperative_diagnosis',
        'postoperative_diagnosis',
        'surgeon',
        'anesthesiologist',
        'assistant',
        'surgical_instrument',
        'date',
        'start_time',
        'end_time',
        'code_cups',
        'intervention',
        'control_compresas',
        'type_anesthesia',
        'description_findings',
        'observations',
    ];
}
