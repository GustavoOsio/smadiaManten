<?php

namespace App\Exports;

use App\Models\PaymentAssistance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class PaymentAssistanceExport implements FromView, ShouldAutoSize
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
        $user = $this->data["filter_user"];
        //$date_end = new \Carbon\Carbon($date_end);
        //$date_end = $date_end->addDays(0);
        //$date_start = new \Carbon\Carbon($date_start);
        //$date_start = $date_start->addDays(0);
        if ($date_start != "" && $date_end != "" && $user != "") {
           /* $data = PaymentAssistance::whereBetween("created_at", [$date_start." 00:00:00", $date_end." 23:59:59"])
                ->where('asyst', $user)
                ->get();*/

            //codigo manten
            $data= DB::select("
            SELECT  c.id AS idContrato, pa.id, pa.created_at AS fecha_creacion,  pa.patient AS paciente, pa.identi AS cedula, pa.asyst AS asistencial, pa.serv AS tratamiento_realizado,
            pa.sesion AS sesiones ,pa.date AS fecha_accion  , pa.contract AS contrato,
            pa.price AS Valor_contrato,
            pa.price-c.amount AS Descuento,
            c.amount AS tratamiento_con_descuento,
            pa.seller AS vendedor, pa.stable_status AS establecio_estado,  pa.pay AS pago,
            inc.amount AS pago_0,
            inc.method_of_pay AS medio_pago,
            inc.method_of_pay_2 AS medio_pago2,ROUND (if(p.porcentaje>0,(p.porcentaje *100),0),2) AS p_descuento,
            ROUND ( if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2) AS pagoTyO,
            inc.amount-(ROUND (if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2)) AS vr_final
            FROM incomes inc
            INNER JOIN contracts c ON c.id=inc.contract_id
            INNER JOIN schedules sh ON sh.contract_id=c.id
            INNER JOIN payment_assistance pa ON pa.schedule_id=sh.id
            LEFT JOIN parametro p ON p.tipo=inc.method_of_pay
            WHERE pa.id>0 and pa.asyst = ? and pa.created_at BETWEEN ? AND ?
            ",[$user,$date_start, $date_end ]);
            //fin codigo manten and fecha BETWEEN ? AND ?

            //dd('entro');
        } else if ($date_start != "" && $date_end != "") {
            /*$data = PaymentAssistance::whereBetween("created_at", [$date_start." 00:00:00", $date_end." 23:59:59"])
                ->get();*/


            //codigo manten
            $data= DB::select("
            SELECT  c.id AS idContrato, pa.id, pa.created_at AS fecha_creacion,  pa.patient AS paciente, pa.identi AS cedula, pa.asyst AS asistencial, pa.serv AS tratamiento_realizado,
            pa.sesion AS sesiones ,pa.date AS fecha_accion  , pa.contract AS contrato,
            pa.price AS Valor_contrato,
            pa.price-c.amount AS Descuento,
            c.amount AS tratamiento_con_descuento,
            pa.seller AS vendedor, pa.stable_status AS establecio_estado,  pa.pay AS pago,
            inc.amount AS pago_0,
            inc.method_of_pay AS medio_pago,
            inc.method_of_pay_2 AS medio_pago2,ROUND (if(p.porcentaje>0,(p.porcentaje *100),0),2) AS p_descuento,
            ROUND ( if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2) AS pagoTyO,
            inc.amount-(ROUND (if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2)) AS vr_final
            FROM incomes inc
            INNER JOIN contracts c ON c.id=inc.contract_id
            INNER JOIN schedules sh ON sh.contract_id=c.id
            INNER JOIN payment_assistance pa ON pa.schedule_id=sh.id
            LEFT JOIN parametro p ON p.tipo=inc.method_of_pay
            WHERE pa.id>0 and pa.created_at BETWEEN ? AND ?
            ",[$date_start, $date_end ]);
            //fin codigo manten and fecha BETWEEN ? AND ?
            //dd('entro 2');
        } else if ($user != ""){
          /*  $data = PaymentAssistance::where('asyst', $user)->get();*/


            //codigo manten
            $data= DB::select("
            SELECT c.id AS idContrato, pa.id, pa.created_at AS fecha_creacion,  pa.patient AS paciente, pa.identi AS cedula, pa.asyst AS asistencial, pa.serv AS tratamiento_realizado,
            pa.sesion AS sesiones ,pa.date AS fecha_accion  , pa.contract AS contrato,
            pa.price AS Valor_contrato,
            pa.price-c.amount AS Descuento,
            c.amount AS tratamiento_con_descuento,
            pa.seller AS vendedor, pa.stable_status AS establecio_estado,  pa.pay AS pago,
            inc.amount AS pago_0,
            inc.method_of_pay AS medio_pago,
            inc.method_of_pay_2 AS medio_pago2,ROUND (if(p.porcentaje>0,(p.porcentaje *100),0),2) AS p_descuento,
            ROUND ( if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2) AS pagoTyO,
            inc.amount-(ROUND (if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2)) AS vr_final
            FROM incomes inc
            INNER JOIN contracts c ON c.id=inc.contract_id
            INNER JOIN schedules sh ON sh.contract_id=c.id
            INNER JOIN payment_assistance pa ON pa.schedule_id=sh.id
            LEFT JOIN parametro p ON p.tipo=inc.method_of_pay
            WHERE pa.id>0 and pa.asyst = ?
            ",[$user]);
            //fin codigo manten and fecha BETWEEN ? AND ?

            //dd('entro 3');
        }else{
           /* $data = PaymentAssistance::all();*/

            //codigo manten
            $data= DB::select("
            SELECT c.id AS idContrato, pa.id, pa.created_at AS fecha_creacion,  pa.patient AS paciente, pa.identi AS cedula, pa.asyst AS asistencial, pa.serv AS tratamiento_realizado,
            pa.sesion AS sesiones ,pa.date AS fecha_accion  , pa.contract AS contrato,
            pa.price AS Valor_contrato,
            pa.price-c.amount AS Descuento,
            c.amount AS tratamiento_con_descuento,
            pa.seller AS vendedor, pa.stable_status AS establecio_estado,  pa.pay AS pago,
            inc.amount AS pago_0,
            inc.method_of_pay AS medio_pago,
            inc.method_of_pay_2 AS medio_pago2,ROUND (if(p.porcentaje>0,(p.porcentaje *100),0),2) AS p_descuento,
            ROUND ( if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2) AS pagoTyO,
            inc.amount-(ROUND (if(p.tipo IS NOT NULL,inc.amount * p.porcentaje, 0 ),2)) AS vr_final
            FROM incomes inc
            INNER JOIN contracts c ON c.id=inc.contract_id
            INNER JOIN schedules sh ON sh.contract_id=c.id
            INNER JOIN payment_assistance pa ON pa.schedule_id=sh.id
            LEFT JOIN parametro p ON p.tipo=inc.method_of_pay
            WHERE pa.id>0
            ");
            //fin codigo manten and fecha BETWEEN ? AND ?

            //dd('entro 4');
        }
        //dd($date_start.' '.$date_end);
        //dd($data); exports.payment_assistance --> anterior
              return view('exports.payment_assistance2', [
            'payment' => $data
        ]);
    }
}
