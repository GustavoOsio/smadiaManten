<?php

namespace App\Http\Controllers;

use App\Exports\ContractsExport;
use App\Models\Consumed;
use App\Models\ContactSource;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Income;
use App\Models\Item;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\SignaturesContracts;
use App\Models\State;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\productoscomisiones;

class ContractController extends Controller
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
        $this->authorize('view', Contract::class);
        $query = Contract::orderBy('contracts.id','desc')
            ->join('patients', 'patients.id', '=', 'contracts.patient_id')
            ->join('users as seller', 'seller.id', '=', 'contracts.seller_id')
            ->join('users', 'users.id', '=', 'contracts.user_id');
        if($request->id != ''){
            $query->where('contracts.id','LIKE','%'.$request->id.'%');
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
            $query->where('contracts.amount','LIKE',''.$monto.'%');
        }
        if($request->description != ''){
            $query->where('contracts.comment','LIKE','%'.$request->description.'%');
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
        if($request->status != ''){
            $query->where('contracts.status','LIKE','%'.$request->status.'%');
        }
        if($request->date != ''){
            $query->where('contracts.created_at','LIKE','%'.$request->date.'%');
        }
$user= Auth::user();
        $contracts = $query->select('contracts.*')->paginate(10);
        return view('contracts.index', [
            'contracts' => $contracts,
            'request'=>$request,
            'user'=>$user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('create', Contract::class);
        $productComisiones = productoscomisiones::join('products', 'products.id', '=', 'productoscomisiones.idProducto')->get();
        return view('contracts.create', [
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
            'productComisiones' => $productComisiones,
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


        $this->authorize('create', Contract::class);

        request()->validate([
            'patient_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'amount' => 'required',
            'services' => 'required|array',
            'comment' => 'required|min:5|max:250'
        ]);

        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);


        $contract = Contract::create([
            'patient_id' => $request->patient_id,
            'seller_id' => $request->seller_id,
            'user_id' => Auth::id(),
            'amount' => $amount,
            'comment' => $request->comment,
            'status' => 'sin confirmar',
            'obsequio' => $request->Obsequio1,
            'obsequioDos' => $request->Obsequio2,
            'CantidadObsequio1' => $request->CantidadObsequio1,
            'CantidadObsequio2' => $request->CantidadObsequio2,
            'anestesia' => $request->tipoAnestesia,
        ]);


        $client = Patient::find($request->patient_id);
        $string = str_random(10);
        $randPass = rand(1111,9999);
        $vectorName = explode(" ", $client->name);
        $vectorName = substr($vectorName[0],0,5);
        $token = uniqid("URL{$contract->id}{$string}");
        $signature =  new SignaturesContracts();
        $signature->contract_id = $contract->id;
        $signature->token = $token;
        $signature->link = 'https://contract.smadiaclinic.com'.'/signature/'.$token;
        $signature->user = "{$vectorName}{$contract->id}";
        $signature->password = "$randPass";
        $signature->save();

        $services = $request->services;
        $qty = $request->qty;
        $price = $request->price;
        $percent = $request->percent;
        $discount = $request->discount;
        $totaly = $request->total;
        $name = $request->name;

        $cont = 0;
        foreach ($services as $i => $s) {
            if ($s != "") {
                $total = str_replace('.','', $price[$i]);
                $total = str_replace(',','', $total);
                $discount_go = str_replace('.','', $discount[$i]);
                $discount_go = str_replace(',','', $discount_go);
                $totaly_go = str_replace('.','', $totaly[$i]);
                $totaly_go = str_replace(',','', $totaly_go);
                Item::create([
                    'contract_id' => $contract->id,
                    'service_id' => $services[$i],
                    'name' => $name[$i],
                    'qty' => $qty[$i],
                    'price' => $total,
                    'percent' => $percent[$i],
                    'discount_value' => $discount_go,
                    'total' => $totaly_go,
                ]);
                $service_info= Service::find($services[$i]);
                if($service_info->depilcare == 'SI'){
                    $cont = 1;
                }
            }
        }
        try{
            $data = ["document" => $this->PDFEmail($contract->id,$cont)];
            Mail::to($contract->patient->email)->send(new \App\Mail\Contract($data, $contract));
        }catch (\Exception $e){

        }
        //session(['menu_patient_show' => 2]);
        return response(json_encode($contract), 201)->header('Content-Type', 'text/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Contract::class);

        $detalleAdicionales = DB::select("
        SELECT * FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$id]);

        $obsequio = DB::select(
            "SELECT SUM(valor) as suma
         FROM adicional ad
        INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
        WHERE  concepto='obsequio' AND ad.id_presupuesto=? ",[$id]);

     //   $id=explode('-',$pay->contract)[1];
        $otro = DB::select(
            "SELECT SUM(valor) as suma
         FROM adicional ad
        INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
        WHERE  concepto='otro' AND ad.id_presupuesto=? ",[$id]);

        $deducible = DB::select(
            "SELECT SUM(valor) as suma
         FROM adicional ad
        INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
        WHERE  concepto='Deducible' AND ad.id_presupuesto=? ",[$id]);

        $sumaDescuento=$obsequio[0]->suma + $otro[0]->suma;


        return view('contracts.show', [
            'contract' => Contract::find($id), 'adicional'=>$detalleAdicionales,
            'descuento'=> $sumaDescuento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        $this->authorize('update', Contract::class);

        return view('contracts.edit', [
            'contract' => $contract,
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        $this->authorize('update', Contract::class);
        request()->validate([
            'seller_id' => 'required|integer',
            'amount' => 'required',
            'services' => 'required|array',
            'comment' => 'required|min:5|max:250'
        ]);

        if ($contract->status != "sin confirmar") return response(json_encode(
            ["message" => "No se puede actualizar el contracto"]), 401)
            ->header('Content-Type', 'text/json');

        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);
        $contract->update([
            'seller_id' => $request->seller_id,
            'user_id' => Auth::id(),
            'amount' => $amount,
            'comment' => $request->comment
        ]);

        $services = $request->services;
        $qty = $request->qty;
        $price = $request->price;
        $percent = $request->percent;
        $discount = $request->discount;
        $totaly = $request->total;
        $name = $request->name;

        $contract->items()->delete();

        foreach ($services as $i => $s) {
            if ($s != "") {
                $total = str_replace('.','', $price[$i]);
                $total = str_replace(',','', $total);
                $discount_go = str_replace('.','', $discount[$i]);
                $discount_go = str_replace(',','', $discount_go);
                $totaly_go = str_replace('.','', $totaly[$i]);
                $totaly_go = str_replace(',','', $totaly_go);
                Item::create([
                    'contract_id' => $contract->id,
                    'service_id' => $services[$i],
                    'name' => $name[$i],
                    'qty' => $qty[$i],
                    'price' => $total,
                    'percent' => $percent[$i],
                    'discount_value' => $discount_go,
                    'total' => $totaly_go,
                ]);
            }
        }


        /*$data = ["document" => $contract->id];
        Mail::to($contract->patient->email)->send(new \App\Mail\Contract($data, $contract));*/
        return response(json_encode($contract), 201)->header('Content-Type', 'text/json');
    }

    public function approved(Request $request)
    {
        $this->authorize('update', Contract::class);
        request()->validate([
            'id' => 'required|integer',
        ]);


        $contract = Contract::find($request->id);
        $contract->update(['status' => 'activo']);
        return response(json_encode(["message" => "Saved"]), 200)->header('Content-Type', 'text/json');

    }

    public function liquid(Request $request){
        $this->authorize('update', Contract::class);
        $contract_id = $request->input('contract_id');
        $id_patient = $request->input('contract_patient_id');
        //$service_id = $request->input('services_id');
        //$cant = $request->input('cant');
        //$patient_new_id = $request->input('patient_id');
        //$patient_old = Patient::find($id_patient);

        $amount = intval(str_replace('.','',$request->input('amount')));
        $comment = $request->input('comment');

        $contractUpdate = Contract::find($contract_id);
        $consumed = \App\Models\Consumed::where("contract_id",$contractUpdate->id)->get();
        $totalConsumed = 0;
        foreach ($consumed as $c) {
            $totalConsumed += $c->amount;
        }
        $balance = $contractUpdate->balance - $totalConsumed;

        if(number_format($amount, 0) > number_format($balance, 0)){
            return 'El valor que se desea liquidar es mayor al disponible = $'.str_replace(',','.', number_format($balance, 0));
        }
        if($amount < 0){
            return 'El valor que se desea liquidar debe ser minimo a 0';
        }
        $consumed = Consumed::create([
            'schedule_id' => '',
            'contract_id' => $contractUpdate->id,
            'amount' => $balance,
            'sessions' => '',
            'session' => ''
        ]);

        $income = Income::create([
            'patient_id' => $id_patient,
            'seller_id' => $contractUpdate->seller_id,
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
            'comment' => 'Valor enviado de liquidacion de un contrato. '.$comment,
            'type' => 'bolsa',
        ]);

        /*
        //consumido
            $incomes = \App\Models\Income::where('patient_id', $contractUpdate->patient_id)
                ->where('contract_id',$contractUpdate->id)
                ->where('status','activo')
                ->get();
            $totalIncome = 0;
            $totalConsumed = 0;
            foreach ($incomes as $i) {
                $totalIncome += $i->amount;
            }
            $consumed = \App\Models\Consumed::join('schedules', 'schedules.id', '=', 'consumed.schedule_id')
                ->select('consumed.*')
                ->where([
                    'schedules.patient_id' => $contractUpdate->patient_id,
                    'consumed.contract_id' => $contractUpdate->id
                ])->get();
            foreach ($consumed as $c) {
                $totalConsumed += $c->amount;
            }
            $balance = $totalIncome - $totalConsumed;
        //endconsumido
        */

        /*
        $service = Service::find($service_id);
        $amount = intval($service->price) * intval($cant);
        if($amount > $balance){
            return 'El valor del servicio ' . $service->name .' es mayor al saldo disponible, cambiar la cantidad o el servicio.';
        }
        */
        //return 2;

        //consumir el restante disponible

        //end consumir

        /*
        $contractNew = Contract::create([
            'patient_id' => $patient_new_id,
            'seller_id' => $contractUpdate->seller_id,
            'user_id' => Auth::id(),
            'amount' => $amount,
            'comment' => 'Es enviado por un contrato liquidado por el paciente: '.$patient_old->name.' '.$patient_old->lastname,
            'status' => 'sin confirmar'
        ]);
        Item::create([
            'contract_id' => $contractNew->id,
            'service_id' => $service_id,
            'name' => $service->name,
            'qty' => $cant,
            'price' => $amount,
            'percent' => 0,
        ]);
        */
        $contractUpdate->update([
            'status'=>'liquidado',
            'comment_liquid'=>$comment,
            'date_liquid'=>date('Y-m-d'),
            'responsable_liquid'=>Auth::id(),
            'amount_liquid'=> $amount
        ]);
        return 1;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        $this->authorize('delete', Contract::class);
        $contrat = Contract::find($id);
        $contrat->delete();
        $items = Item::where('contract_id',$id)->get();
        foreach ($items as $i){
            $delete = Item::find($i->id);
            $delete->delete();
        }
        return redirect()->route('contracts.index')
            ->with('success','Contrato eliminado exitosamente');
    }

    public function generatePDF($id)
    {
        $data = Contract::find($id);
        $pdf = $this->pdf->loadView('pdf.contract', ['data' => $data]);
        return $pdf->stream('Contrato-Smadia.pdf');
        //return view('pdf.contract');
    }

    public function generatePDF_2($id)
    {
        $data = Contract::find($id);
        $pdf = $this->pdf->loadView('pdf.contract_2', ['data' => $data]);
        return $pdf->stream('Contrato-Smadia.pdf');
        //return view('pdf.contract');
    }


    public function PDFEmail($id,$cont)
    {
        $data = Contract::find($id);
        if($cont == 0){
            $pdf = $this->pdf->loadView('pdf.contract', ['data' => $data]);
        }else{
            $pdf = $this->pdf->loadView('pdf.contract_2', ['data' => $data]);
        }
        return $pdf->output();
        //return view('pdf.contract');
    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end")
        ];
        return Excel::download(new ContractsExport($data), 'Contratos.xlsx');
    }

    public function receivable()
    {
        $accounts =
            Contract::whereRaw('balance <> amount')
                ->orderByDesc('contracts.created_at')->get();
        return view('accounts-receivable.index', ['accounts' => $accounts]);
    }
}
