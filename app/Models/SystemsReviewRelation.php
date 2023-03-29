<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SystemsReviewRelation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'systems_review_relation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'system_review_id',
        'systems_id',
        'pathology',
        'select',
    ];
}
