<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReservationDate extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'reservation_date';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'responsable_id',
        'option',
        'date_start',
        'date_end',
        'hour_start',
        'hour_end',
        'motiv',
        'observation',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function responsable() {
        return $this->belongsTo('App\User', 'responsable_id');
    }
}
