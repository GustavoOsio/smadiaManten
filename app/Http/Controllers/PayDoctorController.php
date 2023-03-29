<?php

namespace App\Http\Controllers;

use App\Exports\PayDoctorExport;
use App\Models\PayDoctors;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PayDoctorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view', PayDoctors::class);
        //$payment = PayDoctors::orderByDesc('created_at')->get();
        $query = PayDoctors::orderBy('pay_doctors.id','desc');

        if($request->patient != ''){
            $porciones = explode(" ", $request->patient);
            for($i=0;$i<count($porciones);$i++){
                $query->where('pay_doctors.patient','LIKE','%'.$porciones[$i].'%');
            }
        }
        if($request->cc != ''){
            $query->where('pay_doctors.identification','LIKE','%'.$request->cc.'%');
        }
        if($request->name != ''){
            $porciones = explode(" ", $request->name);
            for($i=0;$i<count($porciones);$i++){

                $query->where('pay_doctors.assistant','LIKE','%'.$porciones[$i].'%');
            }
        }
        if($request->treatment != ''){
            $query->where('pay_doctors.service','LIKE','%'.$request->treatment.'%');
        }
        if($request->sesion != ''){
            $query->where('pay_doctors.session','LIKE','%'.$request->sesion.'%');
        }
        if($request->date != ''){
            $query->where('pay_doctors.date','LIKE','%'.$request->date.'%');
        }
        if($request->contract != ''){
            $query->where('pay_doctors.contract','LIKE','%'.$request->contract.'%');
        }

        if($request->value != ''){
            $value = str_replace(',','',$request->value);
            $value = str_replace('.','',$value);
            $value = str_replace('$','',$value);
            $value = str_replace(' ','',$value);
            $query->where('pay_doctors.price','LIKE','%'.$value.'%');
        }
        if($request->desc != ''){
            $desc = str_replace(',','',$request->desc);
            $desc = str_replace('.','',$desc);
            $desc = str_replace('$','',$desc);
            $desc = str_replace(' ','',$desc);
            $query->where('pay_doctors.discount','LIKE','%'.$desc.'%');
        }
        if($request->tarjet != ''){
            $tarjet = str_replace(',','',$request->tarjet);
            $tarjet = str_replace('.','',$tarjet);
            $tarjet = str_replace('$','',$tarjet);
            $tarjet = str_replace(' ','',$tarjet);
            $query->where('pay_doctors.card','LIKE','%'.$tarjet.'%');
        }
        if($request->deducible != ''){
            $deducible = str_replace(',','',$request->deducible);
            $deducible = str_replace('.','',$deducible);
            $deducible = str_replace('$','',$deducible);
            $deducible = str_replace(' ','',$deducible);
            $query->where('pay_doctors.deducible','LIKE','%'.$deducible.'%');
        }
        if($request->total != ''){
            $total = str_replace(',','',$request->total);
            $total = str_replace('.','',$total);
            $total = str_replace('$','',$total);
            $total = str_replace(' ','',$total);
            $query->where('pay_doctors.totally','LIKE','%'.$total.'%');
        }
        if($request->commission != ''){
            $commission = str_replace(',','',$request->commission);
            $commission = str_replace('.','',$commission);
            $commission = str_replace('$','',$commission);
            $commission = str_replace(' ','',$commission);
            $query->where('pay_doctors.commission','LIKE','%'.$commission.'%');
        }

        $totaly = $query->select('pay_doctors.*');
        $value_tra = 0;
        $value_desc = 0;
        $value_tarjet = 0;
        $value_deducible = 0;
        $value_total = 0;
        $value_comision = 0;
        foreach ($totaly->get() as $t){
            $value_tra = $value_tra + $t->price;
            $value_desc = $value_desc + $t->discount;
            $value_tarjet = $value_tarjet + $t->card;
            $value_deducible = $value_deducible + $t->deducible;
            $value_total = $value_total + $t->totally;
            $value_comision = $value_comision + $t->commission;
        }
        $payment = $query->paginate(10);
        return view('pay-doctors.index',[
            'payment'=>$payment,
            'request'=>$request,
            'value_tra'=>$value_tra,
            'value_desc'=>$value_desc,
            'value_tarjet'=>$value_tarjet,
            'value_deducible'=>$value_deducible,
            'value_total'=>$value_total,
            'value_comision'=>$value_comision,
        ]);
    }

    public function export(Request $request){
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "filter_user" => $request->query("filter_user")
        ];
        //dd($data);
        return Excel::download(new PayDoctorExport($data), 'pago_a_doctores.xlsx');
    }

}
