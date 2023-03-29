<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PatientPhotographs extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'patient_photographs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'array_photos',
        'comments'
    ];
}
