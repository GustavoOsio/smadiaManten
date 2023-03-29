<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Expenses extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $fillable =
        [
            'user_id',
            'provider_id',
            'date',
            'purchase_orders_id',
            'form_pay',
            'value',
            'iva',
            'center_costs_id',
            'retention_id',
            'total_expense',
            'observations',
            'porcent_iva',
            'apli_fact',
            'desc_pront_pay',
            'desc_type',
            'desc_value',
            'desc_total',
            'rte_aplica',
            'rte_value',
            'rte_base',
            'rte_porcent',
            'rte_iva',
            'rte_iva_porcent',
            'rte_iva_value',
            'rte_ica',
            'rte_ica_porcent',
            'rte_ica_value',
            'rte_cree',
            'rte_cree_porcent',
            'rte_cree_value',
            'motivo',
            'status'
        ];

    public function users() {
        return $this->belongsTo('App\User','user_id');
    }
    public function provider() {
        return $this->belongsTo('App\Models\Provider','provider_id');
    }
    public function purchase() {
        return $this->belongsTo('App\Models\Purchase','purchase_orders_id');
    }
    public function center() {
        return $this->belongsTo('App\Models\CenterCost','center_costs_id');
    }
    public function retention() {
        return $this->belongsTo('App\Models\Retention','retention_id');
    }
}
