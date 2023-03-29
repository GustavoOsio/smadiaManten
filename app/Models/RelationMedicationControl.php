<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationMedicationControl extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_medication_control';
    protected $primaryKey = 'id';
    protected $fillable = [
        'medication_control_id',
        'medicine',
        'date',
        'hour',
        'initial',
    ];
}