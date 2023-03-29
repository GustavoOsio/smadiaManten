<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class comisionesdepartamentos extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "comisionesdepartamentos";

    protected $fillable = ['idComisionesDepartamentos'];

}
