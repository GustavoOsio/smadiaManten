<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PersonalInventory;
use App\Models\Product;
use App\Models\Provider;
use App\Models\PurchaseProduct;
use App\Models\RelationSurgeryExpensesSheet;
use App\Models\SurgeryExpensesSheet;
use App\Models\TransferWineryObservations;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurgeryExpensesSheetController extends Controller
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

    public function show($id)
    {
        $this->authorize('view', SurgeryExpensesSheet::class);
        $patient = session()->get('patient');
        $idBefore = SurgeryExpensesSheet::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationSurgeryExpensesSheet::where('surgery_expenses_sheet_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $products = Product::where('inventory_id',56)
            ->where('status','activo')
            ->get();
        $surgery = User::where('status','activo')
            ->where('role_id',2)
            ->orderBy('name','asc')
            ->get();
        $assistant= User::where('status','activo')
            ->where('role_id',7)
            ->orderBy('name','asc')
            ->get();
        $anesthesiologist = User::where('status','activo')
            ->where('role_id',8)
            ->orderBy('name','asc')
            ->get();
        $rotary = User::where('status','activo')
            ->where('role_id',9)
            ->orderBy('name','asc')
            ->get();
        $instrument= User::where('status','activo')
            ->where('role_id',10)
            ->orderBy('name','asc')
            ->get();
        $id_user_validate = Auth::id();
        //$id_user_validate = 3;
        $user = User::find(Auth::id());
        if($user->cellar_id == 2){
            $inventory = TransferWineryObservations::join('transfer_to_winery','transfer_to_winery_observations.transfer_to_winery_id','=','transfer_to_winery.id')
                ->where('transfer_to_winery.cellar_id',2)
                ->where('transfer_to_winery.status','aprobada')
                ->select('transfer_to_winery_observations.*',DB::raw('SUM(transfer_to_winery_observations.qty_falt) as cant'))
                ->groupBy('transfer_to_winery_observations.product_id')
                ->get();
        }else{
            $inventory = PersonalInventory::where('user_id',$id_user_validate)->select('personal_inventory.*','qty as cant')->get();
        }
        return view('surgery-expenses-sheet.index', [
            'products' => $products,
            'idBefore'=>$idBefore,
            'relation'=>$relation,
            'surgery'=>$surgery,
            'assistant'=>$assistant,
            'anesthesiologist'=>$anesthesiologist,
            'rotary'=>$rotary,
            'instrument'=>$instrument,
            'inventory'=>$inventory,
            'patient_id'=>$id
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
        $this->authorize('create', SurgeryExpensesSheet::class);
        request()->validate([
            'date_of_surgery' => 'required|string|min:1|max:100',
            'room' => 'required|string|min:1|max:100',
            'weight' => 'required|string|min:1|max:100',
            'type_patient' => 'required|string|min:1|max:100',
            'type_anesthesia' => 'required|string|min:1|max:100',
            'type_surgery' => 'required|string|min:1|max:100',
            'surgery' => 'required|string|min:1|max:100',
            //'surgery_code' => 'required|string|min:1|max:100',
            'time_entry' => 'required|string|min:1|max:100',
            'start_time_surgery' => 'required|string|min:1|max:100',
            'end_time_surgery' => 'required|string|min:1|max:100',
            'surgeon' => 'required|string|min:1|max:100',
            //'assistant' => 'required|string|min:1|max:100',
            //'anesthesiologist' => 'required|string|min:1|max:100',
            //'rotary' => 'required|string|min:1|max:100',
            //'instrument' => 'required|string|min:1|max:100',
            'product' => 'required|array',
        ]);
        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $id = User::find(Auth::id());
        //$id = User::find(3);
        $products = $request->product;
        $qty = $request->cant;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $user = User::find(Auth::id());
                if($user->cellar_id == 2) {
                    $pInventory = TransferWineryObservations::join('transfer_to_winery','transfer_to_winery_observations.transfer_to_winery_id','=','transfer_to_winery.id')
                        ->where('transfer_to_winery.cellar_id',2)
                        ->where('transfer_to_winery.status','aprobada')
                        ->where('transfer_to_winery_observations.product_id',$products[$i])
                        ->select('transfer_to_winery_observations.*',DB::raw('SUM(transfer_to_winery_observations.qty_falt) as cant'))
                        ->groupBy('transfer_to_winery_observations.product_id')
                        ->get();
                    if ($qty[$i] > $pInventory[0]->cant) {
                        $product = Product::find($products[$i]);
                        return redirect()->route('expenses-sheet.show', $request->patient_id)
                            ->with('error', 'La cantidad a agregar no esta disponible en el producto '
                                . $product->name .
                                ' la cantidad disponible es ' . $pInventory[0]->cant);
                    }
                } else {
                    $pInventory = PersonalInventory::where('user_id', $id->id)
                        ->where('product_id', $products[$i])
                        ->first();
                    if ($qty[$i] > $pInventory->qty) {
                        return redirect()->route('surgery-expenses-sheet.index')
                            ->with('error', 'La cantidad a agregar no esta disponible en el producto '
                                . $pInventory->product->name .
                                ' la cantidad disponible es ' . $pInventory->qty);
                    }
                }
            }
        }
        $SurgeryExpensesSheet =  SurgeryExpensesSheet::create($request->all());
        $patient = Patient::find($request->patient_id);

        $SurgeryExpensesSheet->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
        ]);
        $user = User::find(Auth::id());
        foreach ($products as $i => $p) {
            if ($p != "" && $qty[$i] > 0 && $qty[$i] != "") {
                $RelationSurgeryExpensesSheet = new RelationSurgeryExpensesSheet();
                $surgery_expenses_sheet_id = $SurgeryExpensesSheet->id;
                $product_info = Product::find($products[$i]);
                $RelationSurgeryExpensesSheet->create([
                    'surgery_expenses_sheet_id' =>$surgery_expenses_sheet_id,
                    'code' =>$product_info->reference,
                    'product' => $product_info->name,
                    //'lote' =>$lote,
                    //'presentation' =>$presentation,
                    //'medid' => $medid,
                    'cant' => $qty[$i],
                ]);
                if($user->cellar_id == 2) {
                    $pProduct =  TransferWineryObservations::join('transfer_to_winery','transfer_to_winery_observations.transfer_to_winery_id','=','transfer_to_winery.id')
                        ->where('transfer_to_winery.cellar_id',2)
                        ->where('transfer_to_winery.status','aprobada')
                        ->where('transfer_to_winery_observations.product_id',$products[$i])
                        ->orderBy('transfer_to_winery_observations.qty_falt','desc')
                        ->get();
                    $finish = 1;
                    $cant = $qty[$i];
                    $cant_rest = 0;
                    foreach ($pProduct as $key => $o){
                        if($finish == 1){
                            $update = TransferWineryObservations::find($o->id);
                            $o_totaly = $o->qty_falt;
                            if($key == 0){
                                $cant_rest = $cant - $o_totaly;
                                $older = $cant;
                            }else{
                                $older = $cant_rest;
                                $cant_rest = $cant_rest - $o_totaly;
                            }
                            if($cant_rest >= 0){
                                $update->qty_falt = 0;
                            }else{
                                $update->qty_falt = $update->qty_falt - $older;
                                $finish = 0;
                            }
                            $update->update();
                        }
                    }
                }else {
                    $pInventory = PersonalInventory::where('user_id', $id->id)
                        ->where('product_id', $products[$i])
                        ->first();
                    $pInventory->qty = $pInventory->qty - $qty[$i];
                    $pInventory->save();
                }
            }
        }
        /*
        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationSurgeryExpensesSheet = new RelationSurgeryExpensesSheet();
                $surgery_expenses_sheet_id = $SurgeryExpensesSheet->id;
                $code = $request->input('code'.$i);
                $product = $request->input('product'.$i);
                $lote = $request->input('lote'.$i);
                $presentation = $request->input('presentation'.$i);
                $medid = $request->input('medid'.$i);
                $cant =  $request->input('cant'.$i);
                $RelationSurgeryExpensesSheet->create([
                    'surgery_expenses_sheet_id' =>$surgery_expenses_sheet_id,
                    'code' =>$code,
                    'product' => $product,
                    'lote' =>$lote,
                    'presentation' =>$presentation,
                    'medid' => $medid,
                    'cant' => $cant,
                ]);
            }
        }
        */
        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $todayh = getdate();
        $d = date("d");
        $m = date("m");
        $y = $todayh['year'];
        $date = $d.'/'.$m.'/'.$y;
        $medicalHistory = MedicalHistory::create([
            'user_id'=> $id->id,
            'id_type'=>14,
            'id_relation'=>$SurgeryExpensesSheet->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);
        return redirect()->route('surgery-expenses-sheet.show',$request->patient_id)
            ->with('success','Hoja de Gastos de Cirugía creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function show($id)
    {
        $this->authorize('view', Product::class);
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SurgeryExpensesSheet $SurgeryExpensesSheet)
    {
        return redirect('/');
        $this->authorize('update', SurgeryExpensesSheet::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = SurgeryExpensesSheet::find($id[2]);
        $relation = RelationSurgeryExpensesSheet::where('surgery_expenses_sheet_id',$value->id)->get();
        $products = Product::where('inventory_id',56)
            ->where('status','activo')
            ->get();
        $surgery = User::where('status','activo')
            ->where('role_id',2)
            ->orderBy('name','asc')
            ->get();
        $assistant= User::where('status','activo')
            ->where('role_id',7)
            ->orderBy('name','asc')
            ->get();
        $anesthesiologist = User::where('status','activo')
            ->where('role_id',8)
            ->orderBy('name','asc')
            ->get();
        $rotary = User::where('status','activo')
            ->where('role_id',9)
            ->orderBy('name','asc')
            ->get();
        $instrument= User::where('status','activo')
            ->where('role_id',10)
            ->orderBy('name','asc')
            ->get();
        return view('surgery-expenses-sheet.show',[
            'value'=>$value,
            'relation'=>$relation,
            'products' => $products,
            'surgery'=>$surgery,
            'assistant'=>$assistant,
            'anesthesiologist'=>$anesthesiologist,
            'rotary'=>$rotary,
            'instrument'=>$instrument,
            'patient_id'=>$value->patient_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurgeryExpensesSheet $SurgeryExpensesSheet)
    {
        $this->authorize('update', SurgeryExpensesSheet::class);
        request()->validate([
            'date_of_surgery' => 'required|string|min:1|max:100',
            'room' => 'required|string|min:1|max:100',
            'weight' => 'required|string|min:1|max:100',
            'type_patient' => 'required|string|min:1|max:100',
            'type_anesthesia' => 'required|string|min:1|max:100',
            'type_surgery' => 'required|string|min:1|max:100',
            'surgery' => 'required|string|min:1|max:100',
            'surgery_code' => 'required|string|min:1|max:100',
            'time_entry' => 'required|string|min:1|max:100',
            'start_time_surgery' => 'required|string|min:1|max:100',
            'end_time_surgery' => 'required|string|min:1|max:100',
            'surgeon' => 'required|string|min:1|max:100',
            //'assistant' => 'required|string|min:1|max:100',
            //'anesthesiologist' => 'required|string|min:1|max:100',
            //'rotary' => 'required|string|min:1|max:100',
            //'instrument' => 'required|string|min:1|max:100',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $SurgeryExpensesSheet = SurgeryExpensesSheet::find($id[2]);
        $SurgeryExpensesSheet->update($request->all());

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        $surgery_expenses_sheet_id = $SurgeryExpensesSheet->id;
        for($i = 0; $i < count($vector); ++$i){
            $code = $request->input('code'.$i);
            $product = $request->input('product'.$i);
            $lote = $request->input('lote'.$i);
            $presentation = $request->input('presentation'.$i);
            $medid = $request->input('medid'.$i);
            $cant =  $request->input('cant'.$i);
            if($vector[$i] == 'new'){
                $RelationSurgeryExpensesSheet = new RelationSurgeryExpensesSheet();
                $RelationSurgeryExpensesSheet->create([
                    'surgery_expenses_sheet_id' =>$surgery_expenses_sheet_id,
                    'code' =>$code,
                    'product' => $product,
                    'lote' =>$lote,
                    'presentation' =>$presentation,
                    'medid' => $medid,
                    'cant' => $cant,
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel = $request->input('id_rel'.$i);
                $RelationSurgeryExpensesSheet = RelationSurgeryExpensesSheet::find($id_rel);
                $RelationSurgeryExpensesSheet->update([
                    'code' =>$code,
                    'product' => $product,
                    'lote' =>$lote,
                    'presentation' =>$presentation,
                    'medid' => $medid,
                    'cant' => $cant,
                ]);
            }
        }

        return redirect()->route('surgery-expenses-sheet.edit',$id[2])
            ->with('success','Hoja de Gastos de Cirugía actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', Product::class);
        $product->delete();
        return redirect()->route('products.index')
            ->with('success','Producto eliminado exitosamente');
    }
}
