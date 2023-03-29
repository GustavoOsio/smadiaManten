<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\User;
class metasMedico extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = "tbl_metasMedico";
    protected $fillable = [
        'id_tbl_metaMedico',
        'id_medico',
        'meta_mes',
        'mes',
        'activo'
    ];

    public function mes_meta(){
        return $this->hasMany(mesesdelanio::class,'mes','mes');
    }
    public function medico_meta(){
        return $this->hasMany(User::class,'id','id_medico');
    }
}
