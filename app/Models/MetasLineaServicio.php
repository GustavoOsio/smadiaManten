<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MetasLineaServicio extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "tbl_meta_servicio";
    protected $fillable = [
        'id',
        'servicio',
        'meta',
        'mes',
        'estado',
    ];

    public function mes_meta(){
        return $this->hasMany(mesesdelanio::class,'mes','mes');
    }
    public function servicio_meta()
    {
        return $this->hasMany(Service::class,'id','servicio');

    }
}
