<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cellar;
use App\Models\ConsumptionOutput;
use App\Models\ConsumptionOutputObservation;
use App\Models\InventoryAdjustment;
use App\Models\InventoryAdjustmentObservation;
use App\Models\PersonalInventoryObservations;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumptionOutputController extends Controller
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
        $this->authorize('view', ConsumptionOutput::class);
        /*
        $products = PurchaseProduct::with('product', 'cellar', 'product.presentation', 'product.category')
            ->selectRaw('*, qty_inventory as cant, purchase_products.id as pp_id')
            ->orderBy('expiration')->get();
        $productList= Product::where('status','activo')
            ->orderBy('name','asc')
            ->get();
        */
        $consumption = ConsumptionOutput::orderBy('id','desc')->get();
        return view('consumption-output.index', [
            //'products'=>$products,
            //'productList'=>$productList
            'consumption'=>$consumption
        ]);
    }

    public function create()
    {
        $this->authorize('create', ConsumptionOutput::class);

        return view('consumption-output.create', [
            'products' => Product::all(),
            'cellars' => Cellar::where('status', 'activo')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', ConsumptionOutput::class);
        request()->validate([
            'observations' => 'required',
            'products' => 'required|array',
            'qty' => 'required',
        ]);
        $products = $request->products;
        $purchase_product_id = $request->purchase_product_id;
        $qty = $request->qty;
        //dd($qty);
        //return false;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                if ($qty[$i] > $purchaseP->qty_inventory) {
                    return redirect()->route('consumption-output.create')
                        ->with('error', 'La cantidad a salida no esta disponible en el lote '
                            . $purchaseP->lote .
                            ' en el producto ' . $purchaseP->product->name .
                            ' la cantidad disponible es ' . $purchaseP->qty_inventory);
                }
            }
        }

        $consumption = ConsumptionOutput::create([
           'user_id'=>Auth::id(),
           //'approved_id'=>Auth::id(),
           'cellar_id'=>$request->cellar_id,
           'observations'=>$request->observations,
           'status'=>'creada',
        ]);
        foreach ($products as $i => $p) {
            if ($p != "") {
                $id = $purchase_product_id[$i];
                $qty_save = $qty[$i];
                $purchaseP= PurchaseProduct::find($id);
                //$cantidad = $purchaseP->qty_inventory - $qty_save;
                //if($cantidad < 0 ){
                    //$cantidad = 0;
                //}
                //$purchaseP->qty_inventory = $cantidad;
                //if($purchaseP->save()){
                    setlocale(LC_ALL,"es_CO");
                    ini_set('date.timezone','America/Bogota');
                    date_default_timezone_set('America/Bogota');
                    $todayh = getdate();
                    $d = date("d");
                    $m = date("m");
                    $y = $todayh['year'];
                    $date = $y.'-'.$m.'-'.$d;
                    $ConsumptionOutput = ConsumptionOutputObservation::create([
                        'user_id'=> Auth::id(),
                        'consumption_output_id'=>$consumption->id,
                        'purchase_product_id'=>$purchaseP->id,
                        'product_id'=>$purchaseP->product_id,
                        'observations'=>$request->observations,
                        'date'=>$date,
                        'qty'=>$qty_save,
                        'lost'=>$purchaseP->price * $qty_save,
                    ]);
                //}
            }
        }
        //finalizo
        return redirect()->route('consumption-output.index')
            ->with('success','Salida por consumo creada exitosamente.');
    }

    public function adjustment(Request $request)
    {
        $this->authorize('update', ConsumptionOutput::class);
        try {
            if ($request->isMethod('post')) {
                $id = $request->product_id;
                $qty = $request->product_qty;
                $purchaseP= PurchaseProduct::find($id);

                if($qty > $purchaseP->qty_inventory){
                    return 'La cantidad a ajustar es mayor a la actual: '.$purchaseP->qty_inventory;
                }
                $cantidad = $purchaseP->qty_inventory - $qty;

                if($cantidad < 0 ){
                    $cantidad = 0;
                }
                $purchaseP->qty_inventory = $cantidad;
                if($purchaseP->save()){
                    setlocale(LC_ALL,"es_CO");
                    ini_set('date.timezone','America/Bogota');
                    date_default_timezone_set('America/Bogota');
                    $todayh = getdate();
                    $d = date("d");
                    $m = date("m");
                    $y = $todayh['year'];
                    $date = $y.'-'.$m.'-'.$d;
                    $ConsumptionOutput = ConsumptionOutputObservation::create([
                        'user_id'=> Auth::id(),
                        'product_id'=>$purchaseP->product_id,
                        'observations'=>$request->observations,
                        'date'=>$date,
                        'qty'=>$qty,
                        'lost'=>$purchaseP->price * $qty,
                    ]);
                    return 1;
                }
                return 'error';
            }else{
                return 'error';
            }
        } catch (Exception $e) {
            return " Error: " . $e->getMessage();
        }
    }

    public function show($id)
    {
        $consumption = ConsumptionOutput::find($id);
        $consumptionList = ConsumptionOutputObservation::where('consumption_output_id',$id)->get();
        return view('consumption-output.show', [
            'consumption'=>$consumption,
            'consumptionList'=>$consumptionList,
        ]);
    }

    public function anulate(Request $request)
    {
        $id = $request->id;
        $consumption = ConsumptionOutput::find($id);
        $consumption->approved_id = Auth::id();
        $consumption->status = 'anulada';
        $consumption->motivo = $request->motivo;
        $consumption->update();
        $consumptionList = ConsumptionOutputObservation::where('consumption_output_id',$id)->get();
        //foreach ($consumptionList as $c){
            //$productP = PurchaseProduct::find($c->purchase_product_id);
            //$productP->qty_inventory = $productP->qty_inventory + $c->qty;
            //$productP->update();
        //}
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }

    public function doStatus($id)
    {
        $this->authorize('update', ConsumptionOutput::class);
        $consumption = ConsumptionOutput::find($id);
        if($consumption->status == 'aprobada' || $consumption->status == 'anulada'){
            return redirect()->route('consumption-output.show',$id);
        }

        $consumptionList = ConsumptionOutputObservation::where('consumption_output_id',$id)->get();
        foreach ($consumptionList as $c) {
            $purchaseP = PurchaseProduct::find($c->purchase_product_id);
            if ($c->qty > $purchaseP->qty_inventory) {
                return redirect()->route('consumption-output.show',$id)
                    ->with('error', 'Error al aprobar - La cantidad a salida no esta disponible en el lote '
                        . $purchaseP->lote .
                        ' en el producto ' . $purchaseP->product->name .
                        ' la cantidad disponible es ' . $purchaseP->qty_inventory);
            }
        }

        $consumption->approved_id = Auth::id();
        $consumption->status = 'aprobada';
        $consumption->save();

        foreach ($consumptionList as $c){
            $productP = PurchaseProduct::find($c->purchase_product_id);
            $qty_save = $c->qty;
            $cantidad = $productP->qty_inventory - $qty_save;
            if($cantidad < 0 ){
                $cantidad = 0;
            }
            $productP->qty_inventory = $cantidad;
            $productP->update();
        }
        return redirect()->route('consumption-output.show',$id);
    }

    public function show_products($id)
    {
        $this->authorize('view', ConsumptionOutput::class);
        $producto = Product::find($id);
        $historial = ConsumptionOutputObservation::where('product_id',$id)->orderBy('id','asc')->get();
        $purchase = \App\Models\PurchaseProduct::where('product_id',$producto->id)
            ->where('inventory','si')
            ->get();
        $personalInventory = \App\Models\PersonalInventory::where('product_id',$producto->id)
            ->get();
        $pCount=0;
        $qty_inventary = 0;
        $qty=0;
        foreach($personalInventory as $p_2){
            $pCount = $pCount + $p_2->qty;
        }
        foreach($purchase as $p) {
            $qty_inventary = $qty_inventary + intval($p->qty_inventory);
            $qty = $qty_inventary + intval($pCount);
        }
        return view('consumption-output.show', [
            'producto'=>$producto,
            'historial'=>$historial,
            'qty_inventary'=>$qty_inventary
        ]);
    }

}
