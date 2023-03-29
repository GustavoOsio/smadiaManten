<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class arrayHistory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'history_array';
    protected $primaryKey = 'id';
    protected $fillable = [
        'patient',
        'agent',
        'array',
    ];

    public function relacion_paciente(){
        return $this->hasMany(Patient::class,'id','patient');

    }
}
