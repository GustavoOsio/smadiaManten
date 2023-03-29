<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RelationExpensesSheet extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'relation_expenses_sheet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'expenses_sheet_id',
        'code',
        'product',
        'lote',
        'presentation',
        'medid',
        'cant',
    ];
}
