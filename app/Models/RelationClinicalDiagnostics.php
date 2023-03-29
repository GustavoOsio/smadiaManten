<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationClinicalDiagnostics extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_clinical_diagnostics';
    protected $primaryKey = 'id';
    protected $fillable = [
        'clinical_diagnostics_id',
        'diagnosis',
        'type',
        'external_cause',
        'treatment_plan',
        'other',
        'observations',
    ];
}