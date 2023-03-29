<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExpensesSheet;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PersonalInventory;
use App\Models\Product;
use App\Models\Provider;
use App\Models\PurchaseProduct;
use App\Models\RelationExpensesSheet;
use App\Models\TransferWineryObservations;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpensesSheetController extends Controller
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
        $this->authorize('view', ExpensesSheet::class);
        $patient = session()->get('patient');
        $idBefore = ExpensesSheet::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationExpensesSheet::where('expenses_sheet_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $products = Product::where('inventory_id',56)
            ->where('status','activo')
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
        return view('expenses-sheet.index', [
            'products' => $products,
            'inventory'=>$inventory,
            'idBefore'=>$idBefore,
            'relation'=>$relation,
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
        $this->authorize('create', ExpensesSheet::class);
        request()->validate([
            'product' => 'required|array',
            'observations' => 'required|string|max:500',
        ]);

        /*
         PRUEBA DE FUNCIONABILIDAD ======
        $pProduct = PurchaseProduct::where('cellar_id',2)
            ->where('product_id',11)
            ->where('inventory','si')
            ->orderBy('qty_inventory','desc')
            ->get();
        $finish = 1;
        $cant = 11;
        $cant_rest = 0;
        foreach ($pProduct as $key => $o){
            if($finish == 1){
                $update = PurchaseProduct::find($o->id);
                $o_totaly = $o->qty_inventory;
                if($key == 0){
                    $cant_rest = $cant - $o_totaly;
                    $older = $cant;
                }else{
                    $older = $cant_rest;
                    $cant_rest = $cant_rest - $o_totaly;
                }
                if($cant_rest >= 0){
                    $update->qty_inventory = 0;
                }else{
                    $update->qty_inventory = $update->qty_inventory - $older;
                    $finish = 0;
                }
                if($key == 0) {
                    dd($update->qty_inventory);
                }
                //$update->update();
            }
        }
        dd($pProduct);
        ENDING PRUEBA DE FUNCIONABILIDAD ======
        */

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
                    $pInventory =  TransferWineryObservations::join('transfer_to_winery','transfer_to_winery_observations.transfer_to_winery_id','=','transfer_to_winery.id')
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
                }else{
                    $pInventory = PersonalInventory::where('user_id', $id->id)
                        ->where('product_id', $products[$i])
                        ->first();
                    if ($qty[$i] > $pInventory->qty) {
                        $product = Product::find($products[$i]);
                        return redirect()->route('expenses-sheet.show', $request->patient_id)
                            ->with('error', 'La cantidad a agregar no esta disponible en el producto '
                                . $product->name .
                                ' la cantidad disponible es ' . $pInventory->qty);
                    }
                }
            }
        }
        //dd('entro');
        //return false;

        $ExpensesSheet = new ExpensesSheet();
        $patient = Patient::find($request->patient_id);
        $observations = $request->input('observations');
        $ExpensesSheet->user_id = $id->id;
        $ExpensesSheet->patient_id = $patient->id;
        $ExpensesSheet->observations = $observations;
        $ExpensesSheet->save();

        $user = User::find(Auth::id());
        foreach ($products as $i => $p) {
            if ($p != "" && $qty[$i] > 0 && $qty[$i] != "") {
                $RelationExpensesSheet = new RelationExpensesSheet();
                $expenses_sheet_id = $ExpensesSheet->id;
                $product_info = Product::find($products[$i]);
                $RelationExpensesSheet->create([
                    'expenses_sheet_id' =>$expenses_sheet_id,
                    'code' =>$product_info->reference,
                    'product' => $product_info->name,
                    //'lote' =>$product_info->reference,
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
                }else{
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
                $RelationExpensesSheet = new RelationExpensesSheet();
                $expenses_sheet_id = $ExpensesSheet->id;
                $code = $request->input('code'.$i);
                $product = $request->input('product'.$i);
                $lote = $request->input('lote'.$i);
                $presentation = $request->input('presentation'.$i);
                $medid = $request->input('medid'.$i);
                $cant =  $request->input('cant'.$i);
                $RelationExpensesSheet->create([
                    'expenses_sheet_id' =>$expenses_sheet_id,
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
            'id_type'=>13,
            'id_relation'=>$ExpensesSheet->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('expenses-sheet.show',$request->patient_id)
            ->with('success','Hoja de Gastos creada exitosamente.');
    }

    public function edit(ExpensesSheet $ExpensesSheet)
    {
        return redirect('/');
        $this->authorize('update', ExpensesSheet::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = ExpensesSheet::find($id[2]);
        $relation = RelationExpensesSheet::where('expenses_sheet_id',$value->id)->get();
        $products = Product::where('inventory_id',56)
            ->where('status','activo')
            ->get();
        return view('expenses-sheet.show',[
            'value'=>$value,
            'products'=>$products,
            'relation'=>$relation,
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
    public function update(Request $request, ExpensesSheet $ExpensesSheet)
    {
        $this->authorize('update', ExpensesSheet::class);
        request()->validate([
            'observations' => 'required|string|max:500',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $ExpensesSheet = ExpensesSheet::find($id[2]);
        $ExpensesSheet->update($request->all());
        $expenses_sheet_id = $ExpensesSheet->id;

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        for($i = 0; $i < count($vector); ++$i){
            $code = $request->input('code'.$i);
            $product = $request->input('product'.$i);
            $lote = $request->input('lote'.$i);
            $presentation = $request->input('presentation'.$i);
            $medid = $request->input('medid'.$i);
            $cant =  $request->input('cant'.$i);
            if($vector[$i] == 'new'){
                $RelationExpensesSheet = new RelationExpensesSheet();
                $RelationExpensesSheet->create([
                    'expenses_sheet_id' =>$expenses_sheet_id,
                    'code' =>$code,
                    'product' => $product,
                    'lote' =>$lote,
                    'presentation' =>$presentation,
                    'medid' => $medid,
                    'cant' => $cant,
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel =  $request->input('id_rel'.$i);
                $RelationExpensesSheet = RelationExpensesSheet::find($id_rel);
                $RelationExpensesSheet->update([
                    'code' =>$code,
                    'product' => $product,
                    'lote' =>$lote,
                    'presentation' =>$presentation,
                    'medid' => $medid,
                    'cant' => $cant,
                ]);
            }
        }

        return redirect()->route('expenses-sheet.edit',$id[2])
            ->with('success','Hoja de Gasto actualizada exitosamente.');
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
