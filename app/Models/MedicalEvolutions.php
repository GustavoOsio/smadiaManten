<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MedicalEvolutions extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'medical_evolutions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'observations',
    ];
}