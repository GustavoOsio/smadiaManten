<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class IncomesExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data=[])
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $date_start = $this->data["date_start"];
        $date_end = $this->data["date_end"];
        $date_end = new \Carbon\Carbon($date_end);
        $date_end = $date_end->addDays(1);
        if ($date_start != "" && $date_end != "") {

 /*$data = DB::select("
 SELECT  inc.created_at AS fecha, u.name AS vendedor, inc.contract_id AS contrato , u2.lastname AS paciente,
 inc.comment AS comentario_ingreso,c.amount AS valor_contrato, inc.amount AS ingreso ,  ad.comentario AS adicional_comentario,
 if(p.tipo IS NULL, 'otro',p.tipo  ) AS tipo_pago, if( p.porcentaje IS NULL, 'N/A', ROUND(p.porcentaje *100,2)) AS porcentaje,
 if(ad.valor IS NULL , 0, SUM(ad.valor)) AS descontable,

ROUND( (inc.amount-(if(SUM(ad.valor) IS NULL,0,SUM(ad.valor) ) +
 		if( p.porcentaje IS NOT NULL , inc.amount* p.porcentaje, 0 )) ),2)
		 AS valor_base_comisionable

FROM incomes inc
INNER JOIN contracts c ON c.id=inc.contract_id
LEFT JOIN users u2 ON u2.id=inc.patient_id
LEFT JOIN adicional ad ON ad.id_presupuesto=c.id
LEFT JOIN parametro p ON p.tipo=inc.method_of_pay
LEFT JOIN users u ON u.id=inc.seller_id

WHERE inc.amount>0 AND c.status='activo' AND inc.created_at BETWEEN ? AND ?
GROUP BY c.id, inc.comment, inc.amount, c.amount, ad.comentario, ad.valor, p.tipo
, p.porcentaje,inc.method_of_pay,inc.created_at,u.name, inc.contract_id, u2.lastname
 ",[$date_start, $date_end]);*/

            $data = Income::whereBetween("created_at", [$date_start, $date_end] )
                ->where('amount','>',0)
                ->get();


        } else {

    /* $data = DB::select("
            SELECT  inc.created_at AS fecha, u.name AS vendedor, inc.contract_id AS contrato , u2.lastname AS paciente,
            inc.comment AS comentario_ingreso,c.amount AS valor_contrato, inc.amount AS ingreso ,  ad.comentario AS adicional_comentario,
            if(p.tipo IS NULL, 'otro',p.tipo  ) AS tipo_pago, if( p.porcentaje IS NULL, 'N/A', ROUND(p.porcentaje *100,2)) AS porcentaje,
            if(ad.valor IS NULL , 0, SUM(ad.valor)) AS descontable,

           ROUND( (inc.amount-(if(SUM(ad.valor) IS NULL,0,SUM(ad.valor) ) +
                    if( p.porcentaje IS NOT NULL , inc.amount* p.porcentaje, 0 )) ),2)
                    AS valor_base_comisionable

           FROM incomes inc
           INNER JOIN contracts c ON c.id=inc.contract_id
           LEFT JOIN users u2 ON u2.id=inc.patient_id
           LEFT JOIN adicional ad ON ad.id_presupuesto=c.id
           LEFT JOIN parametro p ON p.tipo=inc.method_of_pay
           LEFT JOIN users u ON u.id=inc.seller_id

           WHERE inc.amount>0 AND c.status='activo'
           GROUP BY c.id, inc.comment, inc.amount, c.amount, ad.comentario, ad.valor, p.tipo
           , p.porcentaje,inc.method_of_pay,inc.created_at,u.name, inc.contract_id, u2.lastname
 ");*/
            $data = Income::where('amount','>',0)->get();
        }
       /* return view('exports.incomes2', [*/
        return view('exports.incomes', [
            'data' => $data
        ]);
    }
}
