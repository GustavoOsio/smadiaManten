<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ExpensesSheet extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'expenses_sheet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'observations',
    ];

    public function relacion_expenses_sheet(){
        return $this->hasMany(RelationExpensesSheet::class,'expenses_sheet_id','id');
    }
}
