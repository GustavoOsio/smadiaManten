<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EmailConfirmation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'email_confirmation';
    protected $primaryKey = 'id';
    protected $fillable = [
        "text",
        "firm",
    ];
}
