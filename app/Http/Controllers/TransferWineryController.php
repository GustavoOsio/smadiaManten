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
use App\Models\TransferWinery;
use App\Models\TransferWineryObservations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferWineryController extends Controller
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
        $this->authorize('view', TransferWinery::class);
        $transfer = TransferWinery::orderBy('id','desc')->get();
        return view('transfer-winery.index', [
            'transfer'=>$transfer
        ]);
    }

    public function create()
    {
        $this->authorize('create', TransferWinery::class);

        return view('transfer-winery.create', [
            'products' => Product::all(),
            'cellars' => Cellar::where('status', 'activo')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', TransferWinery::class);
        request()->validate([
            'observations' => 'required',
            'products' => 'required|array',
            'qty' => 'required',
            'cellar_id' => 'required',
        ]);
        $products = $request->products;
        $purchase_product_id = $request->purchase_product_id;
        $qty = $request->qty;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                if ($qty[$i] > $purchaseP->qty_inventory) {
                    return redirect()->route('transfer-winery.create')
                        ->with('error', 'La cantidad a transladar no esta disponible en el lote '
                            . $purchaseP->lote .
                            ' en el producto ' . $purchaseP->product->name .
                            ' la cantidad disponible es ' . $purchaseP->qty_inventory);
                }
            }
        }

        $transfer = TransferWinery::create([
            'user_id'=>Auth::id(),
            'cellar_id'=>$request->cellar_id,
            'observations'=>$request->observations,
            'status'=>'creada',
        ]);

        foreach ($products as $i => $p) {
            if ($p != "") {
                $id = $purchase_product_id[$i];
                $qty_save = $qty[$i];
                $purchaseP= PurchaseProduct::find($id);
                $cantidad = $purchaseP->qty_inventory - $qty_save;
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
                    $transferObs = TransferWineryObservations::create([
                        'user_id'=> Auth::id(),
                        'transfer_to_winery_id'=>$transfer->id,
                        'purchase_product_id'=>$purchaseP->id,
                        'product_id'=>$purchaseP->product_id,
                        'observations'=>$request->observations,
                        'date'=>$date,
                        'qty'=>$qty_save,
                        'qty_falt'=>$qty_save
                    ]);
                }
            }
        }
        //finalizo
        return redirect()->route('transfer-winery.index')
            ->with('success','Transferencia a Bodega creada exitosamente.');
    }

    public function show($id)
    {
        $transfer = TransferWinery::find($id);
        $transferList = TransferWineryObservations::where('transfer_to_winery_id',$id)->get();
        return view('transfer-winery.show', [
            'transfer'=>$transfer,
            'transferList'=>$transferList,
        ]);
    }

    public function anulate(Request $request)
    {
        $id = $request->id;
        $transfer = TransferWinery::find($id);
        if($transfer->status == 'realizado'){
            return response(json_encode('no_cant'), 202)->header('Content-Type', 'text/json');
        }
        $transfer->approved_id = Auth::id();
        $transfer->status = 'anulada';
        $transfer->motivo = $request->motivo;
        $transfer->update();
        $transferList = TransferWineryObservations::where('transfer_to_winery_id',$id)->get();
        foreach ($transferList as $c){
            $productP = PurchaseProduct::find($c->purchase_product_id);
            $productP->qty_inventory = $productP->qty_inventory + $c->qty;
            $productP->update();
        }
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }

    public function doStatus($id)
    {
        $this->authorize('update', TransferWinery::class);
        $transfer = TransferWinery::find($id);
        if($transfer->status == 'aprobada' || $transfer->status == 'anulada'){
            return redirect()->route('transfer-winery.show',$id);
        }
        $transfer->approved_id = Auth::id();
        $transfer->status = 'aprobada';
        $transfer->save();
        return redirect()->route('transfer-winery.show',$id);
    }

}
