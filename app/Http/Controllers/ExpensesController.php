<?php

namespace App\Http\Controllers;

use App\Models\BalanceBox;
use App\Models\CenterCost;
use App\Models\Expenses;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Retention;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExpensesExport;
use Barryvdh\DomPDF\PDF;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Expenses::class);
        $query = Expenses::orderBy('expenses.id','desc')
            ->join('providers', 'providers.id', '=', 'expenses.provider_id')
            ->join('users', 'users.id', '=', 'expenses.user_id');
        if($request->id != ''){
            $id_r = str_replace("E", "", $request->id);
            $id_r = str_replace("e", "", $id_r);
            $id_r = str_replace("-", "", $id_r);
            $query->where('expenses.id','LIKE','%'.$id_r.'%');
        }
        if($request->provider != ''){
            $porciones = explode(" ", $request->provider);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(providers.company)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->nit != ''){
            $porciones = explode(" ", $request->nit);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(providers.nit)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->date != ''){
            $query->where('expenses.created_at','LIKE','%'.$request->date.'%');
        }
        if($request->form_pay != ''){
            $query->where('expenses.form_pay','=',$request->form_pay);
        }
        if($request->value != ''){
            $query->where('expenses.value','LIKE','%'.$request->value.'%');
        }
        if($request->iva != ''){
            $query->where('expenses.iva','LIKE','%'.$request->iva.'%');
        }
        if($request->center_cost != ''){
            $query->where('expenses.center_costs_id','=',$request->center_cost);
        }
        if($request->total != ''){
            $query->where('expenses.total_expense','LIKE','%'.$request->total.'%');
        }
        if($request->responsable != ''){
            $porciones = explode(" ", $request->responsable);
            for($i=0;$i<count($porciones);$i++){
                $query->where(DB::raw('CONCAT(users.name," ",users.lastname)'),'LIKE',"%{$porciones[$i]}%");
            }
        }
        if($request->status != ''){
            $query->where('expenses.status','LIKE','%'.$request->status.'%');
        }

        $totaly = $query->select('expenses.*');
        $value_total = 0;
        $value = 0;
        $iva = 0;
        foreach ($totaly->get() as $t){
            if($request->form_pay != ''){
                if($request->form_pay == $t->form_pay){
                    $value_total = $value_total + $t->total_expense;
                    $value = $value + $t->value;
                    $iva = $iva + $t->iva;
                }
            }else{
                $value_total = $value_total + $t->total_expense;
                $value = $value + $t->value;
                $iva = $iva + $t->iva;
            }
        }
        $expenses = $query->paginate(10);
        $centers = CenterCost::where('status','activo')
            ->where('type','egreso')
            ->get();
            $user= Auth::user();
        return view('expenses.index', [
            'expenses' => $expenses,
            'request'=>$request,
            'value_total'=>$value_total,
            'value'=>$value,
            'iva'=>$iva,
            'centers'=>$centers,
            'user'=>$user
        ]);
    }

    public function create()
    {
        $this->authorize('create', Expenses::class);
        $providers = Provider::where('status','activo')->get();
        $retentions = Retention::all();
        $centerCost = CenterCost::where('status','activo')
            ->where('type','egreso')
            ->get();
        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $todayh = getdate();
        $d = date("d");
        $m = date("m");
        $y = $todayh['year'];
        $date = $d.'-'.$m.'-'.$y;
        return view('expenses.create', [
            'providers'=>$providers,
            'retentions'=>$retentions,
            'centerCost'=>$centerCost,
            'date'=>$date
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Expenses::class);
        /**request()->validate([
            'user_id' => 'required|integer|min:1',
            'provider_id' => 'required|integer|min:1',
            'date' => 'required|string|min:1',
            'purchase_orders_id' => 'required|integer|min:1',
            'form_pay' => 'required|string',
            'value' => 'required|string|min:1',
            'iva' => 'string|min:1',
            'center_costs_id' => 'integer|min:1',
            'retention_id' => 'integer|min:1',
            'total_expense' => 'required|integer|min:1',
            'observations' => 'string',
            'porcent_iva' => 'string|min:1',
            'apli_fact' => 'required|string|min:1',
            'desc_pront_pay' => 'required|string|min:1',
            'desc_type' => 'string|min:1',
            'desc_value' => 'integer|min:1',
            'desc_total' => 'integer|min:1',
            'rte_aplica' => 'required|string|min:1',
            'rte_value' => 'string|min:1',
            'rte_base' => 'string|min:1',
            'rte_porcent' => 'string|min:1',
            'rte_iva' => 'required|string|min:1',
            'rte_iva_porcent' => 'string|min:1',
            'rte_iva_value' => 'string|min:1',
            'rte_ica' => 'required|string|min:1',
            'rte_ica_porcent' => 'string|min:1',
            'rte_ica_value'  => 'string|min:1',
            'rte_cree' => 'required|string|min:1',
            'rte_cree_porcent' => 'string|min:1',
            'rte_cree_value'  => 'string|min:1',
        ]);*/
        request()->validate([
            'provider_id' => 'required|integer',
            'date' => 'required|string',
            'form_pay' => 'required|string',
            'value' => 'required|string',
            'total_expense' => 'required|integer',
            'apli_fact' => 'required|string',
            'desc_pront_pay' => 'required|string',
            'rte_aplica' => 'required|string',
            'rte_iva' => 'required|string',
            'rte_ica' => 'required|string',
            'rte_cree' => 'required|string',
        ]);
        $id = User::find(Auth::id());
        if($request->form_pay == 'efectivo'){
            $amount = 0;
            $count = \App\Models\BalanceBox::where('user_id',$id->id)
                ->where('type','Ingreso')
                ->get();
            foreach($count as $c){
                $amount = $amount + intval($c->monto);
            }
            $count = \App\Models\BalanceBox::where('user_id',$id->id)
                ->where('type','Venta')
                ->get();
            foreach($count as $c){
                $amount = $amount + intval($c->monto);
            }
            $count = \App\Models\BalanceBox::where('type','Egreso')
                ->where('user_id',$id->id)
                ->get();
            foreach($count as $c){
                $amount = $amount - intval($c->monto);
            }
            if($request->total_expense > $amount || $amount == 0){
                return redirect()->route('expenses.create')
                    ->with('success',
                        'Egreso no se puede generar porque falta dinero en el saldo de caja de '
                        .$id->name.' '.$id->lastname.' Valor saldo de caja: $'.number_format($amount,0));
            }
        }
        $amount_value = str_replace(".", "", $request->value);
        $amount_value = str_replace(",", "", $amount_value);
        $request->value = $amount_value;
        $Expenses =  Expenses::create($request->except('user_id'));
        $Expenses->update([
            'user_id' =>$id->id,
            'value' =>$amount_value,
        ]);

        if($Expenses->form_pay == 'efectivo'){
            $dateToday = date("Y-m-d");
            $amount_value = str_replace(".", "", $request->total_expense);
            $amount_value = str_replace(",", "", $amount_value);
            $balanceBox = BalanceBox::create([
                'user_id' => $Expenses->user_id,
                'patient_id' => '',
                'con_id' => $Expenses->id,
                'type' => 'Egreso',
                'monto' => $amount_value,
                'date' => $dateToday,
            ]);
            try{
                //Mail::to('hsmadera18@gmail.com')->send(new \App\Mail\ExpensesCreate($Expenses));
                Mail::to('gerencia@smadiaclinic.com')->send(new \App\Mail\ExpensesCreate($Expenses));
                Mail::to('admon@smadiaclinic.com')->send(new \App\Mail\ExpensesCreate($Expenses));
            }catch (\Exception $e){

            }
        }

        return redirect()->route('expenses.index')
            ->with('success','Egreso creado exitosamente.');
    }

    public function show($id)
    {
        return view('expenses.show', [
            'expense' => Expenses::find($id)
        ]);
    }

    public function GetPurchaseOrders(Request $request)
    {
        try
        {
            $data= Purchase::where('provider_id', $request->id)
                ->orderBy("id",'asc')
                ->get();
            return response(json_encode($data), 200)->header('Content-Type', 'text/json');
        }catch (Exception $e) {
            return " Error: " . $e->getMessage();
        }
    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end")
        ];
        return Excel::download(new ExpensesExport($data), 'Egresos.xlsx');
    }

    public function generatePDF($id)

    {
        $data = Expenses::find($id);
        $pdf = $this->pdf->loadView('pdf.expenses', ['data' => $data]);
        return $pdf->stream('ingreso-smadia.pdf');

    }
    public function anulate(Request $request)
    {
        $id = $request->id;
        $expense = Expenses::find($id);
        $expense->status = 'anulado';
        $expense->motivo = $request->motivo;
        $expense->save();
        $balanceBox = BalanceBox::where('con_id',$expense->id)->where('type','Egreso')->get();
        foreach ($balanceBox as $b){
            $balanceB = BalanceBox::find($b->id);
            $balanceB->type = 'Egreso Anulado';
            $balanceB->save();
        }
        if($expense->form_pay == 'efectivo'){
            Mail::to('gerencia@smadiaclinic.com')->send(new \App\Mail\ExpenseAnulate($expense));
        }
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }
}
