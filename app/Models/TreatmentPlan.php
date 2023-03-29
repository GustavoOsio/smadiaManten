<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TreatmentPlan extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'treatment_plan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'observations',
    ];

    public function relacion(){
        return $this->hasMany(RelationTreatmentPlan::class,'tratment_plan_id','id');
    }
}