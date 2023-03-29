<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class mesesdelanio extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'meses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mes',
        'nombre',
    ];
   
}
