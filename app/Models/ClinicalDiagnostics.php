<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ClinicalDiagnostics extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'clinical_diagnostics';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'observations',
    ];

    public function relacion_diagnostico(){

       return $this->hasMany(RelationClinicalDiagnostics::class,'clinical_diagnostics_id','id');
    }
}