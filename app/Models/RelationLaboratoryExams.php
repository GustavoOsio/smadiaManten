<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationLaboratoryExams extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_laboratory_exams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'laboratory_exams_id',
        'diagnosis',
        'exam',
        'other_exam',
    ];
}