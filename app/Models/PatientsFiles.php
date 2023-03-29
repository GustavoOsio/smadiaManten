<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PatientsFiles extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'patients_files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'name',
        'file',
        'date'
    ];
    public function responsable() {
        return $this->belongsTo('App\User','user_id');
    }
}
