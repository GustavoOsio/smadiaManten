<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use App\Models\comisionesdepartamentos;
use App\Models\Service;
use App\Models\Role;
use App\Models\CenterCost;
use App\User;
use App\Models\presupuesto_venta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Cell;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComisionesDptoExport;
use App\Models\Income;
use App\Models\PaymentAssistance;
use App\Models\procedimientosmeta;
use App\Models\SaleProduct;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Schedule;
use App\Models\ScheduleHistorial;
use App\Models\RelationSurgeryExpensesSheet;
use App\Models\SurgeryExpensesSheet;

class comisionesDepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = comisionesdepartamentos::orderByDesc('created_at')->get();
        $medicos = Role::where('status', 'activo')->orderByDesc('created_at')->get();
        return view('comisionesDepartamentos.index', ['cellars' => $data, 'medicos' => $medicos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $data = Role::where('status', 'activo')->whereNotIn('id', [1,2])->orderByDesc('created_at')->get();
        $Service = Service::where('status', 'activo')->orderByDesc('created_at')->get();
        $CenterCost = CenterCost::where('status', 'activo')->orderByDesc('name')->get();

        return view('comisionesDepartamentos.create', ['medicos' => $data, 'services' => $Service, 'CenterCost' => $CenterCost]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        for ($i = 1; $i <= $request->numberList; $i++) {

            $ventasHasta = "ventasPorcentajeHasta".$i;
            $ventasDesde = "ventasPorcentajeDesde".$i;
            $ventasComision = "ventasPorcentajeComision".$i;
            $Ventaservice = "Ventaservice".$i;

if($request->$Ventaservice!=""){
                $comisionesdepartamentos = new comisionesdepartamentos();
                $comisionesdepartamentos->idRol = $request->medico;
                $comisionesdepartamentos->idProcedimiento = $request->$Ventaservice;
                $comisionesdepartamentos->tipoComision = "VENTA";
                $comisionesdepartamentos->porcentajeDesde = $request->$ventasDesde;
                $comisionesdepartamentos->porcentajeHasta = $request->$ventasHasta;
                $comisionesdepartamentos->porcentajeComision = $request->$ventasComision;
                $comisionesdepartamentos->metaMensual = $request->metaMensual;
                $comisionesdepartamentos->save();

            }
        }
                
        for ($i = 1; $i <= $request->numberList1; $i++) {

            $prodService = "prodService".$i;
            $prodPorcentajeComision = "prodPorcentajeComision".$i;
            $prodHasta = "prodPorcentajeHasta".$i;
            $prodDesde = "prodPorcentajeDesde".$i;
            if($request->$prodService!=""){
                $comisionesdepartamentos = new comisionesdepartamentos();
                $comisionesdepartamentos->idMedico = $request->medico;
                $comisionesdepartamentos->idProcedimiento = $request->$prodService;
                $comisionesdepartamentos->tipoComision = "PROCEDIMIENTO";
                $comisionesdepartamentos->porcentajeDesde = $request->$prodDesde;
                $comisionesdepartamentos->porcentajeHasta = $request->$prodHasta;
                $comisionesdepartamentos->porcentajeComision = $request->$prodPorcentajeComision;
                $comisionesdepartamentos->metaMensual = $request->metaMensual;
                $comisionesdepartamentos->save();
            }

        }
 

        return redirect()->route('comisionesDepartamentos.create')
            ->with('success','Comisión creada exitosamente.');

    }




    public function export(Request $request)
    {
 //return  $request;

        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "idMedico" =>  $request->idMedico
        ];
        $date_start = $request->query("date_start");
     $date_end = $request->query("date_end");
     $date_end = new \Carbon\Carbon($date_end);
     $date_end = $date_end->addDays(1);
        $fechaFinal=$request->query("date_end");
        $idMedico = $request->idMedico;
            
        
        if($idMedico==18){

            $valorMetaGlobal=0;
             $schedulesMad = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [1])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
        
                $schedulesMad3Zonas = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [90])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
        
                $schedulesOtrosMad = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [115])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
        
        
                $schedulesLipoVal = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [69])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
                $schedulesLipovalOtros = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [114])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
        
        
                $schedulesLipoVal4zonas = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [119])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
                $schedulesMamoPlas = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [47])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
             $schedulesResecc = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [83])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
            
             $schedulesBlefa = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [96])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
               $schedulesAbdomi = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->whereIn('service_id', [99])
                ->whereBetween("date", [$date_start, $fechaFinal])
                ->orderByDesc('date')->get();
        
        
                 $cantidadCitas = sizeof($schedulesMad)+
                 sizeof($schedulesMad3Zonas)+
                 sizeof($schedulesOtrosMad)+
                 sizeof($schedulesLipoVal)+
                 sizeof($schedulesLipovalOtros)+
                 sizeof($schedulesLipoVal4zonas)+
                 sizeof($schedulesMamoPlas)+
                 sizeof($schedulesResecc)+
                 sizeof($schedulesBlefa)+
                 sizeof($schedulesAbdomi);
        
         
        
        
             $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
                ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
                ->where('users.role_id', $idMedico)        
                ->where('comisionesdepartamentos.idRol', $idMedico) 
                ->get();
                $i=0;
        
        
                foreach($data as $met){
        
                    $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
                    ->join('products', 'products.id', '=', 'sales_products.product_id')
                    ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
                    ->where('sales.seller_id', $met->id)
                    ->where('sales.status', '!=', 'anulada')
                    ->whereBetween("sales_products.created_at", [$date_start, $date_end])
                    ->groupBy('products.id')
                    ->get();
        
                    $data[$i]['productos']=$comisionesProductos;
        
        
                    $i++;
                }
            } 
            
            
            elseif($idMedico==19){
        
        
                $cantidadCitas=0;
                $schedulesMad="";
                $schedulesMad3Zonas="";
                $schedulesOtrosMad="";
                $schedulesLipoVal="";
                $schedulesLipovalOtros="";
                $schedulesLipoVal4zonas="";
                $schedulesMamoPlas="";
                $schedulesResecc="";
                $schedulesBlefa="";
                $schedulesAbdomi="";
        
            /*$schedules = Schedule::join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'payment_assistance.serv')
                ->whereIn('status', ['completada'])
                ->whereIn('service_id', [69,111,113,114,116,119,124])
                ->whereBetween("date", [$date_start, $date_end])
                ->orderByDesc('date')->get();
        
                 $cantidadCitas = sizeof($schedules);*/
        
           $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
                ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
                ->where('users.role_id', $idMedico)        
                ->where('users.status', 'activo') 
                ->where('comisionesdepartamentos.idRol', $idMedico) 
                ->get();
                $i=0;
        
                $valorMetaGlobal=0;
                foreach($data as $met){
        
        
                 $schedulesMad = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('service_id', [1])     
                    ->where('user_id', $met->id)  
                    ->whereBetween("date", [$date_start, $fechaFinal])
                    ->orderByDesc('date')->get();
            
            
                    $schedulesMad3Zonas = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('service_id', [90])     
                    ->where('user_id', $met->id)  
                    ->whereBetween("date", [$date_start, $fechaFinal])
                    ->orderByDesc('date')->get();
            
            
                    $schedulesOtrosMad = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('service_id', [115])     
                    ->where('user_id', $met->id)  
                    ->whereBetween("date", [$date_start, $fechaFinal])
                    ->orderByDesc('date')->get();
            
            
            
                    $schedulesLipoVal = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('service_id', [69])     
                    ->where('user_id', $met->id)  
                    ->whereBetween("date", [$date_start, $fechaFinal])
                    ->orderByDesc('date')->get();
            
                    $schedulesLipovalOtros = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('service_id', [114])     
                    ->where('user_id', $met->id)  
                    ->whereBetween("date", [$date_start, $fechaFinal])
                    ->orderByDesc('date')->get();
            
            
            
                    $schedulesLipoVal4zonas = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('service_id', [119])     
                    ->where('user_id', $met->id)  
                    ->whereBetween("date", [$date_start, $fechaFinal])
                    ->orderByDesc('date')->get();
                 
                    $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
                    ->join('products', 'products.id', '=', 'sales_products.product_id')
                    ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
                    ->where('sales.seller_id', $met->id)
                    ->where('sales.status', '!=', 'anulada')
                    ->whereBetween("sales_products.created_at", [$date_start, $date_end])
                    ->groupBy('products.id')
                    ->get();
        
        
        
                    $IncomeDepilcare = Income::select([ DB::raw('SUM(amount) AS suma')])
                    ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.responsable_id')
                    ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
                    ->whereNotIn('method_of_pay', ['unificacion','software'])        
                    ->whereNotIn('status', ['anulado'])        
                    ->whereIn('incomes.center_cost_id', [5])     
                    ->where('seller_id', $met->id)    
                    ->where('idUser', $met->id)
                    ->where('amount','>',0)
                    ->get();
        
        
        $IncomeDepilcare2 = Income::select(['incomes.*'])
        ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
        ->whereNotIn('method_of_pay', ['unificacion','software'])        
        ->whereNotIn('status', ['anulado'])        
        ->whereIn('incomes.center_cost_id', [5])     
        ->where('responsable_id', $met->id)    
        ->where('amount','>',0)
        ->get();
        
        
        $IncomeSuero = Income::select([ DB::raw('SUM(amount) AS sumaSuero') ])
        ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
        ->whereNotIn('method_of_pay', ['unificacion','software'])        
        ->whereNotIn('status', ['anulado'])        
        ->whereIn('incomes.center_cost_id', [2])     
        ->where('follow_id', $met->id)    
        ->where('amount','>',0)
        ->get();
        
        $IncomeOtros = Income::select([DB::raw('SUM(amount) AS sumaOtros')])
        ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
        ->whereNotIn('method_of_pay', ['unificacion','software'])        
        ->whereNotIn('status', ['anulado'])        
        ->whereIn('incomes.center_cost_id', [11,30,14,15,21,16,24,19,18])     
        ->where('follow_id', $met->id)    
        ->where('amount','>',0)  
        ->get();

 
        $cantidadTotal=sizeof($schedulesMad)+sizeof($schedulesMad3Zonas)+sizeof($schedulesOtrosMad)+sizeof($schedulesLipoVal)+sizeof($schedulesLipovalOtros)+sizeof($schedulesLipoVal4zonas);
        
         $porcentaje = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
        ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
        ->where('users.role_id', $idMedico)        
        ->where('users.status', 'activo') 
        ->where('comisionesdepartamentos.idRol', $idMedico) 
        ->where('comisionesdepartamentos.porcentajeDesde','<=',$cantidadTotal)                
        ->where('comisionesdepartamentos.porcentajeHasta','>=',$cantidadTotal)
        ->first();

                    $data[$i]['schedulesMad']=sizeof($schedulesMad);
                    
                    $data[$i]['schedulesMad3Zonas']=sizeof($schedulesMad3Zonas);
                    
                    $data[$i]['schedulesOtrosMad']=sizeof($schedulesOtrosMad);
                    
                    $data[$i]['schedulesLipoVal']=sizeof($schedulesLipoVal);
                    
                    $data[$i]['schedulesLipovalOtros']=sizeof($schedulesLipovalOtros);
                    
                    $data[$i]['schedulesLipoVal4zonas']=sizeof($schedulesLipoVal4zonas);
        
                    $data[$i]['productos']=$comisionesProductos;
        
                    $data[$i]['ingresosDepilcare']=$IncomeDepilcare[0]['suma'];
                    $data[$i]['IncomeSuero']=$IncomeSuero[0]['sumaSuero'];
                    $data[$i]['ingresosOtros']=$IncomeOtros[0]['sumaOtros'];
        
                    $data[$i]['porcentajeComision']=$porcentaje->porcentajeComision;
                    
        
                    $i++;
                }
            }
        
        
        
        elseif($idMedico==17){


            $año = date("Y", strtotime($date_start));
            $mes = date("m", strtotime($date_start));
            $primerDia = $año."-".$mes."-"."01";
            $mitadDeMes = $año."-".$mes."-"."15";
            $ultimoDia= date( 'Y-m-t', strtotime($date_start));

            $ultimoDia = new \Carbon\Carbon($ultimoDia);
            $ultimoDia = $ultimoDia->addDays(1);

          $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
        ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
        ->where('users.status', 'activo') 
        ->where('users.role_id', $idMedico)        
        ->where('comisionesdepartamentos.idRol', $idMedico) 
        ->get();
        $i=0;
        $valorMetaGlobal=0;
        foreach($data as $met){
            $nombreMedico=$met->name." ".$met->lastname;
        
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
            ->where('asyst','LIKE','%'.$nombreMedico.'%')
            ->where('services.id','!=', 5)
            ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

            $queryMitad = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
            ->where('asyst','LIKE','%'.$nombreMedico.'%')
            ->where('services.id','!=', 5)
            ->whereIn('services.id', [2,9,70])
            ->whereBetween("payment_assistance.created_at", [$primerDia, $mitadDeMes])->get();
        
            $Income = Income::select(['incomes.*'])
            ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
            ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
            ->whereNotIn('method_of_pay', ['unificacion','software'])        
            ->whereNotIn('status', ['anulado'])        
            ->whereIn('incomes.center_cost_id', [2,5,11,14,30,15,21,16,24,19])     
            ->where('seller_id', $met->id)    
            ->where('idUser', $met->id)
            ->where('amount','>',0)
            ->get();
        
            $presupuestoMes = presupuesto_venta::where('mes',$mes)->first();

            $IncomeTotal = Income::select([DB::raw('SUM(incomes.amount) AS sum_of_1')])
            ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
            ->whereBetween("incomes.created_at", [$primerDia, $ultimoDia]) 
            ->whereNotIn('method_of_pay', ['unificacion','software'])        
            ->whereNotIn('status', ['anulado'])            
            ->where('seller_id', $met->id)    
            ->where('idUser', $met->id)
            ->where('amount','>',0)
            ->get();

            $IncomeTotalCabinas = Income::select([DB::raw('SUM(incomes.amount) AS sum_of_1')])
            ->whereBetween("incomes.created_at", [$primerDia, $ultimoDia]) 
            ->whereNotIn('method_of_pay', ['unificacion','software'])        
            ->whereNotIn('status', ['anulado'])        
            ->whereIn('incomes.center_cost_id', [12,13])     
            ->where('amount','>',0)
            ->get();


        
            $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
            ->join('products', 'products.id', '=', 'sales_products.product_id')
            ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
            ->where('sales.seller_id', $met->id)
            ->where('sales.status', '!=', 'anulada')
            ->whereBetween("sales_products.created_at", [$date_start, $date_end])
            ->groupBy('products.id')
            ->get();
        
               $data[$i]['productos']=$comisionesProductos;
            $data[$i]['citasRealizadas']=$query;
            $data[$i]['ventas']=$Income;
            $data[$i]['ventasTotal']=$IncomeTotal[0]['sum_of_1'];
            $data[$i]['mitadMes']=$queryMitad;
            $data[$i]['TotalCabinas']=$IncomeTotalCabinas[0]['sum_of_1'];
            $data[$i]['metaCabinas']=$presupuestoMes->metaCabinas;
            $i++;
        }
        
        
        $cantidadCitas=0;
        $schedulesMad="";
        $schedulesMad3Zonas="";
        $schedulesOtrosMad="";
        $schedulesLipoVal="";
        $schedulesLipovalOtros="";
        $schedulesLipoVal4zonas="";
        $schedulesMamoPlas="";
        $schedulesResecc="";
        $schedulesBlefa="";
        $schedulesAbdomi="";
        $comisionesProductos="";
        }
        
        
        
        elseif($idMedico==24){
        
               $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
               ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
               ->where('users.status', 'activo') 
               ->where('users.role_id', $idMedico)        
               ->where('comisionesdepartamentos.idRol', $idMedico) 
               ->get();
               $i=0;
        
               $valorMetaGlobal=0;
               foreach($data as $met){
        
        
                $schedules = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                ->whereIn('schedules.status', ['completada'])
                ->where('personal_id', $met->id)  
                ->whereBetween("date", [$date_start, $date_end])
                ->orderByDesc('date')->get();
        
                
        
        
        
                $Income = Income::select([DB::raw('SUM(amount) AS sumaOtros')])
                ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
                ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
                ->whereNotIn('method_of_pay', ['unificacion','software'])        
                ->whereNotIn('status', ['anulado'])    
                ->whereIn('incomes.center_cost_id', [5])  
                ->where('seller_id', $met->id)    
                ->where('idUser', $met->id)
                ->where('amount','>',0)
                ->get();
        
        
                $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
                ->join('products', 'products.id', '=', 'sales_products.product_id')
                ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
                ->where('sales.seller_id', $met->id)
                ->where('sales.status', '!=', 'anulada')
                ->whereBetween("sales_products.created_at", [$date_start, $date_end])
                ->groupBy('products.id')
                ->get();
        
                   $data[$i]['productos']=$comisionesProductos;
                   $data[$i]['Citas']=$schedules;
                   $data[$i]['Ventas']=$Income[0]['sumaOtros'];
        
        $valorMetaGlobal+=$Income[0]['sumaOtros'];
                   $i++;
                   $cantidadCitas= sizeof($schedules);
               }
               $schedulesMad = "";
               $schedulesMad3Zonas = "";
               $schedulesOtrosMad = "";
               $schedulesLipoVal = "";
               $schedulesLipovalOtros = "";
               $schedulesLipoVal4zonas = "";
               $schedulesMamoPlas = "";
               $schedulesResecc = "";
               $schedulesBlefa = "";
               $schedulesAbdomi = "";
               $comisionesProductos="";
           }
        
        
        
           elseif($idMedico==16){
           
                 $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
                  ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
                  ->where('users.role_id', $idMedico)
                  ->where('users.status', 'activo')        
                  ->where('comisionesdepartamentos.idRol', $idMedico) 
                  ->get();
                  $i=0;
           
                  $valorMetaGlobal=0;
                  foreach($data as $met){
           
                    $schedules = Schedule::join('services', 'services.id', '=', 'schedules.service_id')
                    ->where('schedules.date','>=',$date_start)
                    ->where('schedules.date','<=',$fechaFinal)
                    ->whereIn('schedules.status', ['completada'])
                    ->whereIn('schedules.service_id', [5,74])
                    ->where('schedules.user_id', $met->id)  
                    ->orderByDesc('date')->get();
        
                    $cantidadV=sizeof($schedules);
            
                   $Income = Income::select(['incomes.*'])
                   ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
                   ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
                   ->whereNotIn('method_of_pay', ['unificacion','software'])        
                   ->whereNotIn('status', ['anulado'])         
                   ->whereIn('incomes.center_cost_id', [5])     
                   ->where('seller_id', $met->id)    
                   ->where('idUser', $met->id)
                   ->where('amount','>',0)
                   ->get();
           
           
                   $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
                   ->join('products', 'products.id', '=', 'sales_products.product_id')
                   ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
                   ->where('sales.seller_id', $met->id)
                   ->where('sales.status', '!=', 'anulada')
                   ->whereBetween("sales_products.created_at", [$date_start, $date_end])
                   ->groupBy('products.id')
                   ->get();
           
                      $data[$i]['productos']=$comisionesProductos;
                      $data[$i]['Ventas']=$Income;
                      $data[$i]['Citas']=$schedules;
                      $data[$i]['cantidadV']=$cantidadV;
           
                      $i++;
                  }
        
                  $schedulesMad = "";
                  $schedulesMad3Zonas = "";
                  $schedulesOtrosMad = "";
                  $schedulesLipoVal = "";
                  $schedulesLipovalOtros = "";
                  $schedulesLipoVal4zonas = "";
                  $schedulesMamoPlas = "";
                  $schedulesResecc = "";
                  $schedulesBlefa = "";
                  $schedulesAbdomi = "";
                  $comisionesProductos="";  
                  $cantidadCitas = 0;
            }
        
        
        
        
            elseif($idMedico==25){
           
                $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
                 ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
                 ->where('users.role_id', $idMedico)
                 ->where('users.status', 'activo')        
                 ->where('comisionesdepartamentos.idRol', $idMedico) 
                 ->get();
                 $i=0;
          
                 $valorMetaGlobal=0;
                 foreach($data as $met){
          
           
                  $IncomeTotal = Income::select([DB::raw('SUM(amount) AS sumaOtros')])
                  ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
                  ->whereNotIn('method_of_pay', ['unificacion','software'])        
                  ->whereNotIn('status', ['anulado'])         
                  ->whereIn('incomes.center_cost_id', [2])    
                  ->where('amount','>',0)
                  ->get();
          
                     
                  $Income = Income::select(['incomes.*'])
                  ->join('comisionesdepartamentos', 'comisionesdepartamentos.idUser', '=', 'incomes.seller_id')
                  ->whereBetween("incomes.created_at", [$date_start, $date_end]) 
                  ->whereNotIn('method_of_pay', ['unificacion','software'])        
                  ->whereNotIn('status', ['anulado'])         
                  ->whereIn('incomes.center_cost_id', [2])     
                  ->where('seller_id', $met->id)    
                  ->where('idUser', $met->id)
                  ->where('amount','>',0)
                  ->get();
          
                  $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
                  ->join('products', 'products.id', '=', 'sales_products.product_id')
                  ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
                  ->where('sales.seller_id', $met->id)
                  ->where('sales.status', '!=', 'anulada')
                  ->whereBetween("sales_products.created_at", [$date_start, $date_end])
                  ->groupBy('products.id')
                  ->get();
          
                     $data[$i]['productos']=$comisionesProductos;
                     $data[$i]['Ventas']=$Income;
                     $data[$i]['ventasGlobal']=$IncomeTotal[0]['sumaOtros'];
          
                     $i++;
                 }
        
                 $schedulesMad = "";
                 $schedulesMad3Zonas = "";
                 $schedulesOtrosMad = "";
                 $schedulesLipoVal = "";
                 $schedulesLipovalOtros = "";
                 $schedulesLipoVal4zonas = "";
                 $schedulesMamoPlas = "";
                 $schedulesResecc = "";
                 $schedulesBlefa = "";
                 $schedulesAbdomi = "";
                 $comisionesProductos="";  
                 $cantidadCitas = 0;
           }
        
           elseif($idMedico==23){
           
             $data = comisionesdepartamentos::select(['comisionesdepartamentos.*', 'users.*'])
             ->join('users', 'users.id', '=', 'comisionesdepartamentos.idUser')
             ->where('users.role_id', $idMedico)
             ->where('users.status', 'activo')        
             ->where('comisionesdepartamentos.idRol', $idMedico) 
             ->get();
             $i=0;
        
             $valorMetaGlobal=0;
             foreach($data as $met){
        
        
        
        
              $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
              ->join('products', 'products.id', '=', 'sales_products.product_id')
              ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
              ->where('sales.seller_id', $met->id)
              ->where('sales.status', '!=', 'anulada')
              ->whereBetween("sales_products.created_at", [$date_start, $date_end])
              ->groupBy('products.id')
              ->get();
              
              $comisionesGlobal = SaleProduct::select(['products.name','sales_products.price','sales_products.discount','products.price_vent', DB::raw('SUM(sales_products.qty) AS cantidad'), DB::raw('SUM(sales_products.discount_cop) AS discount_cop')])
              ->join('products', 'products.id', '=', 'sales_products.product_id')
              ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
              ->where('sales.status', '!=', 'anulada')
              ->whereIn('sales_products.product_id', [11,10,191,12,192,74,178,179])     
              ->whereBetween('sales_products.created_at', [$date_start, $date_end])
              ->groupBy('products.id')
              ->get();
        
        
                 $data[$i]['productos']=$comisionesProductos;
                 $data[$i]['productosGlobal']=$comisionesGlobal;
        
                 $i++;
             }
        
             $schedulesMad = "";
             $schedulesMad3Zonas = "";
             $schedulesOtrosMad = "";
             $schedulesLipoVal = "";
             $schedulesLipovalOtros = "";
             $schedulesLipoVal4zonas = "";
             $schedulesMamoPlas = "";
             $schedulesResecc = "";
             $schedulesBlefa = "";
             $schedulesAbdomi = "";
             $comisionesProductos="";  
             $cantidadCitas = 0;

        } elseif($idMedico==10){












        }
        
        
       /*return $data;*/
                          
        return view('exports.comisionesDepartamentos', [
            'data' => $data,
            'productos' => $comisionesProductos,
            'departamento' => $idMedico,
            'cantidadCitas' => $cantidadCitas,
            'schedulesMad' => $schedulesMad,
            'schedulesMad3Zonas' => $schedulesMad3Zonas,
            'schedulesOtrosMad' => $schedulesOtrosMad,
            'schedulesLipoVal' => $schedulesLipoVal,
            'schedulesLipovalOtros' => $schedulesLipovalOtros,
            'schedulesLipoVal4zonas' => $schedulesLipoVal4zonas,
            'schedulesMamoPlas' => $schedulesMamoPlas,
            'schedulesResecc' => $schedulesResecc,
            'schedulesBlefa' => $schedulesBlefa,
            'schedulesAbdomi' => $schedulesAbdomi,
            'valorMetaGlobal' => $valorMetaGlobal,
            'fechaInico' => $date_start,
            'fechafin' => $date_end
        ]);
        
        
        
        


/*return Excel::download(new ComisionesDptoExport($data), 'ComisionesDepartamentos.xlsx');*/

    }










    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cellar $cellar)
    {
        $this->authorize('update', Cellar::class);
        return view('cellars.edit',['cellar' => $cellar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cellar $cellar)
    {
        $this->authorize('update', Cellar::class);
        request()->validate([
            'name' => 'required|string|min:3|max:100',
            'status' => 'required|alpha|max:8',
        ]);


        $cellar->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('cellars.index')
            ->with('success','Bodega actualizada exitosamente.');
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
