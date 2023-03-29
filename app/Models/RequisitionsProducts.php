<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionsProducts extends Model
{
    protected $table = "products_requisition";
    protected $primaryKey = "id";
    protected $fillable = ['requisition_id','category','product'];
}
