<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProviderHistorial extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'provider_historial';
    protected $fillable = [
        'product_id',
        'provider_id',
        'cost',
    ];
}
