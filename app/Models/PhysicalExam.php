<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PhysicalExam extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'physical_exams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'weight',
        'height',
        'imc',
        'head_neck',
        'cardiopulmonary',
        'abdomen',
        'extremities',
        'nervous_system',
        'skin_fanera',
        'others',
        'observations',
    ];
}
