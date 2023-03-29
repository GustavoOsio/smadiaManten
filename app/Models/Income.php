<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Income extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = [
        'patient_id',
        'contract_id',
        'seller_id',
        'responsable_id',
        'user_id',
        'center_cost_id',
        'account_id',
        'account_2_id',
        'amount',
        'amount_one',
        'amount_two',
        'comment',
        'method_of_pay',
        'type',
        'type_of_card',
        'approved_of_card',
        'card_entity',
        'origin_bank',
        'origin_account',
        'ref_epayco',
        'approved_epayco',
        'method_of_pay_2',
        'type_of_card_2',
        'approved_of_card_2',
        'card_entity_2',
        'origin_bank_2',
        'origin_account_2',
        'ref_epayco_2',
        'approved_epayco_2',
        'receipt',
        'receipt_2',
        'unification',
        'unification_2',
        'follow_id',
        'approved_Banco',
        'approved_Banco_2',
        'created_at',
    ];

    public function contract() {
        return $this->belongsTo('App\Models\Contract');
    }

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }

    public function center() {
        return $this->belongsTo('App\Models\CenterCost', 'center_cost_id');
    }

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function follow() {
        return $this->belongsTo('App\User', 'follow_id');
    }

    public function responsable() {
        return $this->belongsTo('App\User', 'responsable_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function account() {
        return $this->belongsTo('App\Models\Account','account_id');
    }

    public function account2() {
        return $this->belongsTo('App\Models\Account', 'account_2_id');
    }
}
