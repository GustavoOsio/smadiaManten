<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesContracts extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'signatures_contracts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'contract_id',
        'link',
        'user',
        'password',
        'validate',
        'signatureBase64',
        'authorize',
        'signature',
        'status',
        'token',
    ];
}
