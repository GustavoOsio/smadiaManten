<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationFormulationAppointment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_formulation_appointment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'formulation_appointment_id',
        'formula',
        'other',
        'another_formula',
        'indications',
        'formulation',
    ];
}
