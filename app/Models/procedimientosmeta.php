<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class procedimientosmeta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "procedimientosmeta";

    protected $fillable = ['idProcedimientosMeta'];

}
