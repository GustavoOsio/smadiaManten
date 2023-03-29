<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TypeMedicalHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'type_medical_history';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
}
