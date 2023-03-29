<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InventoryAdjustment;
use App\Models\InventoryAdjustmentObservation;
use App\Models\PersonalInventoryObservations;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryAdjustmentController extends Controller
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
        $this->authorize('view', InventoryAdjustment::class);
        /*
        $products = PurchaseProduct::with('product', 'cellar', 'product.presentation', 'product.category')
            ->selectRaw('*, qty_inventory as cant, purchase_products.id as pp_id')
            ->orderBy('expiration')->get();
        */
        $productList= Product::where('status','activo')
            ->orderBy('name','asc')
            ->get();
        $inventory = InventoryAdjustment::orderBy('id','desc')->get();
        return view('inventory-adjustment.index', [
            //'products'=>$products,
            'productList'=>$productList,
            'inventory'=>$inventory
        ]);
    }

    public function create()
    {
        $this->authorize('create', InventoryAdjustment::class);
        return view('inventory-adjustment.create', [
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', InventoryAdjustment::class);
        request()->validate([
            'observations' => 'required',
            'products' => 'required|array',
            'qty' => 'required',
            'type' => 'required',
        ]);
        $products = $request->products;
        $purchase_product_id = $request->purchase_product_id;
        $qty = $request->qty;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                if($request->type == 'rest'){
                    if ($qty[$i] > $purchaseP->qty_inventory) {
                        return redirect()->route('inventory-adjustment.create')
                            ->with('error', 'La cantidad a ajustar no esta disponible en el lote '
                                . $purchaseP->lote .
                                ' en el producto ' . $purchaseP->product->name .
                                ' la cantidad disponible es ' . $purchaseP->qty_inventory);
                    }
                }
            }
        }

        $inventory = InventoryAdjustment::create([
            'user_id'=>Auth::id(),
            //'approved_id'=>Auth::id(),
            'type'=>$request->type,
            'observations'=>$request->observations,
            'status'=>'creada',
        ]);
        $cantidad = 0;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $id = $purchase_product_id[$i];
                $qty_save = $qty[$i];
                $purchaseP= PurchaseProduct::find($id);
                if($request->type == 'rest'){
                    $cantidad = $purchaseP->qty_inventory - $qty_save;
                }else{
                    $cantidad = $purchaseP->qty_inventory + $qty_save;
                }
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
                    $inventoryObservation = InventoryAdjustmentObservation::create([
                        'user_id'=> Auth::id(),
                        'inventory_adjustment_id'=>$inventory->id,
                        'purchase_product_id'=>$purchaseP->id,
                        'product_id'=>$purchaseP->product_id,
                        'observations'=>$request->observations,
                        'date'=>$date,
                        'qty'=>$qty_save,
                        'type'=>$request->type=='rest'?'Quitar':'Agregar',
                        'lost'=>$purchaseP->price * $qty_save,
                    ]);
                }
            }
        }
        //finalizo
        return redirect()->route('inventory-adjustment.index')
            ->with('success','Ajuste de Inventario creado exitosamente.');
    }

    public function show($id)
    {
        $inventory = InventoryAdjustment::find($id);
        $inventoryList = InventoryAdjustmentObservation::where('inventory_adjustment_id',$id)->get();
        return view('inventory-adjustment.show', [
            'inventory'=>$inventory,
            'inventoryList'=>$inventoryList,
        ]);
    }

    public function anulate(Request $request)
    {
        $id = $request->id;
        $inventory = InventoryAdjustment::find($id);
        $inventory->approved_id = Auth::id();
        $inventory->status = 'anulada';
        $inventory->motivo = $request->motivo;
        $inventory->update();
        $inventoryList = InventoryAdjustmentObservation::where('inventory_adjustment_id',$id)->get();
        foreach ($inventoryList as $c){
            $productP = PurchaseProduct::find($c->purchase_product_id);
            if($inventory->type == 'rest'){
                $productP->qty_inventory = $productP->qty_inventory + $c->qty;
            }else{
                $productP->qty_inventory = $productP->qty_inventory - $c->qty;
            }
            $productP->update();
        }
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }

    public function doStatus($id)
    {
        $this->authorize('update', InventoryAdjustment::class);
        $inventory = InventoryAdjustment::find($id);
        if($inventory->status == 'aprobada' || $inventory->status == 'anulada'){
            return redirect()->route('inventory-adjustment.show',$id);
        }
        $inventory->approved_id = Auth::id();
        $inventory->status = 'aprobada';
        $inventory->save();
        return redirect()->route('inventory-adjustment.show',$id);
    }

    public function adjustment(Request $request)
    {
        $this->authorize('update', InventoryAdjustment::class);
        try {
            if ($request->isMethod('post')) {
                $id = $request->product_id;
                $qty = $request->product_qty;
                $purchaseP= PurchaseProduct::find($id);
                if($request->type_inventory == 'rest'){
                    if($qty > $purchaseP->qty_inventory){
                        return 'La cantidad a ajustar es mayor a la actual: '.$purchaseP->qty_inventory;
                    }
                    $cantidad = $purchaseP->qty_inventory - $qty;
                }else{
                    $cantidad = $purchaseP->qty_inventory + $qty;
                    /*
                    $countPI = PurchaseProduct::where('product_id',$purchaseP->product_id)
                        ->where('purchase_id',0)
                        ->count();
                    if($countPI > 0){
                        $getPI= PurchaseProduct::where('product_id',$purchaseP->product_id)
                            ->where('purchase_id',0)
                            ->get();
                        $getPI_SAVE = PurchaseProduct::find($getPI[0]->id);
                        //$cantidad = $getPI_SAVE->qty_inventory + $qty;
                        $getPI_SAVE->qty_inventory = $getPI_SAVE->qty_inventory + $qty;
                        $getPI_SAVE->save();
                    }else{
                        PurchaseProduct::create([
                            'purchase_id' => 0,
                            'product_id' => $purchaseP->product_id,
                            'cellar_id' => 8,
                            'inventory' => 'si',
                            'qty_inventory' => $qty,
                            'qty_inventory_ever'=>$qty,
                            'qty' => $qty,
                            'full_amount' => $qty,
                        ]);
                    }
                    */
                }
                if($cantidad < 0 ){
                    $cantidad = 0;
                }
                $purchaseP->qty_inventory = $cantidad;
                //$purchaseP->observations_ajust = $purchaseP->observations_ajust.' '.$request->observations;
                if($purchaseP->save()){
                    setlocale(LC_ALL,"es_CO");
                    ini_set('date.timezone','America/Bogota');
                    date_default_timezone_set('America/Bogota');
                    $todayh = getdate();
                    $d = date("d");
                    $m = date("m");
                    $y = $todayh['year'];
                    $date = $y.'-'.$m.'-'.$d;
                    $InventoryAdjustmentObser = InventoryAdjustmentObservation::create([
                        'user_id'=> Auth::id(),
                        'product_id'=>$purchaseP->product_id,
                        'observations'=>$request->observations,
                        'date'=>$date,
                        'qty'=>$qty,
                        'type'=>$request->type_inventory=='rest'?'Quitar':'Agregar',
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


    public function show_products($id)
    {
        $this->authorize('view', InventoryAdjustment::class);
        $producto = Product::find($id);
        $historial = InventoryAdjustmentObservation::where('product_id',$id)->orderBy('id','asc')->get();

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
        return view('inventory-adjustment.show_products', [
            'producto'=>$producto,
            'historial'=>$historial,
            'qty_inventary'=>$qty_inventary
        ]);
    }

    public function add(Request $request)
    {
        $this->authorize('create', InventoryAdjustment::class);
        try {
            if ($request->isMethod('post')) {
                $purchaseP = PurchaseProduct::create([
                    'purchase_id' => 0,
                    'product_id' => $request->product_id,
                    'lote'=>$request->lote,
                    'expiration'=>$request->date,
                    'cellar_id' => 8,
                    'inventory' => 'si',
                    'qty_inventory' =>  $request->product_qty,
                    'qty_inventory_ever'=>$request->product_qty,
                    'qty' => $request->product_qty,
                    'full_amount' => $request->product_qty,
                ]);
                setlocale(LC_ALL,"es_CO");
                ini_set('date.timezone','America/Bogota');
                date_default_timezone_set('America/Bogota');
                $todayh = getdate();
                $d = date("d");
                $m = date("m");
                $y = $todayh['year'];
                $date = $y.'-'.$m.'-'.$d;
                $InventoryAdjustmentObser = InventoryAdjustmentObservation::create([
                    'user_id'=> Auth::id(),
                    'purchase_product_id'=>$purchaseP->id,
                    'product_id'=> $request->product_id,
                    'observations'=>$request->observations,
                    'date'=>$date,
                    'qty'=>$request->product_qty,
                    'type'=>'Agregar',
                ]);
                return 1;
            }else{
                return 'error';
            }
        } catch (Exception $e) {
            return " Error: " . $e->getMessage();
        }
    }

    public function historial(){
        $this->authorize('view', InventoryAdjustment::class);
        $productList= Product::where('status','activo')
            ->orderBy('name','asc')
            ->get();
        $inventory = PurchaseProduct::where('purchase_id',0)->orderBy('id','desc')->get();
        return view('inventory-adjustment.historial', [
            'productList'=>$productList,
            'inventory'=>$inventory
        ]);
    }

}
