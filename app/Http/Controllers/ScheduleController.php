<?php

namespace App\Http\Controllers;

use App\Mail\ScheduleAppoinment;
use App\Models\CommissionService;
use App\Models\Consumed;
use App\Models\ContactSource;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Income;
use App\Models\InformedConsents;
use App\Models\Issue;
use App\Models\Item;
use App\Models\Patient;
use App\Models\PayDoctors;
use App\Models\PaymentAssistance;
use App\Models\PercentValues;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\ScheduleHistorial;
use App\Models\Service;
use App\Models\ServiceUser;
use App\Models\State;
use App\Models\ReservationDate;
use App\User;
use App\Helpers\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ScheduleExport;
use PhpParser\Node\Expr\Array_;

class ScheduleController extends Controller
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

    public function index_old(Request $request)
    {
        $this->authorize('view', Schedule::class);

        $dateToday = date("Y-m-d");
        $sch = Schedule::where('date','<',$dateToday)
            ->where('status','programada')
            ->get();
        foreach($sch as $s){
            $update = Schedule::find($s->id);
            $update->status = 'vencida';
            $update->save();
        }

        $schedules = Schedule::orderBy('id','desc')->get();
        $reservation = ReservationDate::orderByDesc('date_start')->get();
        return view('schedules.index', [
            'id_find'=>$request->id,
            'issues' => Issue::where('status', 'activo')->orderBy('name')->get(),
            'users' => User::where('status', 'activo')->orderBy('name')->get(),
            'schedules' => $schedules,
            'reservation'=>$reservation
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('view', Schedule::class);

        $dateToday = date("Y-m-d");
        $sch = Schedule::where('date','<',$dateToday)
            ->where('status','programada')
            ->get();
        foreach($sch as $s){
            $update = Schedule::find($s->id);
            $update->status = 'vencida';
            $update->save();
        }

        $query = Schedule::orderBy('schedules.date','desc')
            ->orderBy('schedules.start_time','asc')
            ->join('patients', 'patients.id', '=', 'schedules.patient_id')
            /*->join('users', function ($join) {
                $join->on('users.id', '=', 'schedules.personal_id')
                    ->orOn('users.id','=','schedules.user_id');
            });*/
            ->join('users as us', 'us.id', '=', 'schedules.user_id')
            ->join('users', 'users.id', '=', 'schedules.personal_id');
        if($request->id != ''){
            $query->where('schedules.id','LIKE','%'.$request->id.'%');
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
        if($request->phone != ''){
            $query->where('patients.phone','LIKE','%'.$request->phone.'%');
        }
        if($request->contract != ''){
            $query->where('schedules.contract_id',str_replace('C-','',$request->contract));
        }
        if($request->professional != ''){
            $porciones = explode(" ", $request->professional);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(users.name," ",users.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->service != ''){
            $query->where('schedules.service_id',$request->service);
        }
        if($request->date != ''){
            $query->where('schedules.date','like','%'.$request->date.'%');
        }
        if($request->hour != ''){
            $porciones = explode(":", $request->hour);
            if(count($porciones) > 1){
                $hourplus = intval($porciones[0])+12;
                $query->where('schedules.start_time','like',''.$porciones[0].':'.$porciones[1].'%')
                    ->orwhere('schedules.start_time','like',''.$hourplus.':'.$porciones[1].'%');
            }else{
                $hourplus = intval($request->hour)+12;
                $query->where('schedules.start_time','like','%'.$request->hour.'%')
                    ->orwhere('schedules.start_time','like','%'.$hourplus.'%');
            }
        }
        if($request->hourend != ''){
            $porciones = explode(":", $request->hourend);
            if(count($porciones) > 1){
                $hourplus = intval($porciones[0])+12;
                $por_1 = $porciones[0].':'.$porciones[1];
                $por_2 = $hourplus.':'.$porciones[1];
                $query->where('schedules.end_time','like',''.$por_1.'%')
                    ->orwhere('schedules.end_time','like',''.$por_2.'%');
            }else{
                $hourplus = intval($request->hourend)+12;
                $query->where('schedules.end_time','like','%'.$request->hourend.'%')
                    ->orwhere('schedules.end_time','like','%'.$hourplus.'%');
            }
        }
        if($request->createdate != ''){
            $query->where('schedules.created_at','like','%'.$request->createdate.'%');
        }
        if($request->status != ''){
            if($request->status == 'programada' || $request->status == 'confirmada'){
                $query->whereIn('schedules.status',['programada','confirmada']);
            }else{
                $query->where('schedules.status',$request->status);
            }
        }
        if($request->update != ''){
            $porciones = explode(" ", $request->update);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(us.name," ",us.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->comment != ''){
            $query->where('schedules.confirm_comment','like','%'.$request->comment.'%');
        }
        if($request->observations != ''){
            $query->where('schedules.comment','like','%'.$request->observations.'%');
        }
        if($request->confirm != ''){
            $query->where('schedules.confirm',$request->confirm);
        }
        $schedules = $query->select('schedules.*')->paginate(10);
        //dd($schedules);
        /*
        $schedules = array();
        $i = 0;
        foreach ($query as $q){
            $schedules[$i]->id = $q->id;
            $schedules[$i]->patient_id = $q->patient_id;
            $schedules[$i]->personal_id = $q->personal_id;
            $schedules[$i]->user_id = $q->user_id;
            $schedules[$i]->service_id = $q->service_id;
            $schedules[$i]->contract_id = $q->contract_id;
            $schedules[$i]->date = $q->date;
            $schedules[$i]->start_time = $q->start_time;
            $schedules[$i]->end_time = $q->end_time;
            $schedules[$i]->comment = $q->comment;
            $schedules[$i]->confirm_comment = $q->confirm_comment;
            $schedules[$i]->status = $q->status;
            $schedules[$i]->created_at = $q->created_at;
            $schedules[$i]->updated_at = $q->updated_at;
            $i++;
        }
        */

        $query_2 = ReservationDate::orderBy('reservation_date.date_start','desc');
        /*
        if($request->date != ''){
            $query_2->where('reservation_date.date_start','like','%'.$request->date.'%');
            $query_2->where(function ($query) use ($request->date) {
                $query->whereBetween('date_start', [$request->date, $end_time_s])
                    ->orWhereBetween('end_time', [$request->date, $end_time_s])
                    ->orWhere('date_start', $start_time);
            });
        }
        */
        $reservation = $query_2->select('reservation_date.*')
            //->paginate(10)
            ->get();
        /*
        $reservation = ReservationDate::orderByDesc('date_start')->get();
        */
        $services = Service::where('status','activo')
            ->orderBy('name','asc')
            ->get();
            $user = Auth::user();
        return view('schedules.index_2', [
            'id_find'=>$request->id,
            'issues' => Issue::where('status', 'activo')->orderBy('name')->get(),
            'users' => User::where('status', 'activo')->orderBy('name')->get(),
            'schedules' => $schedules,
            'reservation'=>$reservation,
            'request'=>$request,
            'services'=>$services,
            'user'=>$user
        ]);
    }


    public function today()
    {
        $this->authorize('view', Schedule::class);
        $schedules = Schedule::where(['personal_id' => Auth::id(), 'date' => date("Y-m-d")])
            ->whereIn('status',
                ['completada','en sala', 'confirmada', 'programada', 'atendida']
            )->orderByDesc('created_at')->get();
        return view('schedules.today', [
            'schedules' => $schedules,
            'issues' => Issue::where('status', 'activo')->orderBy('name')->get(),
            'users' => User::where('status', 'activo')->orderBy('name')->get(),
        ]);
    }

    public function status(Request $request)
    {
        $this->authorize('update', Schedule::class);
        request()->validate([
            'id' => 'required|integer',
            'status' => [
                'required',
                Rule::in(['confirmada', 'en sala', 'fallida', 'cancelada', 'completada', 'reprogramada', 'atendida']),
            ]
        ]);

        $schedule = Schedule::find($request->id);

        $schedule_old = Schedule::find($request->id);
        if ($request->status == "confirmada") {
            $schedule->update([
                'status' => 'programada',
                'confirm_comment' => $request->comment,
                'confirm' => 'si',
            ]);
        } else if ($request->status == "completada") {
            $dateTodayValidate = date("Y-m-d");
            if(strtotime($dateTodayValidate) < strtotime($schedule->date)){
                return response(json_encode('fecha_validate'), 205)->header('Content-Type', 'text/json');
            }else{
                //return response(strtotime($schedule->date).'<'.strtotime($dateToday),
                //500)->header('Content-Type', 'text/json');
            }

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

                $items = Item::where(["contract_id" => $schedule->contract->id, "service_id" => $schedule->service_id])->get();
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
                    return response(json_encode(intval($balance)), 202)->header('Content-Type', 'text/json');
                }

                $consumed = Consumed::create([
                    'schedule_id' => $schedule->id,
                    'contract_id' => $schedule->contract_id,
                    'amount' => $value_service,
                    'sessions' => $item->qty,
                    'session' => $count
                ]);
                /*
                //validacion de comision de doctores . . .
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
                        //descontar por deducible servicio igual a obsequio o gastos de anestesiologia.
                        if($i->service_id == 125){
                            //if($service->type == 'sesion'){
                                //$desc_doc_i = $i->price - ($i->discount_value/$i->qty);
                                //$deducible_items_doc = $deducible_items_doc + $desc_doc_i;
                            //}else{
                                //$deducible_items_doc = $deducible_items_doc + $i->total;
                            //}
                            $deducible_items_doc = $deducible_items_doc + $i->total;
                        }else{
                            if($i->total == 0){
                                //if($service->type == 'sesion'){
                                    //$deducible_items_doc = $deducible_items_doc + ($i->price);
                                //}else{
                                    //$deducible_items_doc = $deducible_items_doc + $i->discount_value;
                                //}
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
                                        if($sum_income_doc_1 >= $sum_comsumed_doc) {
                                            if ($i_doc->method_of_pay == 'tarjeta' || $i_doc->method_of_pay == 'online') {
                                                $payCard_Doc = 'si';
                                                $card_doc = $card_doc + (($i_doc->amount_one * $percent_value_tarjet->value) / 100);
                                            }
                                            $validate_income_doc = 1;
                                        }
                                        if($validate_income_doc == 0){
                                            if($sum_income_doc >= $sum_comsumed_doc) {
                                                if ($i_doc->method_of_pay_2 == 'tarjeta' || $i_doc->method_of_pay_2 == 'online') {
                                                    $payCard_Doc = 'si';
                                                    $card_doc = $card_doc + (($i_doc->amount_two * $percent_value_tarjet->value) / 100);
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
                    //return response(json_encode($commission_doc), 202)->header('Content-Type', 'text/json');
                    if($commission_doc > 0) {
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
                    }
                }else{*/
                    //return response(json_encode('Entro en pago a asistenciales'), 202)->header('Content-Type', 'text/json');
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
                    //if($totalPago > 0) {
                        $user = User::find(Auth::id());
                        $pay = New PaymentAssistance();
                        $pay->schedule_id = $schedule->id;
                        $pay->patient = $schedule->patient->name . " " . $schedule->patient->lastname;
                        $pay->identi = $schedule->patient->identy;
                        $pay->asyst = $schedule->profession->name . " " . $schedule->profession->lastname;
                        $pay->serv = $schedule->service->name;
                        $pay->sesion = $consumed->session . '/' . $consumed->sessions;
                        $pay->date = $schedule->date;
                        $pay->contract = $contract;
                        $pay->price = $price_item;
                        $pay->desc = $desc;
                        $pay->comision = $comision;
                        $pay->seller = $schedule->contract->seller->name . " " . $schedule->contract->seller->lastname;
                        $pay->stable_status = $user->name . ' ' . $user->lastname;
                        $pay->total = $totalPago;
                        $pay->balance_favor = $saldoFAV;
                        $pay->save();
                    //}
                //}
                //return response(json_encode('Finalizo'), 202)->header('Content-Type', 'text/json');

            }
            $schedule->update(['status' => $request->status]);
        } else if($request->status == "cancelada"){
            $schedule->update([
                'status' => $request->status,
                'comment'=> $schedule->comment .' Motivo de cancelacion: '.$request->comment
            ]);
            return response(json_encode($schedule->patient_id), 203)->header('Content-Type', 'text/json');
        }else{
            $schedule->update(['status' => $request->status]);
        }

        $scheduleUpdate = Schedule::find($request->id);
        //$scheduleUpdate->user_id = Auth::id();
        //$scheduleUpdate->save();

        $h_schedule = ScheduleHistorial::create([
            'patient_id'=>$scheduleUpdate->patient_id,
            'schedule_id'=>$scheduleUpdate->id,
            'date'=>$scheduleUpdate->date,
            'status'=>$scheduleUpdate->status,
            'professional'=>User::find($scheduleUpdate->personal_id)->name .' '.User::find($scheduleUpdate->personal_id)->lastname,
            'contract'=>$scheduleUpdate->contract_id,
            'service'=>Service::find($scheduleUpdate->service_id)->name,
            'comment'=>$schedule_old->comment,
            'start'=>$scheduleUpdate->start_time,
            'end'=>$scheduleUpdate->end_time,
            'comment_update'=>$scheduleUpdate->comment,
            'date_update'=>date("Y-m-d"),
            'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
        ]);
        return response(json_encode($schedule), 201)->header('Content-Type', 'text/json');
    }

    public function room(Request $request)
    {
        $this->authorize('update', Schedule::class);
        request()->validate([
            'id' => 'required|integer',
            'status' => [
                'required',
                Rule::in(['activo', 'inactivo']),
            ]
        ]);

        $schedule = Schedule::where(['patient_id' => $request->id, 'date' => date("Y-m-d")])->first();
        if ($schedule) {
            if ($request->status == "activo") {
                $status = "en sala";
            } else {
                $status = "confirmada";
            }
            $schedule->update(['status' => $status]);
            return response(json_encode(["message" => "La acción se realizó con éxito"]), 200)->header('Content-Type', 'text/json');
        } else {
            return response(json_encode(["message" => "El paciente no tiene cita programada el día de hoy"]), 400)->header('Content-Type', 'text/json');
        }


    }

    public function search(Request $request)
    {
        $this->authorize('view', Schedule::class);
        date_default_timezone_set('America/Bogota');
        $schedules = Schedule::with(['patient', 'profession', 'service'])->where('date', '=', $request->date)->whereIn('status', ['programada', 'confirmada'])->get();
        $text = DB::table('text')->find(1)->text;
        $data = [];
        foreach ($schedules as $s) {
            $title = str_replace('[titulo]', $s->profession->title, $text);
            $title = str_replace('[nombreProfesional]', $s->profession->name, $title);
            $title = str_replace('[apellidoProfesional]', $s->profession->lastname, $title);
            $title = str_replace('[nombrePaciente]', $s->patient->name, $title);
            $title = str_replace('[apellidoPaciente]', $s->patient->lastname, $title);
            $title = str_replace('[servicio]', $s->service->name, $title);
            $title = str_replace('[observaciones]', $s->comment, $title);
            $data[] = [
                'id' => $s->id,
                'professional' => $s->personal_id,
                'color' => $s->profession->color,
                'title' => $title,
                'start' => $s->date . " " . $s->start_time,
                'end' => $s->date . " " . $s->end_time,
                'comment' => $s->comment,
                'date' => date("d/m/Y", strtotime($s->date))
            ];
        }
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function profession(Request $request)
    {
        $this->authorize('view', Schedule::class);
        date_default_timezone_set('America/Bogota');
        request()->validate([
            //'id' => 'required|integer',
        ]);
        $date = $request->date;
        if($request->id == ''){
            $schedules = Schedule::with(['patient', 'profession', 'service'])->where('date', '=',
                $date)->whereIn('status', ['programada', 'confirmada'])->get();
        }else{
            $schedules = Schedule::with(['patient', 'profession', 'service'])->where('date', '=',
                $date)->where('personal_id', $request->id)
                ->whereIn('status', ['programada', 'confirmada'])->get();
        }
        $text = DB::table('text')->find(1)->text;
        $data = [];
        foreach ($schedules as $s) {
            $title = str_replace('[titulo]', $s->profession->title, $text);
            $title = str_replace('[nombreProfesional]', $s->profession->name, $title);
            $title = str_replace('[apellidoProfesional]', $s->profession->lastname, $title);
            $title = str_replace('[nombrePaciente]', $s->patient->name, $title);
            $title = str_replace('[apellidoPaciente]', $s->patient->lastname, $title);
            $title = str_replace('[servicio]', $s->service->name, $title);
            $title = str_replace('[observaciones]', $s->comment, $title);
            $data[] = [
                'id' => $s->id,
                'professional' => $s->personal_id,
                'color' => $s->profession->color,
                'title' => $title,
                'start' => $s->date . " " . $s->start_time,
                'end' => $s->date . " " . $s->end_time,
                'comment' => $s->comment,
                'date' => date("d/m/Y", strtotime($s->date))
            ];
        }
        $reservationDate = ReservationDate::where('responsable_id',$request->id)
            ->where('date_start',date("Y-m-d"))
            ->get();
        foreach($reservationDate as $r){
            $title = 'El profesional '.$r->responsable->name.' '. $r->responsable->lastname .' Tiene un bloqueo de cita - Motivo: '.$r->motiv. ' - Observaciones:'.$r->observation;
            if($r->option == 'horas'){
                $date_start = $r->date_start;
                $date_end = $r->date_start;
                $hour_start = $r->hour_start;
                $hour_end = $r->hour_end;
            }else{
                $date_start = $r->date_start;
                if($r->date_end == ''){
                    $date_end = $r->date_start;
                }else{
                    $date_end = $r->date_end;
                }
                $hour_start = '06:00:00';
                $hour_end = '18:00:00';
            }
            $data[] = [
                'id' => 0,
                'professional' => 2,
                'color' => '#ff0000',
                'title' => $title,
                'start' => $date_start. " " . $hour_start,
                'end' => $date_end . " " . $hour_end,
                'comment' => $r->observation,
                'date' => date("d/m/Y")
            ];
        }
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function services(Request $request)
    {
        $this->authorize('view', Schedule::class);
        date_default_timezone_set('America/Bogota');
        request()->validate([
            'id' => 'required|integer',
        ]);
        $date = $request->date;
        $personals = Service::find($request->id);
        $in = [];
        foreach ($personals->users as $user) {
            array_push($in, $user->id);
        }
        if (count($in) > 0) {
            $schedules = Schedule::with(['patient', 'profession', 'service'])->where('date', '=',
                $date)->whereIn('personal_id', $in)
                ->where(function ($sql) {
                    $sql->where('status', 'programada')->orWhere('status', 'confirmada');
                })->get();
        } else {
            $schedules = Schedule::with(['patient', 'profession', 'service'])->where('date', '=',
                $date)->whereIn('status', ['programada', 'confirmada'])->get();
        }

        $text = DB::table('text')->find(1)->text;
        $data = [];
        foreach ($schedules as $s) {
            $title = str_replace('[titulo]', $s->profession->title, $text);
            $title = str_replace('[nombreProfesional]', $s->profession->name, $title);
            $title = str_replace('[apellidoProfesional]', $s->profession->lastname, $title);
            $title = str_replace('[nombrePaciente]', $s->patient->name, $title);
            $title = str_replace('[apellidoPaciente]', $s->patient->lastname, $title);
            $title = str_replace('[servicio]', $s->service->name, $title);
            $title = str_replace('[observaciones]', $s->comment, $title);
            $data[] = [
                'id' => $s->id,
                'professional' => $s->personal_id,
                'color' => $s->profession->color,
                'title' => $title,
                'start' => $s->date . " " . $s->start_time,
                'end' => $s->date . " " . $s->end_time,
                'comment' => $s->comment,
                'date' => date("d/m/Y", strtotime($s->date))
            ];
        }
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function roles(Request $request){
        $this->authorize('view', Schedule::class);
        date_default_timezone_set('America/Bogota');
        request()->validate([
            //'id' => 'required|integer',
        ]);
        if($request->id == ''){
            $schedules = Schedule::with(['patient', 'profession', 'service'])->where('date', '>=',
                date("Y-m-d"))->whereIn('status', ['programada', 'confirmada'])->get();
        }else{
            $schedules = Schedule::with(['patient', 'profession', 'service'])
                ->join('users','schedules.personal_id','=','users.id')
                ->where('schedules.date', '>=', date("Y-m-d"))
                ->where('users.role_id', $request->id)
                ->whereIn('schedules.status', ['programada', 'confirmada'])
                ->select('schedules.*')
                ->get();
        }
        $text = DB::table('text')->find(1)->text;
        $data = [];
        foreach ($schedules as $s) {
            $title = str_replace('[titulo]', $s->profession->title, $text);
            $title = str_replace('[nombreProfesional]', $s->profession->name, $title);
            $title = str_replace('[apellidoProfesional]', $s->profession->lastname, $title);
            $title = str_replace('[nombrePaciente]', $s->patient->name, $title);
            $title = str_replace('[apellidoPaciente]', $s->patient->lastname, $title);
            $title = str_replace('[servicio]', $s->service->name, $title);
            $title = str_replace('[observaciones]', $s->comment, $title);
            $data[] = [
                'id' => $s->id,
                'professional' => $s->personal_id,
                'color' => $s->profession->color,
                'title' => $title,
                'start' => $s->date . " " . $s->start_time,
                'end' => $s->date . " " . $s->end_time,
                'comment' => $s->comment,
                'date' => date("d/m/Y", strtotime($s->date))
            ];
        }
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBlade(){
        $professionals = User::where(['status' => 'activo', 'schedule' => 'si'])->orderBy('name')->orderBy('lastname')->get();
        $roles = Role::where(['status' => 'activo'])->orderBy('name')->get();
        return view('schedules.view', [
            'professionals' => $professionals,
            'roles'=>$roles,
        ]);
    }

    public function create($id = false)
    {
        $this->authorize('view', Schedule::class);
        $contracts = Contract::where(['status' => 'activo', 'patient_id' => $id])->get();
        if($id == false){
            $services = Service::where(['status' => 'activo'])->orderBy('name')->get();
        }else{
            /*
            $services1 = Service::join('items','services.id','=','items.service_id')
                ->join('contracts','items.contract_id','=','contracts.id')
                ->where('contracts.patient_id',$id)
                ->where(['services.status' => 'activo'])
                ->where('contracts.status','!=','anulado')
                ->where('contracts.status','!=','liquidado')
                ->where(['services.contract' => 'SI'])
                ->orderBy('services.name')
                ->select('services.*')
                ->groupBy('services.id')
                ->get();
            $services_2 = Service::where('status','activo')
                ->where('contract','no')
                ->get();
            $services = $services1->merge($services_2);
            */
            $services = Service::where(['status' => 'activo'])->orderBy('name')->get();
        }
        $professionals = User::where(['status' => 'activo', 'schedule' => 'si'])->orderBy('name')->orderBy('lastname')->get();
        if ($id) {
            $patient = Patient::find($id);
            session(['patient_schedule' => $patient]);
        } else {
            $patient = false;
        }
        //$patients = Patient::orderBy('identy','asc')
            //->get();
        return view('schedules.create', [
            'contracts' => $contracts,
            'services' => $services,
            'professionals' => $professionals,
            'patient' => $patient,
            //'patients'=>$patients
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
        $this->authorize('create', Schedule::class);

        request()->validate([
            'patient_id' => 'required|integer',
            'personal_id' => 'required|integer',
            'service_id' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'comment' => 'required|string|min:1'
        ]);
        if($request->contract_id != '')
        {
            $service= Service::find($request->service_id);
            $validate_agenda_service = true;
            $shedule_validate_agend = Schedule::where('service_id',$request->service_id)
                ->where('contract_id',$request->contract_id)
                ->whereIn('status', ['programada', 'confirmada','completada','vencida'])
                ->count();
            $item_validate = Item::where(["contract_id" => $request->contract_id, "service_id" => $request->service_id])->get();
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
        //validar service
            /*
            $service= Service::find($request->service_id);
            if($service->contract  == 'SI'){
                if($request->contract_id == ''){
                    return response(json_encode(["message" => "Para el servicio ".$service->name.' debe seleccionarse un contrato']), 400)
                        ->header('Content-Type', 'text/json');
                }
            }
            */
            /*
        return response(json_encode(["message" => "PAUSAR".$item_validate_qty]), 400)
            ->header('Content-Type', 'text/json');
            */
        //end
        $start_time_s = date("H:i", strtotime('+1 minute', strtotime($request->start_time)));
        $end_time_s = date("H:i", strtotime('-1 minute', strtotime($request->end_time)));
        $start_time = date("H:i", strtotime($request->start_time));
        $end_time = date("H:i", strtotime($request->end_time));

        $hour_start_rd =  strtotime($request->start_time);
        $hour_end_rd = strtotime($request->end_time);

        if($hour_end_rd  <= $hour_start_rd){
            return response(json_encode(["message" => "La hora final debe ser mayor"]), 400)
            ->header('Content-Type', 'text/json');
        }
        $date= $request->date;
        $reservationDateD = ReservationDate::where('id','>',0)
            //where('date_start','>=',$date)
            //->where('date_end','<=',$date)
            ->where('responsable_id', $request->personal_id)
            ->where('option','dias')
            ->get();
        $countreservationDateD = 0;
        foreach ($reservationDateD as $r){
            if(intval(strtotime($r->date_start)) <= intval(strtotime($date)) &&  intval(strtotime($r->date_end)) >= intval(strtotime($date))){
                $countreservationDateD = 1;
            }
        }
        if($countreservationDateD > 0){
            return response(json_encode(["message" => "El profesional se encuentra ocupado todo el dia"]), 400)
            ->header('Content-Type', 'text/json');
        }

        $reservationDateH = ReservationDate::where('responsable_id', $request->personal_id)
            ->where('option','horas')
            ->where('date_start',date("Y-m-d" ,strtotime($request->date)))
            ->get();
        $validate_hour = 0;
        foreach ($reservationDateH as $r){
            if( intval(strtotime($start_time) >= intval(strtotime($r->hour_start)))
                && intval(strtotime($start_time)) <= intval(strtotime($r->hour_end)) ){
                $validate_hour++;
            }else if( intval(strtotime($r->hour_start) >= intval(strtotime($start_time)))
                && intval(strtotime($r->hour_start)) <= intval(strtotime($end_time)) ){
                $validate_hour++;
            }
            if( intval(strtotime($end_time) >= intval(strtotime($r->hour_start)))
                && intval(strtotime($end_time)) <= intval(strtotime($r->hour_end)) ){
                $validate_hour++;
            }

        }

        if($validate_hour > 0){
            return response(json_encode(["message" => "El profesional se encuentra ocupado entre las horas " .
            $request->start_time . " y " . $request->end_time]), 400)
            ->header('Content-Type', 'text/json');
        }

        $start_time_s = date("H:i", strtotime('+1 minute', strtotime($request->start_time)));
        $end_time_s = date("H:i", strtotime('-1 minute', strtotime($request->end_time)));
        $start_time = date("H:i", strtotime($request->start_time));
        $end_time = date("H:i", strtotime($request->end_time));

        $service_validate = Service::find($request->service_id);
        if($service_validate->electronic_equipment_id != ''){
            if($service_validate->equip->equips_active != -1){
                if($service_validate->equip->equips_active == 0){
                    return response(json_encode(["message" => "No hay equipos disponibles para el servicio: ".
                        $service_validate->name]), 400)
                        ->header('Content-Type', 'text/json');
                }else{
                    $countSchedules = Schedule::where(function ($query) use ($start_time, $end_time, $start_time_s, $end_time_s) {
                        $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                            ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                            ->orWhere('start_time', $start_time);
                    })->where('service_id', $request->service_id)
                        ->where('date', date("Y-m-d" ,strtotime($request->date)))
                        ->whereIn('status', ['programada', 'confirmada'])
                        ->count();
                    if($countSchedules >= $service_validate->equip->equips_active){
                        return response(json_encode(["message" => "El equipo del servicio ". $service_validate->name .
                            " se encuentra ya agendado completamente entre ".
                            $request->start_time . " y " . $request->end_time]), 400)
                            ->header('Content-Type', 'text/json');
                    }
                }
            }
        }

        /*
         * Validacion que se quito antes
         */


        $countSchedules = Schedule::/*where(function ($query) use ($start_time, $end_time, $start_time_s, $end_time_s) {
            $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                ->orWhere('start_time', $start_time);
        })*/where('personal_id', $request->personal_id)
            ->where('date', date("Y-m-d" ,strtotime($request->date)))
            ->whereIn('status', ['programada', 'confirmada'])
            ->get();
        $validate_profesional = 0;
        foreach ($countSchedules as $c){
            if( intval(strtotime($start_time_s) >= intval(strtotime($c->start_time)))
                && intval(strtotime($start_time_s)) <= intval(strtotime($c->end_time)) ){
                $validate_profesional++;
            }else if( intval(strtotime($c->start_time) >= intval(strtotime($start_time_s)))
                && intval(strtotime($c->start_time)) <= intval(strtotime($end_time_s)) ){
                $validate_profesional++;
            }
            if( intval(strtotime($end_time_s) >= intval(strtotime($c->start_time)))
                && intval(strtotime($end_time_s)) <= intval(strtotime($c->end_time)) ){
                $validate_profesional++;
            }
        }
        if ($validate_profesional > 0) {
            return response(json_encode(["message" => "El profesional se encuentra ocupado entre las horas " .
                $request->start_time . " y " . $request->end_time]), 400)
                ->header('Content-Type', 'text/json');
        }
        /*
        return response(json_encode(["message" => "Siguio como si nada jjjj"]), 400)
            ->header('Content-Type', 'text/json');
        */

        //return false;
        /**/

        $countPatient = Schedule::/*where(function ($query) use ($start_time, $end_time, $start_time_s, $end_time_s) {
            $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                ->orWhere('start_time', $start_time);
        })->*/where('patient_id', $request->patient_id)
            ->where('date', date("Y-m-d" ,strtotime($request->date)))
            ->whereIn('status', ['programada', 'confirmada'])
            ->get();

        $validate_patient = 0;
        foreach ($countPatient as $c){
            if( intval(strtotime($start_time_s) >= intval(strtotime($c->start_time)))
                && intval(strtotime($start_time_s)) <= intval(strtotime($c->end_time)) ){
                $validate_patient++;
            }else if( intval(strtotime($c->start_time) >= intval(strtotime($start_time_s)))
                && intval(strtotime($c->start_time)) <= intval(strtotime($end_time_s)) ){
                $validate_patient++;
            }
            if( intval(strtotime($end_time_s) >= intval(strtotime($c->start_time)))
                && intval(strtotime($end_time_s)) <= intval(strtotime($c->end_time)) ){
                $validate_patient++;
            }
        }
        if ($validate_patient > 0) {
            return response(json_encode(["message" => "El paciente se encuentra en agenda entre las horas " .
                $request->start_time . " y " . $request->end_time]), 400)
                ->header('Content-Type', 'text/json');
        }
        /*
        return response(json_encode(["message" => "upssss, paso"]), 400)
            ->header('Content-Type', 'text/json');*/
        $schedule = Schedule::create([
            'patient_id' => $request->patient_id,
            'personal_id' => $request->personal_id,
            'service_id' => $request->service_id,
            'contract_id' => $request->contract_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'comment' => $request->comment
        ]);


        $h_schedule = ScheduleHistorial::create([
            'patient_id'=>$request->patient_id,
            'schedule_id'=>$schedule->id,
            'date'=>$schedule->date,
            'status'=>'programada',
            'professional'=>User::find($schedule->personal_id)->name .' '.User::find($schedule->personal_id)->lastname,
            'contract'=>$schedule->contract_id,
            'service'=>Service::find($schedule->service_id)->name,
            'comment'=>$schedule->comment,
            'start'=>$start_time,
            'end'=>$end_time,
            'comment_update'=>'',
            'date_update'=>date("Y-m-d"),
            'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
        ]);

        $schedule = Schedule::with(['patient', 'service', 'profession'])->find($schedule->id);

        $sw = false;
        if($request->send == 'SI'){
            $sw = true;
        }
        if ($sw) {
            try {
                $text = 'Smadia Clinic
Su cita con el profesional ' . ucwords(mb_strtolower($schedule->profession->name)) . ' ' . ucwords(mb_strtolower($schedule->profession->lastname)) . ' para el servicio ' . $schedule->service->name . ' ha sido agendada para el día ' . $schedule->date . ' a las ' . $request->start_time . ' en la Sede Barranquilla calle 87 #47-47
En caso de no poder asistir llámanos al 3009122813.';
                SendSms::send('57' . $schedule->patient->cellphone, $text);
            } catch (\Exception $e) {
            }
            try {
                Mail::to($schedule->patient->email)->send(new ScheduleAppoinment($schedule));
            } catch (\Exception $e) {
            }
        };
        session(['menu_patient_show' => 1]);
        return response(json_encode($schedule), 201)->header('Content-Type', 'text/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Schedule::class);
//        return view('patiens.show', [
//            'patients' => Patient::find($id)
//        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patien)
    {
        $this->authorize('update', Schedule::class);

        return view('patiens.edit', [
            'patien' => $patien,
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'eps' => Filter::where(['status' => 'activo', 'type' => 'eps'])->orderBy('name')->get(),
            'contact_sources' => ContactSource::where(['status' => 'activo'])->orderBy('name')->get(),
            'cities' => State::find($patien->state_id)->cities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', Schedule::class);

        request()->validate([
            'id' => 'required|integer',
            'professional_id' => 'required|integer',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'comment' => 'required|string'
        ]);
        $start_time_s = date("H:i", strtotime('+1 minute', strtotime($request->start_time)));
        $end_time_s = date("H:i", strtotime('-1 minute', strtotime($request->end_time)));
        $start_time = date("H:i", strtotime($request->start_time));
        $end_time = date("H:i", strtotime($request->end_time));
        $date = str_replace('/', '-', $request->date);
        $date = date('Y-m-d', strtotime($date));

        $old_schedule = Schedule::find($request->id);
        $sw = false;

        $service_validate = Service::find($request->service_id);
        if($service_validate->electronic_equipment_id != ''){
            if($service_validate->equip->equips_active != -1){
                if($service_validate->equip->equips_active == 0){
                    return response(json_encode(["message" => "No hay equipos disponibles para el servicio: ".
                        $service_validate->name]), 400)
                        ->header('Content-Type', 'text/json');
                }else{
                    $countSchedules = Schedule::where(function ($query) use ($start_time, $end_time, $start_time_s, $end_time_s) {
                        $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                            ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                            ->orWhere('start_time', $start_time);
                    })->where('service_id', $request->service_id)
                        ->where('date', date("Y-m-d" ,strtotime($request->date)))
                        ->whereIn('status', ['programada', 'confirmada'])
                        ->count();
                    if($countSchedules >= $service_validate->equip->equips_active){
                        return response(json_encode(["message" => "El equipo del servicio ". $service_validate->name .
                            " se encuentra ya agendado completamente entre ".
                            $request->start_time . " y " . $request->end_time]), 400)
                            ->header('Content-Type', 'text/json');
                    }
                }
            }
        }


        if($request->contract_id_schedule != '')
        {
            $service= Service::find($request->service_id);
            $shedule_validate_agend = Schedule::where('service_id',$request->service_id)
                ->where('contract_id',$request->contract_id_schedule)
                ->where('id','!=',$request->id)
                ->whereIn('status', ['programada', 'confirmada','completada','vencida'])
                ->count();
            $item_validate = Item::where(["contract_id" => $request->contract_id_schedule, "service_id" => $request->service_id])->get();
            $item_validate_qty = 0;
            $validate_agenda_service = true;
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
                    " para el contrato C-".$request->contract_id_schedule]), 200)
                    ->header('Content-Type', 'text/json');
            }
        }

        //validar service
        /*
        $service= Service::find($request->service_id);
        if($service->contract  == 'SI'){
            if($request->contract_id_schedule == ''){
                return response(json_encode(["message" => "Para el servicio ".$service->name.' debe seleccionarse un contrato']), 200)
                    ->header('Content-Type', 'text/json');
            }
        }
        */

        if($request->send == 'SI'){
            $sw = true;
        }
        if (strtotime($old_schedule->date) != strtotime($date)
            || strtotime($old_schedule->start_time) != strtotime($request->start_time)
            || strtotime($old_schedule->end_time) != strtotime($request->end_time)
            || $old_schedule->personal_id != $request->professional_id
        ) {
            $hour_start_rd =  strtotime($request->start_time);
            $hour_end_rd = strtotime($request->end_time);
            if($hour_end_rd  <= $hour_start_rd){
                return response(json_encode(["message" => "La hora final debe ser mayor"]), 200)
                    ->header('Content-Type', 'text/json');
            }
            $date= $request->date;
            $reservationDateD = ReservationDate::where('id','>',0)
                //where(function ($query) use ($date) {
                //$query->whereDate('date_start','>=',date("Y-m-d" ,strtotime($date)) .' 00:00:00');
                    //->orWhere('date_end','<=',date("Y-m-d" ,strtotime($date)));
                //})
                //where('date_start','>=',date("Y-m-d" ,strtotime($date)))
                //->whereDate('date_end','<=',date("Y-m-d" ,strtotime($date)))
                ->where('responsable_id', $request->professional_id)
                ->where('option','dias')
                ->get();
            $countreservationDateD = 0;
            foreach ($reservationDateD as $r){
                /*
                if(intval(strtotime($r->date_start)) >= intval(strtotime($date)) &&  intval(strtotime($r->date_end)) <= intval(strtotime($date))){
                    $countreservationDateD = 1;
                }
                */
                if(intval(strtotime($r->date_start)) <= intval(strtotime($date)) &&  intval(strtotime($r->date_end)) >= intval(strtotime($date))){
                    $countreservationDateD = 1;
                }
            }
            if($countreservationDateD > 0){
                return response(json_encode(["message" => "El profesional se encuentra ocupado todo el dia"]), 200)
                    ->header('Content-Type', 'text/json');
            }
            /*
            return response(json_encode(["message" => "Paso:".' '.strtotime($r->date_start).'>='.strtotime($date) ]), 200)
                ->header('Content-Type', 'text/json');*/

            $reservationDateH = ReservationDate::where('responsable_id', $request->professional_id)
                ->where('option','horas')
                ->where('date_start',date("Y-m-d" ,strtotime($request->date)))
                ->get();
            $validate_hour = 0;
            foreach ($reservationDateH as $r){
                if( intval(strtotime($start_time) >= intval(strtotime($r->hour_start)))
                    && intval(strtotime($start_time)) <= intval(strtotime($r->hour_end)) ){
                    $validate_hour++;
                }else if( intval(strtotime($r->hour_start) >= intval(strtotime($start_time)))
                    && intval(strtotime($r->hour_start)) <= intval(strtotime($end_time)) ){
                    $validate_hour++;
                }
                if( intval(strtotime($end_time) >= intval(strtotime($r->hour_start)))
                    && intval(strtotime($end_time)) <= intval(strtotime($r->hour_end)) ){
                    $validate_hour++;
                }

            }
            if($validate_hour > 0){
                return response(json_encode(["message" => "El profesional se encuentra ocupado entre las horas " .
                    $request->start_time . " y " . $request->end_time]), 200)
                    ->header('Content-Type', 'text/json');
            }


            //validacion nueva de horarios
            $countSchedules = Schedule::/*where(function ($query) use ($start_time, $end_time, $start_time_s, $end_time_s) {
                $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                    ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                    ->orWhere('start_time', $start_time);
            })->*/where('personal_id', $request->professional_id)
                ->where('id','!=', $old_schedule->id)
                ->where('date', date("Y-m-d" ,strtotime($request->date)))
                ->whereIn('status', ['programada', 'confirmada'])
                ->get();
            $validate_profesional = 0;
            foreach ($countSchedules as $c){
                if( intval(strtotime($start_time_s) >= intval(strtotime($c->start_time)))
                    && intval(strtotime($start_time_s)) <= intval(strtotime($c->end_time)) ){
                    $validate_profesional++;
                }else if( intval(strtotime($c->start_time) >= intval(strtotime($start_time_s)))
                    && intval(strtotime($c->start_time)) <= intval(strtotime($end_time_s)) ){
                    $validate_profesional++;
                }
                if( intval(strtotime($end_time_s) >= intval(strtotime($c->start_time)))
                    && intval(strtotime($end_time_s)) <= intval(strtotime($c->end_time)) ){
                    $validate_profesional++;
                }
            }
            if ($validate_profesional > 0){
                return response(json_encode(["message" => "El profesional se encuentra ocupado entre las horas " .
                    $request->start_time . " y " . $request->end_time]), 200)
                    ->header('Content-Type', 'text/json');
            }
            /*
            return response(json_encode(["message" => "PASO AQUI ERROR"]), 200)
                ->header('Content-Type', 'text/json');
            */
            //endvalidacion...

            $countPatient = Schedule::/*where(function ($query) use ($start_time, $end_time, $start_time_s, $end_time_s) {
                $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                    ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                    ->orWhere('start_time', $start_time);
            })->*/where('patient_id', $old_schedule->patient_id)
                ->where('id','!=', $old_schedule->id)
                ->where('date', date("Y-m-d" ,strtotime($request->date)))
                ->whereIn('status', ['programada', 'confirmada'])
                ->get();
            $validate_patient = 0;
            foreach ($countPatient as $c){
                if( intval(strtotime($start_time_s) >= intval(strtotime($c->start_time)))
                    && intval(strtotime($start_time_s)) <= intval(strtotime($c->end_time)) ){
                    $validate_patient++;
                }else if( intval(strtotime($c->start_time) >= intval(strtotime($start_time_s)))
                    && intval(strtotime($c->start_time)) <= intval(strtotime($end_time_s)) ){
                    $validate_patient++;
                }
                if( intval(strtotime($end_time_s) >= intval(strtotime($c->start_time)))
                    && intval(strtotime($end_time_s)) <= intval(strtotime($c->end_time)) ){
                    $validate_patient++;
                }
            }
            if ($validate_patient > 0){
                return response(json_encode(["message" => "El paciente se encuentra en agenda entre las horas " .
                    $request->start_time . " y " . $request->end_time]), 200)
                    ->header('Content-Type', 'text/json');
            }
            /*
            return response(json_encode(["message" => "PASO AQUI ERROR"]), 200)
                ->header('Content-Type', 'text/json');*/
            /*
            $schedule = Schedule::create([
                'patient_id' => $old_schedule->patient_id,
                'personal_id' => $request->professional_id,
                'service_id' => $request->service_id,
                'contract_id' => $request->contract_id_schedule,
                'user_id' => Auth::id(),
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'comment' => $request->comment,
                'color' => User::find($request->professional_id)->color,
                'status' => 'programada'
            ]);*/
            $h_schedule = ScheduleHistorial::create([
                'patient_id'=>$old_schedule->patient_id,
                'schedule_id'=>$old_schedule->id,
                'date'=>$date,
                'status'=>'reprogramada',
                'professional'=>User::find($request->professional_id)->name .' '.User::find($request->professional_id)->lastname,
                'contract'=>$request->contract_id_schedule,
                'service'=>Service::find($request->service_id)->name,
                'comment'=>$old_schedule->comment,
                'start'=>$start_time,
                'end'=>$end_time,
                'comment_update'=>$request->comment,
                'date_update'=>date("Y-m-d"),
                'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
            ]);
            $old_schedule->update([
                'patient_id' => $old_schedule->patient_id,
                'personal_id' => $request->professional_id,
                'service_id' => $request->service_id,
                'contract_id' => $request->contract_id_schedule,
                //'user_id' => Auth::id(),
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'comment' => $request->comment,
                'color' => User::find($request->professional_id)->color,
                'status' => 'programada'
            ]);
            /*
            $old_schedule->update([
                'personal_id' => $request->professional_id,
                'comment' => $request->comment,
                'status' => 'reagendada'
            ]);*/
            $schedule = Schedule::with(['patient', 'service', 'profession'])->find($old_schedule->id);

        } else {
            /*
            return response(json_encode(["message" => "PASO AQUI ERROR sin validacion"]), 200)
                ->header('Content-Type', 'text/json');
            */
            $h_schedule = ScheduleHistorial::create([
                'patient_id'=>$old_schedule->patient_id,
                'schedule_id'=>$old_schedule->id,
                'date'=>$old_schedule->date,
                'status'=>$old_schedule->status,
                'professional'=>User::find($request->professional_id)->name .' '.User::find($request->professional_id)->lastname,
                'contract'=>$request->contract_id_schedule,
                'service'=>Service::find($request->service_id)->name,
                'comment'=>$old_schedule->comment,
                'start'=>$old_schedule->start_time,
                'end'=>$old_schedule->end_time,
                'comment_update'=>$request->comment,
                'date_update'=>date("Y-m-d"),
                'user'=>User::find(Auth::id())->name .' '.User::find(Auth::id())->lastname,
            ]);
            $old_schedule->update([
                'service_id' => $request->service_id,
                'contract_id' => $request->contract_id_schedule,
                'personal_id' => $request->professional_id,
                'comment' => $request->comment
            ]);
            $schedule = Schedule::with(['patient', 'service', 'profession'])->find($old_schedule->id);
        }

        if ($sw) {
            try{
            $text = 'Smadia Clinic
Su cita con el profesional ' . $schedule->profession->name . ' ' . $schedule->profession->lastname . ' para el servicio ' . $schedule->service->name . ' ha sido agendada para el día ' . $schedule->date . ' a las ' . $request->start_time .' en la Sede Barranquilla calle 87 #47-47
En caso de no poder asistir llámanos al 3009122813.';
            SendSms::send('57'.$schedule->patient->cellphone, $text);
            }catch (\Exception $e){
            }
            try{
            Mail::to($schedule->patient->email)->send(new ScheduleAppoinment($schedule));
            }catch (\Exception $e){
            }
        }

        $text = DB::table('text')->find(1)->text;
        $title = str_replace('[titulo]', $schedule->profession->title, $text);
        $title = str_replace('[nombreProfesional]', $schedule->profession->name, $title);
        $title = str_replace('[apellidoProfesional]', $schedule->profession->lastname, $title);
        $title = str_replace('[nombrePaciente]', $schedule->patient->name, $title);
        $title = str_replace('[apellidoPaciente]', $schedule->patient->lastname, $title);
        $title = str_replace('[servicio]', $schedule->service->name, $title);
        $title = str_replace('[observaciones]', $schedule->comment, $title);

        $data = [
            'id' => $schedule->id,
            'professional' => $schedule->personal_id,
            'title' => $title,
            'start' => $schedule->date . " " . $schedule->start_time,
            'end' => $schedule->date . " " . $schedule->end_time,
            'comment' => $schedule->comment,
            'date' => date("d/m/Y", strtotime($schedule->date))
        ];

        return response(json_encode($data), 201)->header('Content-Type', 'text/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patien)
    {
        $this->authorize('delete', Schedule::class);
        $patien->delete();
        return redirect()->route('patiens.index')
            ->with('success','Paciente eliminado exitosamente');
    }

    public function datatable() {
        return \DataTables::of(Schedule::with('patient')->orderByDesc('created_at')->get())->make(true);
    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "states" => $request->query("status"),
        ];
        return Excel::download(new ScheduleExport($data), 'Schedule.xlsx');
    }

    public function contract(Request $request)
    {
        $this->authorize('update', Schedule::class);
        $schedule = Schedule::find($request->schedule_id);

        $service= Service::find($schedule->service_id);
        if($request->contract_id != '')
        {
            $shedule_validate_agend = Schedule::where('service_id',$schedule->service_id)
                ->where('contract_id',$request->contract_id)
                ->whereIn('status', ['programada', 'confirmada','completada','vencida'])
                ->count();
            $item_validate = Item::where(["contract_id" => $request->contract_id, "service_id" => $schedule->service_id])->get();
            $item_validate_qty = 0;
            $validate_agenda_service = true;
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
            //$value_service = $item->total/$item->qty;
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
            //$value_service = $item->total;
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
        return response(json_encode($request->contract_id), 201)->header('Content-Type', 'text/json');
    }

    public function searchHistorialSchedule(Request $request)
    {
        $id = $request->id;
        $patient_id = $request->patient_id;
        $historial_schedule = ScheduleHistorial::where('schedule_id',$id)
            ->where('patient_id',$patient_id)
            ->get();
        return view('schedules.historial',[
            'historial_schedule'=>$historial_schedule
        ]);
    }


}
