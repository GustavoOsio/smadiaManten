<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sale extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'patient_id',
        'user_id',
        'seller_id',
        'sub_amount',
        'amount',
        'tax',
        'type_discount',
        'discount',
        'discount_total',
        'qty_products',
        'method_payment',
        'method_payment_2',
        'total_1',
        'total_2',
        'number_account',
        'number_account_2',
        'approval_number',
        'approval_number_2',
        'type_of_card',
        'approved_of_card',
        'card_entity',
        'receipt',
        'comments',
        'observations',
        'type_of_card_2',
        'approved_of_card_2',
        'card_entity_2',
        'receipt_2',
        'partner_discount',
        'ref_epayco',
        'approved_epayco',
        'ref_epayco_2',
        'approved_epayco_2',
    ];

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function products() {
        return $this->hasMany('App\Models\SaleProduct');
    }

}
