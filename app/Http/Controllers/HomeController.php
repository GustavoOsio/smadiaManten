<?php

namespace App\Http\Controllers;

use App\Models\BudgetDashboard;
use App\Models\Contract;
use App\Models\Monitoring;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\presupuesto_venta;
use App\Models\Income;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\comisionesdepartamentos;
use App\Models\comisionesmedicas;
use App\Models\PaymentAssistance;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        session(['menu_patient_show' => 0]);
        $validate = User::find(Auth::id());
        $dateToday = date("Y-m-d");
        $updMoni = Monitoring::where('date','<',$dateToday)
            ->where('status','activo')
            ->get();
        foreach($updMoni as $m){
            $updateMoni = Monitoring::find($m->id);
            $updateMoni->status = 'vencido';
            $updateMoni->save();
        }


        $taskAll = Task::all();
        $dateToday= date("Y-m-d");
        foreach ($taskAll as $t){
            if($t->date < $dateToday){
                $t_update = Task::find($t->id);
                if($t_update->status == 'activa'){
                    $t_update->status = 'vencida';
                    $t_update->save();
                }
            }
        }
        if ($validate->role->superadmin == 1) {

             if($request->input("inicio") != ""){

                $date_start = $request->input("inicio");
                $date_end = $request->input("fin");
                $date_end = new \Carbon\Carbon($date_end);
                $date_end = $date_end->addDays(1);

             } else{

                $date_start = date("Y-m-01");
                $date_end = date("Y-m-d");
                $date_end = new \Carbon\Carbon($date_end);
                $date_end = $date_end->addDays(1);
             }

            $mesActual = date("m");


            $Income = Income::select([DB::raw('SUM(amount) AS amount')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->where('amount','>',0)
            ->get();


            $IncomeMad = Income::select([DB::raw('SUM(amount) AS amountMad')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [1,23])
            ->where('amount','>',0)
            ->get();


            $IncomeLipo = Income::select([DB::raw('SUM(amount) AS amountLipo')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [3])
            ->where('amount','>',0)
            ->get();



            $IncomePost = Income::select([DB::raw('SUM(amount) AS amountPost')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [8,9,20,31])
            ->where('amount','>',0)
            ->get();



            $IncomeCabinas = Income::select([DB::raw('SUM(amount) AS amountCabinas')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [12,13])
            ->where('amount','>',0)
            ->get();



            $IncomeSuero = Income::select([DB::raw('SUM(amount) AS amountSuero')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [2])
            ->where('amount','>',0)
            ->get();



            $IncomeValoraciones = Income::select([DB::raw('SUM(amount) AS amountValoraciones')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [4,6,7,17,28,29,32,34,36,57])
            ->where('amount','>',0)
            ->get();

            $IncomeOtros = Income::select([DB::raw('SUM(amount) AS amountOtros')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [11,30,14,15,21,16,24,19,18])
            ->where('amount','>',0)
            ->get();

            $IncomeDepilacion = Income::select([DB::raw('SUM(amount) AS amountDepilacion')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [5])
            ->where('amount','>',0)
            ->get();


         $IncomeCirugias = Income::select([DB::raw('SUM(amount) AS amountCirugias')])
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [48])
            ->where('amount','>',0)
            ->get();



            //calendar datos iniciales
            setlocale(LC_ALL,"es_CO");
            ini_set('date.timezone','America/Bogota');
            date_default_timezone_set('America/Bogota');
            $meses=array(1=>"Enero", "Febrero", "MARZO", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $monthArray= date("n");
            $mouthWord = $meses[$monthArray];
            $month=date("m");
            $year=date("Y");
            $cumplimientoValue = collect(Contract::where('created_at','LIKE','%'.$year.'-'.$month.'%')->get())->sum('amount');
            $cumplimientoNum = Patient::where('created_at','LIKE','%'.$year.'-'.$month.'%')->count();
            $dates = Schedule::join('users','users.id','=','schedules.user_id')
                ->join('roles','users.role_id','=','roles.id')
                ->where('schedules.date','LIKE','%'.$year.'-'.$month.'%')
                ->select('roles.name as nameRol','users.role_id as roleId','users.color as colorBackground')
                ->groupBy('users.role_id')
                ->orderBy('users.role_id','asc')
                ->get();
            $budget = BudgetDashboard::where('mouth',$monthArray)
                ->where('year',$year)
                ->first();
            $budgetValue = 0;
            $budgetNum = 0;

            $presupuestoMes = presupuesto_venta::where('mes',$month)->first();
            if(!empty($budget))
            {
                $budgetValue = $budget->value;
                $budgetNum= $budget->patients;
            }
            if($budgetValue < $cumplimientoValue)
            {
                $porcentValue = '100%';
            }else{
                if($budgetValue == 0){
                    $porcentValue = '0%';
                }else{
                    $porcentValue = intval(($cumplimientoValue * 100) / $budgetValue) .'%';
                }
            }
            if($budgetNum < $cumplimientoNum)
            {
                $porcentNum = '100%';
            }else{
                if($budgetNum == 0)
                {
                    $porcentNum = '0%';
                }else{
                    $porcentNum = intval(($cumplimientoNum * 100) / $budgetNum) .'%';
                }
            }

            $Cosmetologas = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
            ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
            ->where('users.status', 'activo')
            ->where('users.role_id', 17)
            ->where('comisionesdepartamentos.idRol', 17)
            ->get();
            $i=0;
    foreach($Cosmetologas as $Cos){

            $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
            ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
            ->whereBetween("incomes.created_at", [$date_start, $date_end])
            ->whereNotIn('method_of_pay', ['unificacion','software'])
            ->whereNotIn('status', ['anulado'])
            ->whereIn('incomes.center_cost_id', [12,13,31,8,9])
            ->where('seller_id', $Cos->id)
            ->where('idUser', $Cos->id)
            ->where('amount','>',0)
            ->get();
            $Cosmetologas[$i]['monto']=$Income[0]['amount'];


            $i++;

    }

    $depilcare = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
    ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
    ->where('users.status', 'activo')
    ->where('users.role_id', 24)
    ->where('comisionesdepartamentos.idRol', 24)
    ->get();
    $i=0;
foreach($depilcare as $depil){

    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [5,12,13,31])
    ->where('seller_id', $depil->id)
    ->where('idUser', $depil->id)
    ->where('amount','>',0)
    ->get();
    $depilcare[$i]['monto']=$Income[0]['amount'];


    $i++;

}



$Medicos= comisionesmedicas::select(['comisionesmedicas.*', 'users.*'])
->join('users', 'users.id', '=', 'comisionesmedicas.idMedico')
->where('users.status', 'activo')
->where('users.role_id', 2)
->groupBy('comisionesmedicas.idMedico')
->get();
$i=0;

foreach($Medicos as $Medic){

if($Medic->id==7){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [11,12,14,15,16,18,19,21,24,30])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}
if($Medic->id==8){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [2])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}

if($Medic->id==9){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [1,2,3,5,11,12,13,14,15,16,18,19,21,23,24,30,48])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}



if($Medic->id==11){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [1,2,3,5,11,12,13,14,15,16,18,19,21,23,24,30,48])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}


if($Medic->id==39){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [1,2,3,5,11,12,13,14,15,16,18,19,21,23,24,30,48])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}



if($Medic->id==41){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [1,2,3,5,11,12,13,14,15,16,18,19,21,23,24,30,48])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}


if($Medic->id==49){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [1,2,3,5,11,12,13,14,15,16,18,19,21,23,24,30,48])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}

if($Medic->id==67){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [1,2,3,5,11,12,13,14,15,16,18,19,21,23,24,30,48])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}



if($Medic->id==53){
    $Income = Income::select([DB::raw('SUM(incomes.amount) AS amount')])
    ->whereBetween("incomes.created_at", [$date_start, $date_end])
    ->whereNotIn('method_of_pay', ['unificacion','software'])
    ->whereNotIn('status', ['anulado'])
    ->whereIn('incomes.center_cost_id', [11,12,14,15,16,19,21,24,30])
    ->where('seller_id', $Medic->id)
    ->where('amount','>',0)
    ->get();
}


    $Medicos[$i]['monto']=$Income[0]['amount'];


    $i++;

}




$efectividad= comisionesmedicas::select(['comisionesmedicas.*', 'users.*'])
->join('users', 'users.id', '=', 'comisionesmedicas.idMedico')
->where('users.status', 'activo')
->where('users.role_id', 2)
->groupBy('comisionesmedicas.idMedico')
->get();

$i=0;

foreach($efectividad as $efect){

    $valoracionInicial = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
    ->whereIn('schedules.status', ['completada'])
    ->whereIn('service_id', [5])
    ->where('personal_id', $efect->id)
    ->whereBetween("date", [$date_start, $date_end])
    ->orderByDesc('date')
    ->get();

    $valoracionVirtual = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
    ->whereIn('schedules.status', ['completada'])
    ->whereIn('service_id', [74])
    ->where('personal_id', $efect->id)
    ->whereBetween("date", [$date_start, $date_end])
    ->orderByDesc('date')
    ->get();

    $valoracionCortesia = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
    ->whereIn('schedules.status', ['completada'])
    ->whereIn('service_id', [117])
    ->where('personal_id', $efect->id)
    ->whereBetween("date", [$date_start, $date_end])
    ->orderByDesc('date')
    ->get();

    $efectividad[$i]['valoracionInicial']=sizeof($valoracionInicial);
    $efectividad[$i]['valoracionVirtual']=sizeof($valoracionVirtual);
    $efectividad[$i]['valoracionCortesia']=sizeof($valoracionCortesia);

    $i++;

}






$procRealizados = comisionesmedicas::select(['comisionesmedicas.*', 'users.*'])
->join('users', 'users.id', '=', 'comisionesmedicas.idMedico')
->where('users.status', 'activo')
->where('users.role_id', 2)
->whereNotIn('users.id', [7])
->groupBy('comisionesmedicas.idMedico')
->get();
$i=0;

foreach($procRealizados as $prod){


    $nombreMedico=$prod->name." ".$prod->lastname;

 $queryMad = PaymentAssistance::select(['payment_assistance.*'])
    ->join('services', 'services.name', '=', 'payment_assistance.serv')
    ->where('asyst','LIKE','%'.$nombreMedico.'%')
    ->where('services.id','!=', 5)
    ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
    ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
    ->groupBy('id')
    ->get();

    $queryLipo = PaymentAssistance::select(['payment_assistance.*'])
    ->join('services', 'services.name', '=', 'payment_assistance.serv')
    ->where('asyst','LIKE','%'.$nombreMedico.'%')
    ->where('services.id','!=', 5)
    ->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
    ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
    ->groupBy('id')
    ->get();

    $procRealizados[$i]['mad'] = sizeof($queryMad);
    $procRealizados[$i]['lipo'] = sizeof($queryLipo);
   $i++;
}
/*

return $procRealizados;
    return $efectividad;

    return $Medicos;*/
    setlocale(LC_ALL,"es_CO");
    ini_set('date.timezone','America/Bogota');
    date_default_timezone_set('America/Bogota');
    $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $monthArray= date("n");
    $mouthWord = $meses[$monthArray];
    $month=date("m");
    $year=date("Y");
    $dates = Schedule::join('users','users.id','=','schedules.user_id')
        ->join('services','services.id','=','schedules.service_id')
        ->where('schedules.date','LIKE','%'.$year.'-'.$month.'%')
        ->where('users.id',$validate->id)
        ->select('schedules.*','services.name as serviceName','users.role_id as roleId','users.color as colorBackground')
        ->orderBy('users.role_id','asc')
        ->get();

    $monitorings = Monitoring::join('issues', 'monitorings.issue_id', '=', 'issues.id')
            ->select('issues.name', DB::raw('count(issue_id) as ct'),'monitorings.status','monitorings.date')
            ->where('responsable_id', Auth::id())
            ->groupBy('issue_id')->get();
    $monitoringsAll = Monitoring::where('responsable_id',Auth::id())
        ->get();
    $task = Task::where('user_id',Auth::id())->get();
            return view('home', [
                'users' => User::where('status', 'activo')->get(),
                'monitorings' => $monitorings,
                'monitoringsAll' => $monitoringsAll,
                'dates'=>$dates,
                'year'=>$year,
                'month'=>$month,
                'task'=>$task,
                'mouthWord'=>$mouthWord,
                'cumplimientoValue'=>$cumplimientoValue,
                'cumplimientoNum'=>$cumplimientoNum,
                'dates'=>$dates,
                'budgetValue'=>$budgetValue,
                'budgetNum'=>$budgetNum,
                'porcentValue'=>$porcentValue,
                'porcentNum'=>$porcentNum,
                'task'=>$task,
                'presupuestoMes'=>$presupuestoMes,
                'Income' => $Income[0]['amount'],
                'IncomeMad' => $IncomeMad[0]['amountMad'],
                'IncomeLipo' => $IncomeLipo[0]['amountLipo'],
                'IncomePost' => $IncomePost[0]['amountPost'],
                'IncomeCabinas' => $IncomeCabinas[0]['amountCabinas'],
                'IncomeSuero' => $IncomeSuero[0]['amountSuero'],
                'IncomeValoraciones' => $IncomeValoraciones[0]['amountValoraciones'],
                'IncomeOtros' => $IncomeOtros[0]['amountOtros'],
                'IncomeDepilacion' => $IncomeDepilacion[0]['amountDepilacion'],
                'IncomeCirugias' => $IncomeCirugias[0]['amountCirugias'],
                'Cosmetologas' => $Cosmetologas,
                'depilcare' => $depilcare,
                'Medicos' => $Medicos,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'efectividad' => $efectividad,
                'procRealizados' => $procRealizados
            ]);



        } else {
            setlocale(LC_ALL,"es_CO");
            ini_set('date.timezone','America/Bogota');
            date_default_timezone_set('America/Bogota');
            $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $monthArray= date("n");
            $mouthWord = $meses[$monthArray];
            $month=date("m");
            $year=date("Y");
            $dates = Schedule::join('users','users.id','=','schedules.user_id')
                ->join('services','services.id','=','schedules.service_id')
                ->where('schedules.date','LIKE','%'.$year.'-'.$month.'%')
                ->where('users.id',$validate->id)
                ->select('schedules.*','services.name as serviceName','users.role_id as roleId','users.color as colorBackground')
                ->orderBy('users.role_id','asc')
                ->get();

            $monitorings = Monitoring::join('issues', 'monitorings.issue_id', '=', 'issues.id')
                    ->select('issues.name', DB::raw('count(issue_id) as ct'),'monitorings.status','monitorings.date')
                    ->where('responsable_id', Auth::id())
                    ->groupBy('issue_id')->get();
            $monitoringsAll = Monitoring::where('responsable_id',Auth::id())
                ->get();
            $task = Task::where('user_id',Auth::id())->get();
            return view('home_altern', [
                'users' => User::where('status', 'activo')->get(),
                'monitorings' => $monitorings,
                'monitoringsAll' => $monitoringsAll,
                'dates'=>$dates,
                'year'=>$year,
                'month'=>$month,
                'task'=>$task
            ]);
        }
    }
}
