<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MedicationControl extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'medication_control';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'service',
    ];

    public function relacion_control_medicamentos(){
        return $this->hasMany(RelationMedicationControl::class,'medication_control_id','id');
    }
}