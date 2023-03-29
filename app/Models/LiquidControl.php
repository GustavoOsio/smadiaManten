<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LiquidControl extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'liquid_control';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'parental_1',
        'parental_2',
        'parental_3',
        'parental_4',
        'parental_5',
        'total_adm',
        'total_del',
    ];

    public function relacion_control_liquidos(){
        return $this->hasMany(RelationLiquidControl::class,'liquid_control_id','id');
    }
}