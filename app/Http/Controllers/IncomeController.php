<?php

namespace App\Http\Controllers;

use App\Exports\IncomesExport;
use App\Models\Account;
use App\Models\BalanceBox;
use App\Models\CenterCost;
use App\Models\CommissionCentercost;
use App\Models\Contract;
use App\Models\Income;
use App\Models\IncomesComisiones;
use App\Models\Patient;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IncomeController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function generatePDF($id)

    {
        $data = Income::find($id);
        $pdf = $this->pdf->loadView('pdf.incomes', ['data' => $data]);
        return $pdf->stream('Ingreso-Smadia.pdf');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Income::class);
        $query = Income::orderBy('incomes.id','desc')
            ->join('patients', 'patients.id', '=', 'incomes.patient_id')
            ->join('users as seller', 'seller.id', '=', 'incomes.seller_id')
            //->join('users as follow', 'follow.id', '=', 'incomes.follow_id')
            ->join('users', 'users.id', '=', 'incomes.responsable_id')
            //->join('center_costs', 'center_costs.id', '=', 'incomes.center_cost_id')
            ->where('incomes.amount','>',0);
        if($request->id != ''){
            $id_r = str_replace("I", "", $request->id);
            $id_r = str_replace("i", "", $id_r);
            $id_r = str_replace("-", "", $id_r);
            $query->where('incomes.id','LIKE','%'.$id_r.'%');
        }
        if($request->patient != ''){
            $porciones = explode(" ", $request->patient);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(patients.name," ",patients.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->cc != ''){
            $query->where('patients.identy','LIKE','%'.$request->cc.'%');
        }
        if($request->value != ''){
            $monto = $request->value;
            $monto = str_replace(".", "", $monto);
            $monto = str_replace(".", "", $monto);
            $query->where('incomes.amount','LIKE',''.$monto.'%');
            //$query->where('incomes.amount_one','LIKE',''.$monto.'%');
            $query->orWhere('incomes.amount_two','LIKE',''.$monto.'%');
        }
        if($request->description != ''){
            $query->where('incomes.comment','LIKE','%'.$request->description.'%');
        }
        if($request->center_cost != ''){
            $query->where('incomes.center_cost_id','=',$request->center_cost);
        }
        if($request->form_pay != ''){
            $datos= $request->form_pay;
            $query->where(function ($query_2) use ($datos) {
                $query_2->where('incomes.method_of_pay','=',$datos)
                    ->orWhere('incomes.method_of_pay_2','=',$datos);
            });
            //$query->where('incomes.method_of_pay','=',$request->form_pay);
            //$query->orWhere('incomes.method_of_pay_2','=',$request->form_pay);
        }
        if($request->date != ''){
            $query->where('incomes.created_at','LIKE','%'.$request->date.'%');
        }
        if($request->contract != ''){
            $contract = str_replace('C-','',$request->contract);
            $query->where('incomes.contract_id','LIKE','%'.$contract.'%');
        }
        if($request->seller != ''){
            $porciones = explode(" ", $request->seller);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(seller.name," ",seller.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->responsable != ''){
            $porciones = explode(" ", $request->responsable);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(users.name," ",users.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->follow != ''){
            /*$porciones = explode(" ", $request->follow);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(follow.name," ",follow.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }*/
            $query->where('incomes.follow_id','=',$request->follow);
        }
        if($request->status != ''){
            $query->where('incomes.status','LIKE','%'.$request->status.'%');
        }
        
        if($request->number_aprov != ''){
            $query->where('incomes.approved_of_card','LIKE','%'.$request->number_aprov.'%')
            ->orWhere('incomes.approved_of_card_2','LIKE','%'.$request->number_aprov.'%');
        }


        $totaly = $query->select('incomes.*');
        $value_total = 0;
        foreach ($totaly->get() as $t){
            $validate_1 = true;
            $validate_2 = true;
            if($t->method_of_pay_2 != ''){
                if($request->form_pay != ''){
                    $validate_1 = false;
                    $validate_2 = false;
                    if($request->form_pay == $t->method_of_pay){
                        $validate_1 = true;
                    }
                    if($request->form_pay == $t->method_of_pay_2){
                        $validate_2 = true;
                    }
                    if($validate_1 == true){
                        $value_total = $value_total + $t->amount_one;
                    }
                    if($validate_2 == true){
                        $value_total = $value_total + $t->amount_two;
                    }
                }
            }else{
                $value_total = $value_total + $t->amount;
            }
        }
        $data = $query->paginate(10);
        $follows =  User::all();
        $user = Auth::user();
        return view('incomes.index', [
            'incomes' => $data,
            'request'=>$request,
            'value_total'=>$value_total,
            'centers'=>CenterCost::where(['status' => 'activo', 'type' => 'ingreso'])->orderBy('name')->get(),
            'follows'=>$follows,
            'user'=>$user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create', Income::class);
        /*
        $income = Income::find(42);
        Mail::to("hsmadera18@gmail.com")->send(new \App\Mail\Income($income));
        return false;
        */
        request()->validate([
            'amount' => 'required',
            'patient_id' => 'required|integer',
            'responsable_id' => 'required|integer',
            'method_of_pay' => 'required',
            'comment' => 'required|max:500|min:3',
        ]);

        //return response(json_encode(["message" => count($request->contract)]), 201)->header('Content-Type', 'text/json');
        if (isset($request->contract)) {
            $total = 0;
            foreach ($request->contract as $c) {
                request()->validate([
                    'V-' . $c => 'required'
                ]);
                $amount = str_replace(".", "", $request->input("V-" . $c));
                $amount = str_replace(",", "", $amount);
                $total += $amount;
            }
        }

        $amounTotal = str_replace(".", "", $request->amount);
        $amounTotal = str_replace(",", "", $amounTotal);
        $amounOneTotal = 0;
        $amounTwoTotal = 0;
        if ($request->method_of_pay_2 != "") {
            $amounOneTotal = str_replace(".", "", $request->amount_one);
            $amounOneTotal = str_replace(",", "", $amounOneTotal);
            $amounTwoTotal = str_replace(".", "", $request->amount_two);
            $amounTwoTotal = str_replace(",", "", $amounTwoTotal);
            if ($amounTotal != $amounOneTotal + $amounTwoTotal) {
                return response(json_encode(["message" => "El valor del ingreso no puede ser superior o inferior a la suma de los valores de las formas de pago"]), 400)->header('Content-Type', 'text/json');
            }
        }


        if (isset($request->contract) && $total != $amounTotal) {
            return response(json_encode(["message" => "El valor del ingreso no puede ser superior o inferior a la suma de los ingresos de los contratos"]), 400)->header('Content-Type', 'text/json');
        }

        //validar prueba de imagen
        /*
        if ($request->receipt_2 != "" && $request->method_of_pay_2 == "tarjeta") {
            $path = "receipt/".$request->approved_of_card_2. '-C-' . 2 .".jpg";
            $status = file_put_contents($path,base64_decode($request->receipt_2));
        }
        return response(json_encode(["message" => 'Entro:'.$request->receipt]),
            400)
            ->header('Content-Type', 'text/json');
        */
        //endvalidar

        if (isset($request->contract)) {
            foreach ($request->contract as $c) {
                $amount = str_replace(".", "", $request->input("V-" . $c));
                $amount = str_replace(",", "", $amount);
                $contract_id = explode("-", $c);
                $contract_id = intval($contract_id[0]);
               
                
                $income = Income::create([
                   'patient_id' => $request->patient_id,
                   'seller_id' => $request->input("seller_id-" . $c),
                   'responsable_id' => $request->responsable_id,
                   'contract_id' => $contract_id,
                   'user_id' => Auth::id(),
                   'center_cost_id' => $request->input("center_cost_id-" . $c),
                   'amount' => $amount,
                   'amount_one' => $amounOneTotal,
                   'amount_two' => $amounTwoTotal,
                   'method_of_pay' => $request->method_of_pay,
                   'campaign'=>$request->campaign,
                   'type_of_card' => $request->type_of_card,
                   'approved_of_card' => $request->approved_of_card,
                   'account_id' => $request->account_id,
                   'card_entity' => $request->card_entity,
                   'origin_bank' => $request->origin_bank,
                   'origin_account' => $request->origin_account,
                   'ref_epayco' => $request->ref_epayco,
                   'approved_epayco' => $request->approved_epayco,
                   'method_of_pay_2' => $request->method_of_pay_2,
                   'type_of_card_2' => $request->type_of_card_2,
                   'approved_of_card_2' => $request->approved_of_card_2,
                    'account_2_id' => $request->account2_id,
                   'card_entity_2' => $request->card_entity_2,
                   'origin_bank_2' => $request->origin_bank_2,
                   'origin_account_2' => $request->origin_account_2,
                   'ref_epayco_2' => $request->ref_epayco_2,
                   'approved_epayco_2' => $request->approved_epayco_2,
                   'comment' => $request->comment,
                   'type' => $request->input("type-" . $c),
                    'unification' => $request->unification,
                    'unification_2' => $request->unification_2,
                    'follow_id' => $request->follow_id,
                    
                ]);
                $contrac = Contract::find($contract_id);
                $amountBalance = Income::where('contract_id',$contract_id)->where('status','activo')->get();
                $amount = 0;
                foreach ($amountBalance as $a){
                    $amount = $amount + $a->amount;
                }
                $contrac->update(['balance' => $amount]);

                if($income->method_of_pay == 'efectivo'){
                    $amount = 0;
                    $dateToday = date("Y-m-d");
                    if($income->amount_one == ''){
                        $amount=$income->amount;
                    }else{
                        $amount=$income->amount_one;
                    }
                    $balanceBox = BalanceBox::create([
                        'user_id' => $income->responsable_id,
                        'patient_id' => $income->patient_id,
                        'con_id' => $income->id,
                        'type' => 'Ingreso',
                        'monto' => $amount,
                        'date' => $dateToday,
                    ]);
                }
                if($income->method_of_pay_2 == 'efectivo'){
                    if($income->amount_two == ''){
                        $amount = 0;
                    }else{
                        $amount = $income->amount_two;
                    }
                    $dateToday = date("Y-m-d");
                    $balanceBox = BalanceBox::create([
                        'user_id' => $income->responsable_id,
                        'patient_id' => $income->patient_id,
                        'con_id' => $income->id,
                        'type' => 'Ingreso',
                        'monto' => $income->amount_two,
                        'date' => $dateToday,
                    ]);
                }
                //comision de ingreso //
                $seller = CommissionCentercost::where('user_id',$income->seller_id)
                    ->where('center_cost_id',$income->center_cost_id)->get();
                if(count($seller) > 0){
                    $seller = CommissionCentercost::where('user_id',$income->seller_id)
                        ->where('center_cost_id',$income->center_cost_id)->first();
                    if($seller->commission_income > 0){
                        $dateToday = date("Y-m-d");
                        if($income->amount_one == ''){
                            $amount=$income->amount;
                        }else{
                            $amount=$income->amount_one;
                        }
                        $pay_card = 'no';
                        if($income->method_of_pay == 'tarjeta' || $income->method_of_pay == 'online'){
                            $pay_card = 'si';
                        }
                        if($pay_card == 'si'){
                            $totally = $amount - ( ( $amount * 5 ) / 100);
                        }else{
                            $totally = $amount;
                        }
                        $commision = ($totally * $seller->commission_income) / 100;
                        if($commision > 0){
                            $incomesComm = IncomesComisiones::create([
                                'user_id'=>Auth::id(),
                                'income_id'=>$income->id,
                                'patient_id'=>$income->patient_id,
                                'seller_id'=>$income->seller_id,
                                'amount'=>$amount,
                                'description'=>$income->comment,
                                'center_cost_id'=>$income->center_cost_id,
                                'form_pay'=>$income->method_of_pay,
                                'contract'=>'C-'.$income->contract_id,
                                'date'=>$dateToday,
                                'pay_card'=>$pay_card,
                                'totally'=>$totally,
                                'commission'=>$commision
                            ]);
                        }
                        if($income->method_of_pay_2 != ''){
                            if($income->amount_two == ''){
                                $amount = 0;
                            }else{
                                $amount = $income->amount_two;
                            }
                            $pay_card = 'no';
                            if($income->method_of_pay_2 == 'tarjeta' || $income->method_of_pay_2 == 'online'){
                                $pay_card = 'si';
                            }
                            if($pay_card == 'si'){
                                $totally = $amount - ( ( $amount * 5 ) / 100);
                            }else{
                                $totally = $amount;
                            }
                            $commision = ($totally * $seller->commission_income) / 100;
                            if($commision > 0) {
                                $incomesComm = IncomesComisiones::create([
                                    'user_id' => Auth::id(),
                                    'income_id' => $income->id,
                                    'patient_id' => $income->patient_id,
                                    'seller_id' => $income->seller_id,
                                    'amount' => $amount,
                                    'description' => $income->comment,
                                    'center_cost_id' => $income->center_cost_id,
                                    'form_pay' => $income->method_of_pay_2,
                                    'contract' => 'C-' . $income->contract_id,
                                    'date' => $dateToday,
                                    'pay_card' => $pay_card,
                                    'totally' => $totally,
                                    'commission' => $commision
                                ]);
                            }
                        }
                    }
                }
                //end comision de ingreso //
                if ($request->receipt != "" && $request->method_of_pay == "tarjeta") {
                    $path = "receipt/".$request->approved_of_card. '-C-' . $income->id .".jpg";
                    $status = file_put_contents($path,base64_decode($request->receipt));
                    $income->update([
                        'receipt' => $path
                    ]);
                }

                if ($request->receipt_2 != "" && $request->method_of_pay_2 == "tarjeta") {
                    $path = "receipt/".$request->approved_of_card_2. '-C-' . $income->id .".jpg";
                    $status = file_put_contents($path,base64_decode($request->receipt_2));
                    $income->update([
                        'receipt_2' => $path
                    ]);
                }
                try{
                    //Mail::to("hsmadera18@gmail.com")->send(new \App\Mail\Income($income));
                    Mail::to("gerencia@smadiaclinic.com")->send(new \App\Mail\Income($income));
                    Mail::to("admon@smadiaclinic.com")->send(new \App\Mail\Income($income));
                }catch (\Exception $e){
                }
            }
            return response(json_encode(["message" => "Saved"]), 201)->header('Content-Type', 'text/json');
        } else {
            $income = Income::create([
                'patient_id' => $request->patient_id,
                'seller_id' => $request->seller_id,
                'responsable_id' => $request->responsable_id,
                'user_id' => Auth::id(),
                'center_cost_id' => $request->center_cost_id,
                'amount' => $amounTotal,
                'amount_one' => $amounOneTotal,
                'amount_two' => $amounTwoTotal,
                'method_of_pay' => $request->method_of_pay,
                'campaign'=>$request->campaign,
                'type_of_card' => $request->type_of_card,
                'approved_of_card' => $request->approved_of_card,
                'card_entity' => $request->card_entity,
                'origin_bank' => $request->origin_bank,
                'origin_account' => $request->origin_account,
                'ref_epayco' => $request->ref_epayco,
                'approved_epayco' => $request->approved_epayco,
                'method_of_pay_2' => $request->method_of_pay_2,
                'type_of_card_2' => $request->type_of_card_2,
                'approved_of_card_2' => $request->approved_of_card_2,
                'card_entity_2' => $request->card_entity_2,
                'origin_bank_2' => $request->origin_bank_2,
                'origin_account_2' => $request->origin_account_2,
                'ref_epayco_2' => $request->ref_epayco_2,
                'approved_epayco_2' => $request->approved_epayco_2,
                'comment' => $request->comment,
                'type' => 'bolsa',
                'unification' => $request->unification,
                'unification_2' => $request->unification_2,
                'follow_id' => $request->follow_id,
                'approved_Banco' => $request->approved_Banco,
                'approved_Banco_2' => $request->approved_Banco_2,
            ]);

            if($income->method_of_pay == 'efectivo'){
                $amount = 0;
                $dateToday = date("Y-m-d");
                if($income->amount_one == ''){
                    $amount=$income->amount;
                }else{
                    $amount=$income->amount_one;
                }
                $balanceBox = BalanceBox::create([
                    'user_id' => $income->responsable_id,
                    'patient_id' => $income->patient_id,
                    'con_id' => $income->id,
                    'type' => 'Ingreso',
                    'monto' => $amount,
                    'date' => $dateToday,
                ]);
            }
            if($income->method_of_pay_2 == 'efectivo'){
                if($income->amount_two == ''){
                    $amount = 0;
                }else{
                    $amount = $income->amount_two;
                }
                $dateToday = date("Y-m-d");
                $balanceBox = BalanceBox::create([
                    'user_id' => $income->responsable_id,
                    'patient_id' => $income->patient_id,
                    'con_id' => $income->id,
                    'type' => 'Ingreso',
                    'monto' => $income->amount_two,
                    'date' => $dateToday,
                ]);
            }

            //comision de ingreso not contract //
            /*
            $seller = User::find($income->seller_id);
            if($seller->commission_income != '' || $seller->commission_income > 0){
                $dateToday = date("Y-m-d");
                if($income->amount_one == ''){
                    $amount=$income->amount;
                }else{
                    $amount=$income->amount_one;
                }
                $pay_card = 'no';
                if($income->method_of_pay == 'tarjeta' || $income->method_of_pay == 'online'){
                    $pay_card = 'si';
                }
                if($pay_card == 'si'){
                    $totally = $amount - ( ( $amount * 5 ) / 100);
                }else{
                    $totally = $amount;
                }
                $commision = ($totally * $seller->commission_income) / 100;
                if($commision > 0){
                    $incomesComm = IncomesComisiones::create([
                        'user_id'=>Auth::id(),
                        'income_id'=>$income->id,
                        'patient_id'=>$income->patient_id,
                        'seller_id'=>$income->seller_id,
                        'amount'=>$amount,
                        'description'=>$income->comment,
                        'center_cost_id'=>$income->center_cost_id,
                        'form_pay'=>$income->method_of_pay,
                        'contract'=>'',
                        'date'=>$dateToday,
                        'pay_card'=>$pay_card,
                        'totally'=>$totally,
                        'commission'=>$commision
                    ]);
                }
                if($income->method_of_pay_2 != ''){
                    if($income->amount_two == ''){
                        $amount = 0;
                    }else{
                        $amount = $income->amount_two;
                    }
                    $pay_card = 'no';
                    if($income->method_of_pay_2 == 'tarjeta' || $income->method_of_pay_2 == 'online'){
                        $pay_card = 'si';
                    }
                    if($pay_card == 'si'){
                        $totally = $amount - ( ( $amount * 5 ) / 100);
                    }else{
                        $totally = $amount;
                    }
                    $commision = ($totally * $seller->commission_income) / 100;
                    if($commision > 0) {
                        $incomesComm = IncomesComisiones::create([
                            'user_id' => Auth::id(),
                            'income_id' => $income->id,
                            'patient_id' => $income->patient_id,
                            'seller_id' => $income->seller_id,
                            'amount' => $amount,
                            'description' => $income->comment,
                            'center_cost_id' => $income->center_cost_id,
                            'form_pay' => $income->method_of_pay_2,
                            'contract' => '',
                            'date' => $dateToday,
                            'pay_card' => $pay_card,
                            'totally' => $totally,
                            'commission' => $commision
                        ]);
                    }
                }
            }
            */
            //end comision de ingreso not contract//

            if ($request->receipt != "" && $request->method_of_pay == "tarjeta") {
                $path = "receipt/".$request->approved_of_card.'-I'.$income->id.".jpg";
                $status = file_put_contents($path,base64_decode($request->receipt));
                $income->update([
                    'receipt' => $path
                ]);
            }

            if ($request->receipt_2 != "" && $request->method_of_pay_2 == "tarjeta") {
                $path = "receipt/".$request->approved_of_card_2.'-I'.$income->id.".jpg";
                $status = file_put_contents($path,base64_decode($request->receipt_2));
                $income->update([
                    'receipt_2' => $path
                ]);
            }
        }

        try{
            //Mail::to("hsmadera18@gmail.com")->send(new \App\Mail\Income($income));
            Mail::to("gerencia@smadiaclinic.com")->send(new \App\Mail\Income($income));
            Mail::to("admon@smadiaclinic.com")->send(new \App\Mail\Income($income));
        }catch (\Exception $e){

        }
        session(['menu_patient_show' => 4]);
        return response(json_encode(["message" => "Saved."]), 201)->header('Content-Type', 'text/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('incomes.show', [
            'income' => Income::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Income::class);
        return view('incomes.edit', [
            'i' => Income::find($id),
            'centers' => CenterCost::where(['status' => 'activo', 'type' => 'ingreso'])->orderBy('name')->get(),
            'users' => User::where('status', 'activo')->orderBy('name')->get(),
            'user' => Auth::user(),
            'accounts' => Account::where(['status' => 'activo'])->get(),
        ]);
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
        $this->authorize('update', Income::class);
        request()->validate([
            'amount' => 'required',
            'patient_id' => 'required|integer',
            'responsable_id' => 'required|integer',
            'method_of_pay' => 'required',
            'comment' => 'required|max:500|min:3',
        ]);

        $amounTotal = str_replace(".", "", $request->amount);
        $amounTotal = str_replace(",", "", $amounTotal);
        $amounOneTotal = 0;
        $amounTwoTotal = 0;
        if ($request->method_of_pay_2 != "") {
            $amounOneTotal = str_replace(".", "", $request->amount_one);
            $amounOneTotal = str_replace(",", "", $amounOneTotal);
            $amounTwoTotal = str_replace(".", "", $request->amount_two);
            $amounTwoTotal = str_replace(",", "", $amounTwoTotal);
            if ($amounTotal != $amounOneTotal + $amounTwoTotal) {
                return response(json_encode(["message" => "El valor del ingreso no puede ser superior o inferior a la suma de los valores de las formas de pago"]), 400)->header('Content-Type', 'text/json');
            }
        }
        $income = Income::find($request->income_id);
        if($request->contract_id != ''){
            $contract = Contract::find($request->contract_id);
            if (!($contract->amount != $amounTotal)) {
                return response(json_encode(["message" => "El valor del ingreso no puede ser superior o inferior a la suma total del contrato"]), 400)->header('Content-Type', 'text/json');
            }

            $amount = str_replace(".", "", $request->input("V-amount"));
            $amount = str_replace(",", "", $amount);
            $c = $request->income_id;
            $income->update([
                'patient_id' => $request->patient_id,
                'seller_id' => $request->input("seller_id-" . $c),
                'responsable_id' => $request->responsable_id,
                'contract_id' => $request->contract_id,
                'user_id' => Auth::id(),
                'center_cost_id' => $request->input("center_cost_id-" . $c),
                'amount' => $amount,
                'amount_one' => $amounOneTotal,
                'amount_two' => $amounTwoTotal,
                'method_of_pay' => $request->method_of_pay,
                'campaign'=>$request->campaign,
                'type_of_card' => $request->type_of_card,
                'approved_of_card' => $request->approved_of_card,
                'account_id' => $request->account_id,
                'card_entity' => $request->card_entity,
                'origin_bank' => $request->origin_bank,
                'origin_account' => $request->origin_account,
                'ref_epayco' => $request->ref_epayco,
                'approved_epayco' => $request->approved_epayco,
                'method_of_pay_2' => $request->method_of_pay_2,
                'type_of_card_2' => $request->type_of_card_2,
                'approved_of_card_2' => $request->approved_of_card_2,
                'account_2_id' => $request->account2_id,
                'card_entity_2' => $request->card_entity_2,
                'origin_bank_2' => $request->origin_bank_2,
                'origin_account_2' => $request->origin_account_2,
                'ref_epayco_2' => $request->ref_epayco_2,
                'approved_epayco_2' => $request->approved_epayco_2,
                'comment' => $request->comment,
                'type' => $request->input("type-" . $c),
            ]);

            $contrac = Contract::find($request->contract_id);
            $amountBalance = Income::where('contract_id',$request->contract_id)->where('status','activo')->get();
            $amount = 0;
            foreach ($amountBalance as $a){
                $amount = $amount + $a->amount;
            }
            $contrac->update(['balance' => $amount]);
        }else{
            $income->update([
                'patient_id' => $request->patient_id,
                'seller_id' => $request->seller_id,
                'responsable_id' => $request->responsable_id,
                'user_id' => Auth::id(),
                'center_cost_id' => $request->center_cost_id,
                'amount' => $amounTotal,
                'amount_one' => $amounOneTotal,
                'amount_two' => $amounTwoTotal,
                'method_of_pay' => $request->method_of_pay,
                'campaign'=>$request->campaign,
                'type_of_card' => $request->type_of_card,
                'approved_of_card' => $request->approved_of_card,
                'card_entity' => $request->card_entity,
                'origin_bank' => $request->origin_bank,
                'origin_account' => $request->origin_account,
                'ref_epayco' => $request->ref_epayco,
                'approved_epayco' => $request->approved_epayco,
                'method_of_pay_2' => $request->method_of_pay_2,
                'type_of_card_2' => $request->type_of_card_2,
                'approved_of_card_2' => $request->approved_of_card_2,
                'card_entity_2' => $request->card_entity_2,
                'origin_bank_2' => $request->origin_bank_2,
                'origin_account_2' => $request->origin_account_2,
                'ref_epayco_2' => $request->ref_epayco_2,
                'approved_epayco_2' => $request->approved_epayco_2,
                'comment' => $request->comment,
                'type' => 'bolsa',
            ]);
        }

        $balanceBoxAll = BalanceBox::where('con_id',$request->income_id)->where('type','Ingreso')->get();
        if($income->method_of_pay == 'efectivo'){
            $amount = 0;
            if($income->amount_one == ''){
                $amount=$income->amount;
            }else{
                $amount=$income->amount_one;
            }
            $balanceBox = $balanceBoxAll[0];
            $balanceBox->update([
                'type' => 'Ingreso',
                'monto' => $amount,
            ]);
        }else{
            $balanceBox = $balanceBoxAll[0];
            $balanceBox->update([
                'type' => 'Ingreso Anulado',
            ]);
        }
        if($income->method_of_pay_2 == 'efectivo'){
            if($income->amount_two == ''){
                $amount = 0;
            }else{
                $amount = $income->amount_two;
            }
            $dateToday = date("Y-m-d");
            if($balanceBoxAll->count() >= 2){
                $balanceBox = $balanceBoxAll[1];
                $balanceBox->update([
                    'type' => 'Ingreso',
                    'monto' => $income->amount_two,
                ]);
            }else{
                $balanceBox = BalanceBox::create([
                    'user_id' => $income->responsable_id,
                    'patient_id' => $income->patient_id,
                    'con_id' => $income->id,
                    'type' => 'Ingreso',
                    'monto' => $income->amount_two,
                    'date' => $dateToday,
                ]);
            }
        }else{
            if($balanceBoxAll->count() >= 2){
                $balanceBox = $balanceBoxAll[1];
                $balanceBox->update([
                    'type' => 'Ingreso Anulado',
                ]);
            }
        }
        return response(json_encode(["message" => "Saved."]), 201)->header('Content-Type', 'text/json');
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

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end")
        ];
        return Excel::download(new IncomesExport($data), 'Ingresos.xlsx');
    }

    public function anulate(Request $request)
    {
        $id = $request->id;
        $income = Income::find($id);
        $income->status = 'anulado';
        $income->motivo = $request->motivo;
        $income->save();
        $balanceBox = BalanceBox::where('con_id',$income->id)->where('type','Ingreso')->get();
        foreach ($balanceBox as $b){
            $balanceB = BalanceBox::find($b->id);
            $balanceB->type = 'Ingreso Anulado';
            $balanceB->save();
        }

        if($income->contract_id != '' && $income->contract_id != null){
            $contract = Contract::find($income->contract_id);
            if($income->amount > $contract->balance){
                $value_total = $income->amount - $contract->balance;
            }else{
                $value_total = $contract->balance - $income->amount;
            }
            $contract->balance = str_replace('-','',$value_total);
            $contract->save();
        }
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }

    public function updateMoneyBox(Request $request){


        $id_income = $request->input('income_id');
        $id_contract = $request->input('contract_id');
        $id_patient = $request->input('patient_id');
        $contract = Contract::find($id_contract);
        $income = Income::find($id_income);

        $amount = $request->input('cant_money');
        $amount = str_replace('.','',$amount);
        $amount = str_replace(',','',$amount);
        if($amount > $income->amount){
            return 'El dinero a ingresar es mayor al disponible';
        }
        if($income->patient_id != $id_patient){
           $userData = Patient::find(intval($id_patient));
            //return $userData->name;
         $income->amount = $income->amount - $amount;
           $income->comment = $income->comment .
               ' Se ha enviado: $'.number_format($amount, 0, ',', '.').' al paciente '.$userData->name.' '.$userData->lastname;
           //return false;
           if($income->save()){
               $income = Income::find($id_income);
               if($income->amount <= 0){
                   $income->status = 'anulado';
                   $income->motivo = $income->motivo .
                       ' Se ha enviado: $'.number_format($amount, 0, ',', '.').' al paciente '.$userData->name.' '.$userData->lastname;
                   /*
                   $balanceBox = BalanceBox::where('con_id',$income->id)->where('type','Ingreso')->get();
                   foreach ($balanceBox as $b){
                       $balanceB = BalanceBox::find($b->id);
                       $balanceB->type = 'Ingreso Anulado';
                       $balanceB->save();
                   }
                   */
               }else{
                   /*
                   $balanceBox = BalanceBox::where('con_id',$income->id)->where('type','Ingreso')->get();
                   foreach ($balanceBox as $b){
                       $balanceB = BalanceBox::find($b->id);
                       $balanceB->monto = $balanceB->monto - $amount;
                       $balanceB->save();
                   }*/
               }
               $incomeCreate = Income::create([
                   'patient_id' => $id_patient,
                   'seller_id' => $income->seller_id,
                   'responsable_id' => Auth::id(),
                   'user_id' => Auth::id(),
                   'center_cost_id' => 0,
                   'amount' => $amount,
                   'amount_one' => 0,
                   'amount_two' => 0,
                   'method_of_pay' =>'software',
                   'campaign'=>'',
                   'type_of_card' => '',
                   'approved_of_card' => '',
                   'card_entity' => '',
                   'origin_bank' => '',
                   'origin_account' => '',
                   'ref_epayco' => '',
                   'approved_epayco' => '',
                   'method_of_pay_2' => '',
                   'type_of_card_2' => '',
                   'approved_of_card_2' => '',
                   'card_entity_2' => '',
                   'origin_bank_2' => '',
                   'origin_account_2' => '',
                   'ref_epayco_2' => '',
                   'approved_epayco_2' => '',
                   'comment' => 'Valor enviado del dinero en caja por transferencia del paciente '.$income->patient->name.' '.$income->patient->lastname,
                   'type' => 'bolsa',
                   'created_at'=>$income->created_at
               ]);
               return '1';
           }else{
               return 'Ha ocurrido un error';
           }
           return 'Entro:'.$id_patient;
        }

        if($id_contract == ''){
            return 'Debe seleccionar un contrato';
        }
        $total = $contract->amount - $contract->balance;
        if($amount > $total){
            return 'El ingreso $'.number_format($amount,0).
                ' es mayor al dinero pendiente de pago en el contrato $'.number_format($total,0);
        }
        //$income->contract_id = $id_contract;
        $income->amount = $income->amount - $amount;
        $income->comment = $income->comment .
            ' Se ha enviado: $'.number_format($amount, 0, ',', '.').' al contrato C-'.$contract->id;
        if($income->save()){
            $income = Income::find($id_income);
            if($income->amount <= 0){
                $income->status = 'anulado';
                $income->motivo = $income->motivo . ' Se ha enviado: $'.number_format($amount, 0, ',', '.').' al contrato C-'.$contract->id;
                /*
                $balanceBox = BalanceBox::where('con_id',$income->id)->where('type','Ingreso')->get();
                foreach ($balanceBox as $b){
                    $balanceB = BalanceBox::find($b->id);
                    $balanceB->type = 'Ingreso Anulado';
                    $balanceB->save();
                }*/
            }else{
                /*
                $balanceBox = BalanceBox::where('con_id',$income->id)->where('type','Ingreso')->get();
                foreach ($balanceBox as $b){
                    $balanceB = BalanceBox::find($b->id);
                    $balanceB->monto = $balanceB->monto - $amount;
                    $balanceB->save();
                }*/
            }

            $contract->balance = $contract->balance + $amount;
            $contract->save();
            $incomeCreate = Income::create([
                'patient_id' => $id_patient,
                'contract_id'=>$contract->id,
                'seller_id' => $income->seller_id,
                'responsable_id' => Auth::id(),
                'user_id' => Auth::id(),
                'center_cost_id' => $income->center_cost_id,
                'amount' => $amount,
                'amount_one' => 0,
                'amount_two' => 0,
                'method_of_pay' =>$income->method_of_pay,
                'campaign'=>'',
                'type_of_card' => '',
                'approved_of_card' => '',
                'card_entity' => '',
                'origin_bank' => '',
                'origin_account' => '',
                'ref_epayco' => '',
                'approved_epayco' => '',
                'method_of_pay_2' => '',
                'type_of_card_2' => '',
                'approved_of_card_2' => '',
                'card_entity_2' => '',
                'origin_bank_2' => '',
                'origin_account_2' => '',
                'ref_epayco_2' => '',
                'approved_epayco_2' => '',
                'comment' => 'Valor enviado del dinero en caja de otro ingreso',
                'type' => 'bolsa',
                'created_at'=>$income->created_at
            ]);
            /*
            if($income->method_of_pay == 'efectivo'){
                $dateToday = date("Y-m-d");
                $balanceBox = BalanceBox::create([
                    'user_id' => Auth::id(),
                    'patient_id' => $id_patient,
                    'con_id' => $incomeCreate->id,
                    'type' => 'Ingreso',
                    'monto' => $amount,
                    'date' => $dateToday,
                ]);
            }
            */
            return '1';
        }else{
            return 'Ha ocurrido un error';
        }
    }
}
