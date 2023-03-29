<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PersonalInventory;
use App\Models\PersonalInventoryObservations;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalInventoryController extends Controller
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
        $this->authorize('view', PersonalInventory::class);
        $users = User::where('status','activo')->get();
        return view('personal-inventory.index', [
            'users'=>$users
        ]);
    }

    public function create()
    {
        $this->authorize('create', PersonalInventory::class);

        return view('personal-inventory.create', [
            'products' => Product::all(),
            'users' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', PersonalInventory::class);
        request()->validate([
            'user_id' => 'required|integer',
            'products' => 'required|array',
            'observations' => 'required|string',
        ]);

        $products = $request->products;
        $purchase_product_id = $request->purchase_product_id;
        $qty = $request->qty;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                if($qty[$i]>$purchaseP->qty_inventory){
                    return redirect()->route('personal-inventory.create')
                        ->with('error','La cantidad a colocar en inventario personal no esta disponible en el lote '
                            .$purchaseP->lote.
                            ' en el producto '.$purchaseP->product->name.
                            ' la cantidad disponible es '.$purchaseP->qty_inventory);
                }
            }
        }

        foreach ($products as $i => $p) {
            if ($p != "") {
                setlocale(LC_ALL,"es_CO");
                ini_set('date.timezone','America/Bogota');
                date_default_timezone_set('America/Bogota');
                $todayh = getdate();
                $d = date("d");
                $m = date("m");
                $y = $todayh['year'];
                $date = $y.'-'.$m.'-'.$d;
                PersonalInventoryObservations::create([
                    'user_id' => $request->user_id,
                    'purchase_products_id' => $purchase_product_id[$i],
                    'qty' => $qty[$i],
                    'observations' => $request->observations,
                    'date' => $date,
                ]);
                $countPI = PersonalInventory::where('product_id',$products[$i])
                    ->where('user_id',$request->user_id)
                    ->count();
                if($countPI > 0){
                    $getPI= PersonalInventory::where('product_id',$products[$i])
                        ->where('user_id',$request->user_id)
                        ->get();
                    $getPI_SAVE = PersonalInventory::find($getPI[0]->id);
                    $getPI_SAVE->user_id = $request->user_id;
                    $getPI_SAVE->product_id = $products[$i];
                    $getPI_SAVE->qty = $getPI_SAVE->qty + $qty[$i];
                    $getPI_SAVE->save();
                }else{
                    PersonalInventory::create([
                        'user_id' => $request->user_id,
                        'product_id' => $products[$i],
                        'qty' => $qty[$i],
                    ]);
                }
                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                $cant_final = $purchaseP->qty_inventory - $qty[$i];
                if(($purchaseP->qty_inventory - $qty[$i]) < 0){
                    $cant_final = 0;
                }
                $purchaseP->qty_inventory = $cant_final;
                $purchaseP->qty_inventory_personal = $purchaseP->qty_inventory_personal + $qty[$i];
                $purchaseP->qty_inventory_personal_ever = $purchaseP->qty_inventory_personal_ever + $qty[$i];
                //$purchaseP->inventory_personal_id = $request->user_id;
                $purchaseP->qty_inventory_ever = $purchaseP->qty_inventory_ever - $qty[$i];
                $purchaseP->save();
            }
        }

        return redirect()->route('personal-inventory.index')
            ->with('success','Inventario Personal creado exitosamente.');
    }

    public function show($id)
    {
        $this->authorize('view', PersonalInventory::class);
        $user = User::find($id);
        $list = PersonalInventoryObservations::where('user_id',$id)
            ->orderBy('date','desc')->get();
        $listP = PersonalInventory::where('user_id',$id)->get();
        return view('personal-inventory.show', [
            'user'=>$user,
            'list'=>$list,
            'listP'=>$listP
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', PersonalInventory::class);
        try {
            if ($request->isMethod('post')) {
                $id = $request->id;
                $id_product = $request->product_id;
                $lote = $request->lote_id;
                $qty = $request->product_qty;

                $IP = PersonalInventory::find($id);
                if($qty > $IP->qty){
                    return 'La cantidad suministrada es mayor a la disponible: '.$IP->qty;
                }

                if(($IP->qty - $qty) < 0){
                    $qty = 0;
                }
                $IP->qty = $IP->qty - $qty;
                $IP->save();

                if($lote == ''){
                    PurchaseProduct::create([
                        'purchase_id' => 0,
                        'product_id' => $id_product,
                        'cellar_id' => 8,
                        'inventory' => 'si',
                        'qty_inventory' => $qty,
                        'qty_inventory_ever'=>$qty,
                        'qty' => $qty,
                        'full_amount' => $qty,
                    ]);
                }else{
                    $purchaseP = PurchaseProduct::find($lote);
                    $cant_final = $purchaseP->qty_inventory + $qty;
                    $purchaseP->qty_inventory = $cant_final;
                    $purchaseP->qty_inventory_ever = $purchaseP->qty_inventory_ever + $qty;
                    $purchaseP->save();
                }

                setlocale(LC_ALL,"es_CO");
                ini_set('date.timezone','America/Bogota');
                date_default_timezone_set('America/Bogota');
                $todayh = getdate();
                $d = date("d");
                $m = date("m");
                $y = $todayh['year'];
                $date = $y.'-'.$m.'-'.$d;
                PersonalInventoryObservations::create([
                    'user_id' => Auth::id(),
                    'purchase_products_id' => $lote,
                    'qty' => $qty,
                    'observations' => 'Reenviado al inventario general',
                    'date' => $date,
                ]);
                return 1;
            }else{
                return 'error';
            }
        }catch(Exception $e){
            return " Error: " . $e->getMessage();
        }
    }

}
