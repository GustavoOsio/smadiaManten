<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationSurgeryExpensesSheet extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_surgery_expenses_sheet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'surgery_expenses_sheet_id',
        'code',
        'product',
        'lote',
        'presentation',
        'medid',
        'cant',
    ];
}
