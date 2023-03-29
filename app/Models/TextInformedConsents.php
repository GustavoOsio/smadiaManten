<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TextInformedConsents extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "text_informed_consents";
    protected $primaryKey = 'id';
    protected $fillable = [
        'text',
        'service_id'
    ];
    public function service() {
        return $this->belongsTo('App\Models\Service','service_id');
    }
}
