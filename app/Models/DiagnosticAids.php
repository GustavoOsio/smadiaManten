<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DiagnosticAids extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'diagnostic_aids';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'status',
        'status'
    ];
}
