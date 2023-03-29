<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Measurements extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'measurements';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'imc',
        'weight',
        'bust',
        'contour',
        'waistline',
        'umbilical',
        'abd_lower',
        'abd_higher',
        'hip',
        'legs',
        'right_thigh',
        'left_thigh',
        'right_arm',
        'left_arm',
        'observations',
    ];
}
