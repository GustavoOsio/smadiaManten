<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InfirmaryNotes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'infirmary_notes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'date',
        'hour',
        'note',
        'observations',
    ];
}
