<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'role_id',
        'title',
        'name',
        'lastname',
        'email',
        'password',
        'username',
        'identy',
        'date_expedition',
        'birthday',
        'state_id',
        'city_id',
        'gender_id',
        'address',
        'urbanization',
        'phone',
        'phone_two',
        'cellphone',
        'cellphone_two',
        'email_two',
        'arl_id',
        'pension_id',
        'arp_text',
        'pension_text',
        'blood_id',
        'f_name',
        'f_lastname',
        'f_address',
        'f_phone',
        'f_cellphone',
        'f_relationship',
        'photo',
        'color',
        'schedule',
        'status',
        'cellar_id',
        'commission_income',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function blood() {
        return $this->belongsTo('App\Models\Blood');
    }

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

    public function city() {
        return $this->belongsTo('App\Models\City');
    }
    public function services() {
        return $this->belongsToMany('App\Models\Service')->orderBy('name');
    }
    public function service_user() {
        return $this->belongsTo('App\Models\ServiceUser','user_id');
    }
}
