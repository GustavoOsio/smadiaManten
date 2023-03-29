<?php


namespace App\Http\Controllers;


use App\Exports\PaymentAssistanceExport;
use App\Models\Contract;
use App\Models\PaymentAssistance;
use App\Models\Schedule;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PaymentAssistanceController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view', PaymentAssistance::class);
        //$payment = PaymentAssistance::orderByDesc('created_at')->get();
        $query = PaymentAssistance::orderBy('payment_assistance.id','desc');
        if($request->patient != ''){
            $porciones = explode(" ", $request->patient);
            for($i=0;$i<count($porciones);$i++){
                $query->where('payment_assistance.patient','LIKE','%'.$porciones[$i].'%');
            }
        }
        if($request->cc != ''){
            $query->where('payment_assistance.identi','LIKE','%'.$request->cc.'%');
        }
        if($request->name != ''){
            $porciones = explode(" ", $request->name);
            for($i=0;$i<count($porciones);$i++){
                $query->where('payment_assistance.asyst','LIKE','%'.$porciones[$i].'%');
            }
        }
        if($request->treatment != ''){
            $query->where('payment_assistance.serv','LIKE','%'.$request->treatment.'%');
        }
        if($request->sesion != ''){
            $query->where('payment_assistance.sesion','LIKE','%'.$request->sesion.'%');
        }
        if($request->contract != ''){
            $query->where('payment_assistance.contract','LIKE','%'.$request->contract.'%');
        }
        if($request->value != ''){
            $value = str_replace(',','',$request->value);
            $value = str_replace('.','',$value);
            $value = str_replace('$','',$value);
            $value = str_replace(' ','',$value);
            $query->where('payment_assistance.price','LIKE','%'.$value.'%');
        }
        if($request->desc != ''){
            $desc = str_replace(',','',$request->desc);
            $desc = str_replace('.','',$desc);
            $desc = str_replace('$','',$desc);
            $desc = str_replace(' ','',$desc);
            $query->where('payment_assistance.desc','LIKE','%'.$desc.'%');
        }
        if($request->commission != ''){
            $commission = str_replace(',','',$request->commission);
            $commission = str_replace('.','',$commission);
            $commission = str_replace('$','',$commission);
            $commission = str_replace(' ','',$commission);
            $query->where('payment_assistance.comision','LIKE','%'.$commission.'%');
        }
        if($request->seller != ''){
            $query->where('payment_assistance.seller','LIKE','%'.$request->seller.'%');
        }
        if($request->user != ''){
            $query->where('payment_assistance.stable_status','LIKE','%'.$request->user.'%');
        }
        if($request->total != ''){
            $total = str_replace(',','',$request->total);
            $total = str_replace('.','',$total);
            $total = str_replace('$','',$total);
            $total = str_replace(' ','',$total);
            $query->where('payment_assistance.total','LIKE','%'.$total.'%');
        }
        $totaly = $query->select('payment_assistance.*');
        $value_tra = 0;
        $value_desc = 0;
        $value_commision = 0;
        $value_total = 0;
        foreach ($totaly->get() as $t){
            $value_tra = $value_tra + $t->price;
            $value_desc = $value_desc + $t->desc;
            $value_commision = $value_commision + $t->comision;
            $value_total = $value_total + $t->total;
        }
        $payment = $query->paginate(10);
        return view('payment-assistance.index',[
            'payment'=>$payment,
            'request'=>$request,
            'value_tra'=>$value_tra,
            'value_desc'=>$value_desc,
            'value_commision'=>$value_commision,
            'value_total'=>$value_total,
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
        return Excel::download(new PaymentAssistanceExport($data), 'Pago_a_asistenciales.xlsx');
    }

    public function pay($name)
    {
        $this->authorize('view', PaymentAssistance::class);
        $explode = explode("=", $name);
        $payment = PaymentAssistance::where('id','>',0);
        if($explode[0] != ''){
            $payment = $payment->where('date','>=',$explode[0]);
        }
        if($explode[1] != ''){
            $payment = $payment->where('date','<=',$explode[1]);
        }

        $user=User::find($explode[3]);
        $payment = $payment->where('asyst','=',$user->name.' '.$user->lastname);

        $payment = $payment->get();
        $paymentOther = PaymentAssistance::where('asyst','=',$user->name.' '.$user->lastname)->get();
        return view('payment-assistance.pay',[
            'payment'=>$payment,
            'paymentOther'=>$paymentOther,
            'pend'=>$explode[2],
            'name'=>$name
        ]);
    }

    public function payGo(Request $request)
    {
        $this->authorize('update', PaymentAssistance::class);
        $array = str_replace('[','',$request->vector);
        $array = str_replace(']','',$array);
        $vector = explode(',',$array);
        for($i = 0; $i < count($vector); ++$i){
            $payment = PaymentAssistance::find($vector[$i]);
            $payment->pay = 'si';
            $payment->save();
        }
        return response(json_encode('hello world'), 201)->header('Content-Type', 'text/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
