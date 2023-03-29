<?php

namespace App\Http\Controllers;

use App\Exports\BudgetsExport;
use App\Models\ContactSource;
use App\Models\Budget;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Item;
use App\Models\Patient;
use App\Models\Service;
use App\Models\State;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
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

    public function index()
    {




        $this->authorize('view', Budget::class);
        $budgets = Budget::orderByDesc('created_at')->take(400)->get();
        $user = Auth::user();

        $detalleAdicionales = DB::select("
        SELECT id,id_presupuesto, concepto, valor, comentario FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$budgets]);

        return view('budgets.index', [
            'budgets' => $budgets,
            'user'=>$user,
            'adicional'=>$detalleAdicionales
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('create', Budget::class);
        return view('budgets.create', [
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
        $this->authorize('create', Budget::class);

        request()->validate([
            'patient_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'amount' => 'required',
            'services' => 'required|array',
            'date_expiration' => 'required|date',
        ]);
        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);

        $amount_all = 0;
        $services = $request->services;
        $totaly = $request->total;
        foreach ($services as $i => $s) {
            if ($s != "") {
                $totaly_go = str_replace('.','', $totaly[$i]);
                $totaly_go = str_replace(',','', $totaly_go);
                $amount_all = $amount_all + intval($totaly_go);
            }
        }
        $budget = Budget::create([
            'patient_id' => $request->patient_id,
            'seller_id' => $request->seller_id,
            'user_id' => Auth::id(),
            'amount' => $amount_all,
            'comment' => $request->comment,
            'additional' => $request->additional,
            'date_expiration' => $request->date_expiration,
        ]);

        $qty = $request->qty;
        $price = $request->price;
        $percent = $request->percent;
        $discount = $request->discount;
        $name = $request->name;

        foreach ($services as $i => $s) {
            if ($s != "") {
                $total = str_replace('.','', $price[$i]);
                $total = str_replace(',','', $total);
                $discount_go = str_replace('.','', $discount[$i]);
                $discount_go = str_replace(',','', $discount_go);
                $totaly_go = str_replace('.','', $totaly[$i]);
                $totaly_go = str_replace(',','', $totaly_go);
                Item::create([
                    'budget_id' => $budget->id,
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

        try{
            $data = ["document" => $this->PDFEmail($budget->id)];
            Mail::to($budget->patient->email)->send(new \App\Mail\Budget($data, $budget));
        }catch (\Exception $e){

        }
        session(['menu_patient_show' => 3]);
        return response(json_encode($budget), 201)->header('Content-Type', 'text/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $detalleAdicionales = DB::select("
        SELECT id,id_presupuesto, concepto, valor, comentario FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$id]);

        $this->authorize('view', Budget::class);
        return view('budgets.show', [
            'budget' => Budget::find($id),
            'adicional'=>$detalleAdicionales
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        $this->authorize('update', Budget::class);


        $detalleAdicionales = DB::select("
        SELECT id,id_presupuesto, concepto, valor, comentario FROM adicional WHERE id_presupuesto= ? ORDER BY id DESC  ",[$budget->id]);


        $obsequio = DB::select(
            "SELECT SUM(valor) as suma
         FROM adicional ad
        INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
        WHERE  concepto='obsequio' AND ad.id_presupuesto=? ",[$budget->id]);

     //   $id=explode('-',$pay->contract)[1];
        $otro = DB::select(
            "SELECT SUM(valor) as suma
         FROM adicional ad
        INNER JOIN schedules sh ON sh.contract_id=ad.id_presupuesto
        WHERE  concepto='otro' AND ad.id_presupuesto=? ",[$budget->id]);

        $sumaDescuento=$obsequio[0]->suma + $otro[0]->suma;

        return view('budgets.edit', [
            'budget' => $budget,
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
            'adicional'=>$detalleAdicionales,
            'descuento'=>$sumaDescuento
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', Budget::class);

        request()->validate([
            'seller_id' => 'required|integer',
            'amount' => 'required',
            'services' => 'required|array',
            'comment' => 'required|min:5|max:250',
            //'additional' => 'required|min:5|max:250',
            'date_expiration' => 'required|date',
        ]);

        if ($budget->status != "activo"){
            return response(json_encode(
                ["message" => "No se puede actualizar el presupuesto"]), 401)
                ->header('Content-Type', 'text/json');
        }

        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);

        $amount_all = 0;
        $services = $request->services;
        $totaly = $request->total;
        foreach ($services as $i => $s) {
            if ($s != "") {
                $totaly_go = str_replace('.','', $totaly[$i]);
                $totaly_go = str_replace(',','', $totaly_go);
                $amount_all = $amount_all + intval($totaly_go);
            }
        }

        $budget->update([
            'seller_id' => $request->seller_id,
            'user_id' => Auth::id(),
            'amount' => $amount_all,
            'comment' => $request->comment,
            'additional' => $request->additional,
            'date_expiration' => $request->date_expiration,
        ]);

        $qty = $request->qty;
        $price = $request->price;
        $percent = $request->percent;
        $discount = $request->discount;
        $name = $request->name;

        $budget->items()->delete();

        foreach ($services as $i => $s) {
            if ($s != "") {
                $total = str_replace('.','', $price[$i]);
                $total = str_replace(',','', $total);
                $discount_go = str_replace('.','', $discount[$i]);
                $discount_go = str_replace(',','', $discount_go);
                $totaly_go = str_replace('.','', $totaly[$i]);
                $totaly_go = str_replace(',','', $totaly_go);
                Item::create([
                    'budget_id' => $budget->id,
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

        $data = ["document" => $this->PDFEmail($budget->id)];
        Mail::to($budget->patient->email)->send(new \App\Mail\Budget($data, $budget));
        return response(json_encode($budget), 201)->header('Content-Type', 'text/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patien)
    {
        $this->authorize('delete', Budget::class);
        $patien->delete();
        return redirect()->route('budgets.index')
            ->with('success','Paciente eliminado exitosamente');
    }

    public function generatePDF($id)

    {
        $data = Budget::find($id);
        $pdf = $this->pdf->loadView('pdf.budget', ['data' => $data]);
        return $pdf->stream('Presupuesto-Smadia.pdf');

    }

    public function PDFEmail($id)

    {
        $data = Budget::find($id);
        $pdf = $this->pdf->loadView('pdf.budget', ['data' => $data]);
        return $pdf->output();
    }

    public function convert(Request $request)
    {
        $this->authorize('update', Budget::class);
        request()->validate([
            'id' => 'required|integer',
        ]);

        $budget = Budget::find($request->id);
        $budget->update(['status' => 'contrato']);
        $amount = 0;
        foreach ($budget->items as $s) {
            $amount = $amount + $s->total;
        }
        $contract = Contract::create([
            'patient_id' => $budget->patient_id,
            'seller_id' => $budget->seller_id,
            'user_id' => Auth::id(),
            'amount' => $amount,
            'comment' => $budget->comment,
            'status' => 'sin confirmar'
        ]);
        foreach ($budget->items as $s) {
            $s->update(['contract_id' => $contract->id]);
        }
        return response(json_encode(["message" => $contract->id]), 200)->header('Content-Type', 'text/json');

    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end")
        ];
        return Excel::download(new BudgetsExport($data), 'Presupuestos.xlsx');
    }
}
