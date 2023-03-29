<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LaboratoryExams extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'laboratory_exams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'comments',
    ];

    public function relacion_laboratorio(){
        return $this->hasMany(RelationLaboratoryExams::class,'laboratory_exams_id','id');
    }
}