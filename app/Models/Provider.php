<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Provider extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'nit',
        'company',
        'address',
        'state_id',
        'city_id',
        'phone',
        'fullname',
        'email',
        'phone_contact',
        'cellphone',
        'status'
    ];

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }
}
