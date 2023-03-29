<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CosmetologicalEvolution extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'cosmetological_evolution';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'evolution',
    ];
}