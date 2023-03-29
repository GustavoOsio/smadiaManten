<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Patient extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'lastname',
        'identy',
        'birthday',
        'state_id',
        'city_id',
        'gender_id',
        'service_id',
        'contact_source_id',
        'eps_id',
        'ocupation',
        'linkage',
        'phone',
        'cellphone',
        'email',
        'address',
        'f_name',
        'f_phone',
        'f_relationship',
        'photo',
        'civil_status_id',
        'status',
        'user_id',
        'observations'
    ];

    public function creator() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function gender() {
        return $this->belongsTo('App\Models\Gender');
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

    public function service() {
        return $this->belongsTo('App\Models\Service');
    }

    public function contact() {
        return $this->belongsTo('App\Models\ContactSource', 'contact_source_id');
    }

    public function eps() {
        return $this->belongsTo('App\Models\Filter', 'eps_id');
    }

    public function civil() {
        return $this->belongsTo('App\Models\Filter', 'civil_status_id');
    }

    public function schedules() {
        return $this->hasMany('App\Models\Schedule')->orderByDesc('date');
    }

    public function contracts() {
        return $this->hasMany('App\Models\Contract')->orderByDesc('created_at');
    }

    public function budgets() {
        return $this->hasMany('App\Models\Budget')->orderByDesc('created_at');
    }

    public function monitorings() {
        return $this->hasMany('App\Models\Monitoring')->orderByDesc('created_at');
    }

    public function incomes() {
        return $this->hasMany('App\Models\Income')
            ->where('contract_id','<>','')
            ->where('amount','>',0)
            ->orderByDesc('created_at');
    }

    public function incomesCaja() {
        return $this->hasMany('App\Models\Income')
            ->whereNull('contract_id')
            ->where('amount','>',0)
            ->where('status','activo')
            ->orderByDesc('created_at');
    }

    public function incomesHistorial() {
        return $this->hasMany('App\Models\Income')
            ->whereNull('contract_id')
            ->where('status','activo')
            ->where('amount','<=',0)
            ->orderByDesc('created_at');
    }

    public function getFile(){
        return $this->hasMany('App\Models\PatientsFiles')->orderByDesc('created_at');
    }

    public function informedConsents(){
        return $this->hasMany('App\Models\InformedConsents')
            ->orderByDesc('created_at');
    }

    public function policies(){
        return $this->hasMany('App\Models\PoliciesPatients')
            ->orderByDesc('created_at');
    }

}
