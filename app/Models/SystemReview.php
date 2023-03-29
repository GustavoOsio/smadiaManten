<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SystemReview extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'system_review';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'patient_id',
        'system_head_face_neck',
        'system_respiratory_cardio',
        'system_digestive',
        'system_genito_urinary',
        'system_locomotor',
        'system_nervous',
        'system_integumentary',
        'observations',
    ];
}
