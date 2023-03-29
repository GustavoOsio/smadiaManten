<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SurgeryExpensesSheet extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'surgery_expenses_sheet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'date_of_surgery',
        'room',
        'weight',
        'type_patient',
        'type_anesthesia',
        'type_surgery',
        'surgery',
        'surgery_code',
        'time_entry',
        'start_time_surgery',
        'end_time_surgery',
        'surgeon',
        'assistant',
        'anesthesiologist',
        'rotary',
        'instrument',
    ];

    public function relacion_expenses_sheet_surgery(){
        return $this->hasMany(RelationSurgeryExpensesSheet::class,'surgery_expenses_sheet_id','id');
    }
}
