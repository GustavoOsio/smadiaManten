<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BiologicalMedicinePlan extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'biological_medicine_plan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'array_biological_medicine',
        'array_observations',
    ];
}
