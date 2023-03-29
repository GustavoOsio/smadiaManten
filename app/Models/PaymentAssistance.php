<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentAssistance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'payment_assistance';
    protected $primaryKey = 'id';
}
