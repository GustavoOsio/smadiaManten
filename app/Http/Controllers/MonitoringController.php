<?php

namespace App\Http\Controllers;

use App\Exports\MonitoringExports;
use App\Models\CommissionService;
use App\Models\Consumed;
use App\Models\ContactSource;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Income;
use App\Models\InformedConsents;
use App\Models\Item;
use App\Models\Monitoring;
use App\Models\Patient;
use App\Models\PayDoctors;
use App\Models\PaymentAssistance;
use App\Models\PercentValues;
use App\Models\Schedule;
use App\Models\ScheduleHistorial;
use App\Models\Service;
use App\Models\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', Monitoring::class);
        $dateToday = date("Y-m-d");
         $updMoni = Monitoring::where('date','<',$dateToday)
            ->where('status','activo')
            ->get();
        foreach($updMoni as $m){
            $updateMoni = Monitoring::find($m->id);
            $updateMoni->status = 'vencido';
            $updateMoni->save();
        }
        $user_id= Auth::user()->id;
        $monitorings = Monitoring::where('responsable_id',$user_id)->orderByDesc('created_at')->get();
        return view('monitorings.index', ['monitorings' => $monitorings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $this->authorize('create', Monitoring::class);
        return view('monitorings.create', [
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
            'patient' => Patient::find($id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $this->authorize('create', Monitoring::class);

        if ($request->schedule_id) {



             $schedule = Schedule::find($request->schedule_id);
             $fechaHoy=date('Y-m-d');

if($fechaHoy>=$schedule->date){
            if($request->status_schedule == 'fallida'){
                $schedule->update(['status' => 'fallida']);
                $h_schedule = ScheduleHistorial::create([
                    'patient_id'=>$schedule->patient_id,
                    'schedule_id'=>$schedule->id,
                    'date'=>$schedule->date,
                    'status'=>$request->status_schedule,
                    'professional'=>User::find($schedule->personal_id)->name .' '.User::find($schedule->personal_id)->lastname,
                    'contract'=>$schedule->contract_id,
                    'service'=>Service::find($schedule->service_id)->name,
                    'comment'=>$schedule->comment,
                    'start'=>$schedule->start_time,
                    'end'=>$schedule->end_time,
                    'comment_update'=>'',
                    'date_update'=>date("Y-m-d"),
                    'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
                ]);
            }else if($request->status_schedule == 'cancelada'){
                Monitoring::create([
                    'patient_id' => $request->patient_id,
                    'responsable_id' => $request->responsable_id,
                    'user_id' => Auth::id(),
                    'issue_id' => $request->issue_id,
                    'date' => $request->date,
                    'comment' => $request->comment,
                ]);
                $h_schedule = ScheduleHistorial::create([
                    'patient_id'=>$schedule->patient_id,
                    'schedule_id'=>$schedule->id,
                    'date'=>$schedule->date,
                    'status'=>$request->status_schedule,
                    'professional'=>User::find($schedule->personal_id)->name .' '.User::find($schedule->personal_id)->lastname,
                    'contract'=>$schedule->contract_id,
                    'service'=>Service::find($schedule->service_id)->name,
                    'comment'=>$schedule->comment,
                    'start'=>$schedule->start_time,
                    'end'=>$schedule->end_time,
                    'comment_update'=>$request->comment,
                    'date_update'=>date("Y-m-d"),
                    'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
                ]);
                return response(json_encode(["message" => "schedule_cancelada", "patient_id" => $request->patient_id]), 201)->header('Content-Type', 'text/json');
                //$schedule->update(['status' => 'fallida']);
            }else{
                if($schedule->service->contract == 'SI'){
                    // SCHEDULE VALIDATE CONTRACT
                    if ($schedule->contract_id == "") {
                        if($request->contract_id == ''){
                            return response(json_encode(intval($schedule->service->name)), 203)->header('Content-Type', 'text/json');
                        }
                        if($request->contract_id != '')
                        {
                            $shedule_validate_agend = Schedule::where('service_id',$schedule->service_id)
                                ->where('contract_id',$request->contract_id)
                                ->whereIn('status', ['programada', 'confirmada','completada','vencida'])
                                ->count();
                            $item_validate = Item::where(["contract_id" => $request->contract_id, "service_id" => $schedule->service_id])->get();
                            $service= Service::find($schedule->service_id);
                            $validate_agenda_service = true;
                            $item_validate_qty = 0;
                            if($service->type == 'sesion'){
                                foreach ($item_validate as $itemV){
                                    $item_validate_qty = $item_validate_qty + $itemV->qty;
                                }
                                if($shedule_validate_agend >= $item_validate_qty){
                                    $validate_agenda_service = true;
                                }else{
                                    $validate_agenda_service = false;
                                }
                            }else{
                                $item_validate_qty = count($item_validate);
                                if($shedule_validate_agend >= $item_validate_qty){
                                    $validate_agenda_service = true;
                                }else{
                                    $validate_agenda_service = false;
                                }
                            }
                            if($validate_agenda_service == true){
                                return response(json_encode(["message" => "Ya se han agendado todas las citas del servicio ".$service->name.
                                    " para el contrato C-".$request->contract_id]), 400)
                                    ->header('Content-Type', 'text/json');
                            }
                        }

                        $items = Item::where(["contract_id" => $request->contract_id, "service_id" => $schedule->service_id])->get();
                        $service = Service::find($schedule->service_id);
                        if($service->type == 'sesion'){
                            $shedule_totaly_c = Schedule::where('service_id',$schedule->service_id)
                                ->where('contract_id',$request->contract_id)
                                ->whereIn('status', ['completada'])
                                ->count();
                            $count_validate = 0;
                            $if_validate_items = true;
                            foreach ($items as $i_foreach){
                                if($if_validate_items == true){
                                    $count_validate = $count_validate + $i_foreach->qty;
                                    if($shedule_totaly_c < $count_validate){
                                        $value_service = $i_foreach->total/$i_foreach->qty;
                                        $if_validate_items = false;
                                    }
                                }
                            }
                        }else{
                            $shedule_totaly_c = Schedule::where('service_id',$schedule->service_id)
                                ->where('contract_id',$request->contract_id)
                                ->whereIn('status', ['completada'])
                                ->count();
                            $count_validate = 0;
                            $if_validate_items = true;
                            foreach ($items as $i_foreach){
                                if($if_validate_items == true) {
                                    $count_validate = $count_validate + 1;
                                    if ($shedule_totaly_c < $count_validate) {
                                        $value_service = $i_foreach->total;
                                        $if_validate_items = false;
                                    }
                                }
                            }
                        }
                        $incomes = Income::join('contracts', 'contracts.id', '=', 'incomes.contract_id')
                            ->where('incomes.patient_id', $schedule->patient_id)
                            ->where('contracts.status', 'activo')
                            ->where('incomes.status','activo')
                            ->where('contracts.id',$request->contract_id)
                            ->select('incomes.*')
                            ->get();
                        $totalIncome = 0;
                        $totalConsumed = 0;
                        foreach ($incomes as $i) {
                            $totalIncome += $i->amount;
                        }
                        $consumeds = Consumed::join('contracts', 'contracts.id', '=', 'consumed.contract_id')
                            ->select('consumed.*')
                            ->where([
                                'contracts.patient_id' => $schedule->patient_id,
                                'contracts.id' => $request->contract_id
                            ])
                            ->get();
                        foreach ($consumeds as $c) {
                            $totalConsumed += $c->amount;
                        }
                        $balance = $totalIncome - $totalConsumed;
                        if($balance < $value_service){
                            return response(json_encode(intval($value_service)), 202)->header('Content-Type', 'text/json');
                        }
                        $schedule->update([
                            'contract_id' => $request->contract_id,
                        ]);
                    }
                }
                //END VALIDATION

                if ($schedule->contract_id != "") {

                    $consumed_validate = Consumed::where('schedule_id',$request->id)->get();
                    if($consumed_validate->count() >= 1){
                        return response(json_encode(intval(1)), 204)->header('Content-Type', 'text/json');
                    }
                    //consentimientos informados validacion
                    /*
                    $informed = InformedConsents::where('service_id',$schedule->service_id)
                        ->where('contract_id',$schedule->contract->id)
                        ->count();
                    if($informed == 0){
                        return response(json_encode(intval(1)), 205)->header('Content-Type', 'text/json');
                    }
                    */
                    //end consentimientos informados

                    $items = Item::where(["contract_id" => $schedule->contract_id, "service_id" => $schedule->service_id])->get();
                    $service = Service::find($schedule->service_id);
                    if($service->type == 'sesion'){
                        $shedule_totaly_c = Schedule::where('service_id',$schedule->service_id)
                            ->where('contract_id',$schedule->contract_id)
                            ->whereIn('status', ['completada'])
                            ->count();
                        $count_validate = 0;
                        $if_validate_items = true;
                        foreach ($items as $key_item => $i_foreach){
                            if($if_validate_items == true){
                                $count_validate = $count_validate + $i_foreach->qty;
                                if($shedule_totaly_c < $count_validate){
                                    $value_service = $i_foreach->total/$i_foreach->qty;
                                    $if_validate_items = false;
                                    $item = Item::find($i_foreach->id);
                                    if($key_item == 0){
                                        $count = $shedule_totaly_c + 1;
                                    }else{
                                        $count = $count_validate - $shedule_totaly_c;
                                        $count = str_replace('-','',$count - $i_foreach->qty);
                                        $count = intval($count) + 1;
                                    }
                                }
                            }
                        }
                        //$value_service = $item->total/$item->qty;
                    }else{
                        $shedule_totaly_c = Schedule::where('service_id',$schedule->service_id)
                            ->where('contract_id',$schedule->contract_id)
                            ->whereIn('status', ['completada'])
                            ->count();
                        $count_validate = 0;
                        $if_validate_items = true;
                        foreach ($items as $i_foreach){
                            if($if_validate_items == true) {
                                $count_validate = $count_validate + 1;
                                if ($shedule_totaly_c < $count_validate) {
                                    $value_service = $i_foreach->total;
                                    $if_validate_items = false;
                                    $item = Item::find($i_foreach->id);
                                    $count = $item->qty;
                                }
                            }
                        }
                        //$value_service = $item->total;
                    }
                    $incomes = Income::join('contracts', 'contracts.id', '=', 'incomes.contract_id')
                        ->where('incomes.patient_id', $schedule->patient_id)
                        ->where('contracts.status', 'activo')
                        ->where('incomes.status','activo')
                        ->where('contracts.id',$schedule->contract_id)
                        ->select('incomes.*')
                        ->get();
                    $totalIncome = 0;
                    $totalConsumed = 0;
                    foreach ($incomes as $i) {
                        $totalIncome += $i->amount;
                    }
                    $consumeds = Consumed::join('contracts', 'contracts.id', '=', 'consumed.contract_id')
                        ->select('consumed.*')
                        ->where([
                            'contracts.patient_id' => $schedule->patient_id,
                            'contracts.id' => $schedule->contract_id
                        ])
                        ->get();
                    foreach ($consumeds as $c) {
                        $totalConsumed += $c->amount;
                    }
                    $balance = $totalIncome - $totalConsumed;
                    if($balance < $value_service){
                        return response(json_encode(intval($value_service)), 202)->header('Content-Type', 'text/json');
                    }

                    $consumed = Consumed::create([
                        'schedule_id' => $schedule->id,
                        'contract_id' => $schedule->contract_id,
                        'amount' => $value_service,
                        'sessions' => $item->qty,
                        'session' => $count
                    ]);

                    //validacion de comision de doctores . . .
                    /*
                    $commisionDoctor = CommissionService::where('user_id',$schedule->profession->id)
                        ->where('service_id',$schedule->service_id)
                        ->get();
                    $percent_value_tarjet = PercentValues::find(1);
                    if(count($commisionDoctor) > 0){
                        $deducible_doc = 0;
                        $payCard_Doc = 'no';
                        $card_doc = 0;
                        $totally_doc = 0;
                        $commission_doc = 0;
                        if($service->type == 'sesion'){
                            $desc_doc = $item->discount_value/$item->qty;
                            $desc_doc = $item->price - $desc_doc;
                            $price_item_doc = $item->price;
                        }else{
                            $desc_doc = $item->total;
                            $price_item_doc = $item->price * $item->qty;
                        }

                        if($schedule->service->deducible > 0){
                            if($schedule->service->deducible > 100){
                                $deducible_calculate = 100;
                            }else{
                                $deducible_calculate = $schedule->service->deducible;
                            }
                            $deducible_doc = $desc_doc * $deducible_calculate / 100;
                        }

                        $deducible_items_doc = 0;
                        $items_doc = Item::where('contract_id',$schedule->contract_id)
                            ->where('service_id','!=',$schedule->service_id)
                            ->get();
                        foreach ($items_doc as $i){
                            if($i->service_id == 125){
                                $deducible_items_doc = $deducible_items_doc + $i->total;
                            }else{
                                if($i->total == 0){
                                    $deducible_items_doc = $deducible_items_doc + $i->discount_value;
                                }
                            }
                        }

                        //tarjeta o no . . .
                        $sum_comsumed_doc = 0;
                        $income_doc = Income::where('contract_id',$schedule->contract_id)
                            ->where('status','activo')
                            ->get();
                        $consumed_doc = Consumed::where('contract_id',$schedule->contract_id)
                            //->where('schedule_id','<>',$schedule->id)
                            ->get();
                        foreach ($consumed_doc as $c_doc){
                            $sum_comsumed_doc = $sum_comsumed_doc + $c_doc->amount;
                        }
                        $validate_income_doc = 0;
                        $sum_income_doc = 0;
                        $sum_income_doc_1 = 0;
                        $sum_income_doc_2 = 0;
                        foreach ($income_doc as $i_doc){
                            if($validate_income_doc == 0){
                                $sum_income_doc = $sum_income_doc + $i_doc->amount;
                                if($sum_income_doc >= $sum_comsumed_doc ){
                                    if($i_doc->method_of_pay_2 != ''){
                                        $sum_income_doc_1 = $sum_income_doc_1 + $i_doc->amount_one;
                                        //$sum_income_doc_2 = $sum_income_doc_2 + $i_doc->amount_two;
                                        if($sum_income_doc_1 >= $sum_comsumed_doc){
                                            if($i_doc->method_of_pay == 'tarjeta' || $i_doc->method_of_pay == 'online'){
                                                $payCard_Doc = 'si';
                                                $card_doc = $card_doc + ( ( $i_doc->amount_one * $percent_value_tarjet->value ) / 100);
                                            }
                                            $validate_income_doc = 1;
                                        }
                                        //return response(json_encode($sum_income_doc_1.'-'.$sum_comsumed_doc.'/'.$payCard_Doc.'-'.$validate_income_doc), 203)->header('Content-Type', 'text/json');
                                        if($validate_income_doc == 0){
                                            if($sum_income_doc >= $sum_comsumed_doc){
                                                if($i_doc->method_of_pay_2 == 'tarjeta' || $i_doc->method_of_pay_2 == 'online'){
                                                    $payCard_Doc = 'si';
                                                    $card_doc = $card_doc + ( ( $i_doc->amount_two * $percent_value_tarjet->value ) / 100);
                                                }
                                                $validate_income_doc = 1;
                                            }
                                        }
                                        $sum_income_doc_1 = ($sum_income_doc_1 - $i_doc->amount_one) + $i_doc->amount;
                                        //$sum_income_doc_2 = ($sum_income_doc_2 - $i_doc->amount_two) + $i_doc->amount;
                                    }else{
                                        if($i_doc->method_of_pay == 'tarjeta' || $i_doc->method_of_pay == 'online'){
                                            $payCard_Doc = 'si';
                                            $card_doc = $card_doc + ( ( $i_doc->amount * $percent_value_tarjet->value ) / 100);
                                        }
                                        $validate_income_doc = 1;
                                    }
                                }
                            }
                        }
                        //return response(json_encode($payCard_Doc.'-'.$validate_income_doc), 203)->header('Content-Type', 'text/json');
                        //end tarjeta
                        $deducible_doc = $deducible_doc + $deducible_items_doc;
                        if($deducible_doc < $desc_doc){
                            $totally_doc = $desc_doc - $deducible_doc;
                        }else{
                            $totally_doc = 0;
                        }

                        if($card_doc < $totally_doc){
                            $totally_doc = $totally_doc - $card_doc;
                        }else{
                            $totally_doc = 0;
                        }

                        $commisionDoctor = CommissionService::where('user_id',$schedule->profession->id)
                            ->where('service_id',$schedule->service_id)
                            ->first();
                        $commission_doc = $totally_doc * $commisionDoctor->commission_service / 100;
                        //if($commission_doc > 0) {
                            $payDoc = New PayDoctors();
                            $payDoc->user_id = Auth::id();
                            $payDoc->patient_id = $schedule->patient_id;
                            $payDoc->assistant_id = $schedule->personal_id;
                            $payDoc->service_id = $schedule->service_id;
                            $payDoc->schedule_id = $schedule->id;
                            $payDoc->patient = $schedule->patient->name . " " . $schedule->patient->lastname;
                            $payDoc->identification = $schedule->patient->identy;
                            $payDoc->assistant = $schedule->profession->name . " " . $schedule->profession->lastname;
                            $payDoc->service = $schedule->service->name;
                            $payDoc->session = $consumed->session . '/' . $consumed->sessions;
                            $payDoc->date = $schedule->date;
                            $payDoc->contract = 'C-' . $schedule->contract_id;
                            $payDoc->price = $price_item_doc;
                            $payDoc->discount = $desc_doc;
                            $payDoc->pay_card = $payCard_Doc;
                            $payDoc->card = $card_doc;
                            $payDoc->deducible = $deducible_doc;
                            $payDoc->totally = $totally_doc;
                            $payDoc->commission = $commission_doc;
                            $payDoc->save();
                        //}
                    }else{
                        */
                        //aqui agregar los pagos a asistenciales...
                        if($schedule->profession->id == $schedule->contract->seller->id){
                            $comision = 0;
                            $totalIva = ($item->total/$item->qty)/1.19;
                            $totalPago = ($totalIva * $schedule->service->percent) /100;
                        }else{
                            $comision = $schedule->service->price_pay;
                            $totalPago = $comision;
                        }

                        if($schedule->service_id == 2 || $schedule->service_id == 9 || $schedule->service_id == 70){
                            $comision = $service->price_pay;
                            $totalPago = $comision;
                        }

                        $saldoFAV = 0;
                        if($schedule->contract != ''){
                            $contract = 'C-'.$schedule->contract->id;
                            $consumed_all = Consumed::where('contract_id',$schedule->contract_id)->get();
                            foreach($consumed_all as $c){
                                $saldoFAV = $saldoFAV + $c->amount;
                            }
                            $saldoFAV = $balance - $saldoFAV;
                        }else{
                            $contract = '';
                            $saldoFAV = 0;
                        }

                        if($service->type == 'sesion'){
                            $desc = $item->discount_value/$item->qty;
                            $desc = $item->price - $desc;
                            $price_item = $item->price;
                        }else{
                            $desc = $item->total;
                            $price_item = $item->price * $item->qty;
                        }

                        //if($totalPago > 0){
                            $user = User::find(Auth::id());
                            $pay = New PaymentAssistance();
                            $pay->schedule_id = $schedule->id;
                            $pay->patient = $schedule->patient->name . " " . $schedule->patient->lastname;
                            $pay->identi = $schedule->patient->identy;
                            $pay->asyst = $schedule->profession->name." ".$schedule->profession->lastname;
                            $pay->serv = $schedule->service->name;
                            $pay->sesion = $consumed->session .'/'.$consumed->sessions;
                            $pay->date = $schedule->date;
                            $pay->contract = $contract;
                            $pay->price = $price_item;
                            $pay->desc = $desc;
                            $pay->comision = $comision;
                            $pay->seller = $schedule->contract->seller->name." ".$schedule->contract->seller->lastname;
                            $pay->stable_status = $user->name .' '.$user->lastname;
                            $pay->total = $totalPago;
                            $pay->balance_favor = $saldoFAV;
                            $pay->save();
                        //}
                    //}
                }
                $schedule->update(['status' => 'completada']);
                $h_schedule = ScheduleHistorial::create([
                    'patient_id'=>$schedule->patient_id,
                    'schedule_id'=>$schedule->id,
                    'date'=>$schedule->date,
                    'status'=>$request->status_schedule,
                    'professional'=>User::find($schedule->personal_id)->name .' '.User::find($schedule->personal_id)->lastname,
                    'contract'=>$schedule->contract_id,
                    'service'=>Service::find($schedule->service_id)->name,
                    'comment'=>$schedule->comment,
                    'start'=>$schedule->start_time,
                    'end'=>$schedule->end_time,
                    'comment_update'=>'',
                    'date_update'=>date("Y-m-d"),
                    'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
                ]);
            }
            Monitoring::create([
                'patient_id' => $request->patient_id,
                'responsable_id' => $request->responsable_id,
                'user_id' => Auth::id(),
                'issue_id' => $request->issue_id,
                'date' => $request->date,
                'comment' => $request->comment,
            ]);
            return response(json_encode(["message" => "schedule", "patient_id" => $request->patient_id]), 201)->header('Content-Type', 'text/json');
        
        
        } else {
            session(['menu_patient_show' => 5]);
            return response(json_encode(["message" => "error"]), 209)->header('Content-Type', 'text/json');
        }
        
        
        } else {
            Monitoring::create([
                'patient_id' => $request->patient_id,
                'responsable_id' => $request->responsable_id,
                'user_id' => Auth::id(),
                'issue_id' => $request->issue_id,
                'date' => $request->date,
                'comment' => $request->comment,
            ]);
            session(['menu_patient_show' => 5]);
            return response(json_encode(["message" => "Saved"]), 201)->header('Content-Type', 'text/json');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Monitoring::class);
        return view('monitorings.show', [
            'monitoring' => Monitoring::find($id),
            'users' => User::where("status", "activo")->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Monitoring $monitoring)
    {
        $this->authorize('update', Monitoring::class);

        return view('monitorings.edit', [

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patien)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patien)
    {

    }

    public function close(Request $request)
    {

        request()->validate([
            'id' => 'required|integer',
            'date_close' => 'required|date',
            'comment_close' => 'required|string|min:4',
        ]);

        $monitoring = Monitoring::find($request->id)->update([
            "date_close" => $request->date_close,
            "comment_close" => $request->comment_close,
            "status" => "cerrado",
            "close_id" => Auth::id()
        ]);

        return response(json_encode($monitoring), 201)->header('Content-Type', 'text/json');
    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end")
        ];
        return Excel::download(new MonitoringExports($data), 'seguimientos.xlsx');
    }
}
