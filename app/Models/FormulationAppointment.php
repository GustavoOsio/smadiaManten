<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FormulationAppointment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'formulation_appointment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
    ];

    public function relacion_formulacion(){
        return $this->hasMany(RelationFormulationAppointment::class,'formulation_appointment_id','id');
    }
}