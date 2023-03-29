<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LabResults extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'lab_results';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'array_files',
        'description',
    ];
}
