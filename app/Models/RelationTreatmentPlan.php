<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationTreatmentPlan extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_treatment_plan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tratment_plan_id',
        'service_line',
        'observations',
    ];
}