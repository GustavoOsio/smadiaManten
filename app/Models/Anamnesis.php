<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Anamnesis extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'anamnesis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'patient_id',
        'reason_consultation',
        'current_illness',
        'ant_patologico',
        'ant_surgical',
        'ant_allergic',
        'ant_traumatic',
        'ant_medicines',
        'ant_gynecological',
        'ant_fum',
        'ant_habits',
        'ant_familiar',
        'ant_nutritional',
        'observations',
    ];
}
