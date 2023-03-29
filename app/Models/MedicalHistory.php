<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MedicalHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'medical_history';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'id_type',
        'id_relation',
        'patient_id',
        'date',
    ];
    
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
