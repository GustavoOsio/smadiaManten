<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SystemsPathologies extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'systems_pathologies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'systems_id',
        'name',
    ];
}
