<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class presupuesto_venta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "presupuesto_venta";

    protected $fillable = ['idPresupuesto'];

    public function relacion_mes(){
        return $this->hasMany(mesesdelanio::class,'mes','mes'); 
    }
}
