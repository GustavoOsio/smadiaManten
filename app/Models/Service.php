<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Service extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'name',
        'price',
        'price_pay',
        'price_input',
        'percent',
        'xpenses_sheet',
        'equipment_id',
        'restricted',
        'contract',
        'status',
        'electronic_equipment_id',
        'depilcare',
        'type',
        'deducible',
        'p_deducible_t',
        'p_deducible_no',
        'p_comision',
    ];

    public function users() {
        return $this->belongsToMany('App\User')->orderBy('name');
    }

    public function users_schedule() {
        return $this->belongsToMany('App\User')->where('schedule','si')->orderBy('name');
    }

    public function service_user() {
        return $this->belongsTo('App\Models\ServiceUser','service_id');
    }

    public function items() {
        return $this->hasMany('App\Models\Item');
    }

    public function equip() {
        return $this->belongsTo('App\Models\ElectronicEquipment','electronic_equipment_id');
    }
}
