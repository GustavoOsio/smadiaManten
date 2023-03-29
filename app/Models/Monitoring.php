<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Monitoring extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "monitorings";
    protected $fillable = [
        'patient_id',
        'responsable_id',
        'user_id',
        'issue_id',
        'date',
        'date_close',
        'comment',
        'comment_close',
        'close_id',
        'status'
    ];

    public function issue() {
        return $this->belongsTo('App\Models\Issue');
    }

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }


    public function responsable() {
        return $this->belongsTo('App\User', 'responsable_id');
    }
    public function close() {
        return $this->belongsTo('App\User', 'close_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function incidents() {
        return $this->hasMany('App\Models\Incident')->orderByDesc('created_at');
    }
}
