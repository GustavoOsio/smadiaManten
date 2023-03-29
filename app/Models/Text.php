<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Text extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "text";

    protected $fillable = ['text'];
}
