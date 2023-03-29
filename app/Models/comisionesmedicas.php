<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class comisionesmedicas extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "comisionesmedicas";
    protected $fillable = ['idComisionesMedicas'];

}
