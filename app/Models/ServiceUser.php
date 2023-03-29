<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceUser extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = 'service_user';
    protected $fillable = [
        'user_id',
        'service_id',
    ];
    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function service() {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
