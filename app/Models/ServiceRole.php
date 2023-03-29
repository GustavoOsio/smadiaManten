<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceRole extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table = 'service_role';
    protected $fillable = [
        'role_id',
        'service_id',
    ];
    public function role() {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
    public function service() {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
