<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Cellar;
use App\Models\OrderForm;
use App\Models\OrderFormProducts;
use App\Models\OrderProduct;
use App\Models\OrderPurchase;
use App\Models\OrderPurchaseConnection;
use App\Models\PersonalInventory;
use App\Models\PersonalInventoryObservations;
use App\Models\Product;
use App\Models\Provider;
use App\Models\ProviderHistorial;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\ShoppingCenter;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index()
    {
        //dd('hello');
        $this->authorize('view', PurchaseOrder::class);
        $data = OrderForm::orderByDesc('created_at')->get();
        return view('purchase-orders.new.index', ['purchases' => $data]);
    }

    public function create($id = 0,$date='')
    {
        $this->authorize('create', PurchaseOrder::class);
        $provider_id = $id;
        $orderProducts = OrderProduct::join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
            ->whereIn('purchase_orders.status',['pedido','enviado'])
            ->groupBy('product_id')
            ->orderBy('order_products.id','asc')
            ->select('order_products.*',DB::raw('SUM(qty - missing) as totaly'))
            ->get();

        if($date != ''){
            $orderProducts = OrderProduct::join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
                ->whereIn('purchase_orders.status',['pedido','enviado'])
                ->where('purchase_orders.created_at','>=',$date.' 00:00:00')
                ->groupBy('product_id')
                ->orderBy('order_products.id','asc')
                ->select('order_products.*',DB::raw('SUM(qty - missing) as totaly'))
                ->get();
        }

        /*
        $products = [1,2];
        $qty = [5,2];
        foreach ($products as $i => $p) {
            $cant_rest = 0;
            $cant = $qty[$i];
            if($cant > 0){
                $orderProducts = OrderProduct::where('order_products.product_id',$products[$i])
                    ->join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
                    ->whereIn('purchase_orders.status',['pedido','enviado'])
                    ->whereColumn('order_products.qty','>','order_products.missing')
                    ->select('order_products.*',DB::raw('qty - missing as totaly'))
                    ->orderBy('totaly','desc')
                    ->get();
                $finish = 1;
                foreach ($orderProducts as $key => $o){
                    if($finish == 1){
                        $update = OrderProduct::find($o->id);
                        $o_totaly = $o->qty - $o->missing;
                        if($key == 0){
                            $cant_rest = $cant - $o_totaly;
                            $older = $cant;
                        }else{
                            $older = $cant_rest;
                            $cant_rest = $cant_rest - $o_totaly;
                        }
                        if($cant_rest >= 0){
                            $update->missing = $o_totaly;
                        }else{
                            //if($older == $cant){
                                $update->missing = $older + $update->missing;
                            //}else{
                                //$update->missing = $older + $update->missing;
                            //}
                            $finish = 0;
                        }
                        if($i == 0){
                            if($key == 1){
                                dd($cant_rest.'/'.$update->missing.'/'.$older);
                            }
                            //dd($update->missing);
                        }
                        //$update->update();
                    }
                }
            }
        }
        dd($orderProducts);
        */


        return view('purchase-orders.new.create', [
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name')->get(),
            'providers' => Provider::where('status', 'activo')->orderBy('company')->get(),
            'centers' => ShoppingCenter::where(['status' => 'activo'])->orderBy('name')->get(),
            'accounts' => Account::where(['status' => 'activo'])->orderBy('account')->get(),
            'cellars' => Cellar::where(['status' => 'activo'])->orderBy('name')->get(),
            'orderP' => $orderProducts,
            'provider_id'=>$provider_id,
            'date'=>$date
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', PurchaseOrder::class);
        request()->validate([
            'products' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'receive_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'bill' => 'required|string',
            'center_cost_id' => 'required|integer',
            'delivery' => 'required|string',
            'cellar_id' => 'required|integer',
            'method_of_pay' => 'required|string',
            'way_of_pay' => 'required|string',
            'comment' => 'required|string|min:0|max:10000'
        ]);

        //validar prueba
        /*
        $products = $request->products;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $orderProducts = OrderProduct::where('order_products.product_id',$products[$i])
                    ->join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
                    ->whereIn('purchase_orders.status',['pedido','enviado'])
                    ->whereColumn('order_products.qty','>','order_products.missing')
                    ->select('order_products.*',DB::raw('qty - missing as totaly'))
                    ->orderBy('totaly', 'desc')
                    ->get();
                if($i > 0){
                    return response(json_encode($orderProducts), 200)->header('Content-Type', 'text/json');
                }
            }
        }
        return response(json_encode($products), 200)->header('Content-Type', 'text/json');
        */

        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);

        $orderForm = OrderForm::create([
            'user_id' => Auth::id(),
            'receive_id' => $request->receive_id,
            'provider_id' => $request->provider_id,
            'bill' => $request->bill,
            'center_cost_id' => $request->center_cost_id,
            'delivery' => $request->delivery,
            'cellar_id' => $request->cellar_id,
            'payment_method' => $request->method_of_pay,
            'way_of_pay' => $request->way_of_pay,
            'days' => $request->days,
            'expiration' => $request->expiration,
            'account_id' => $request->account_id,
            'bank' => $request->bank,
            'account' => $request->account,
            'total' => $amount,
            'comment' => $request->comment,
            'status' => 'creada',
        ]);

        $products = $request->products;
        $qty = $request->qty;
        $price = $request->price;
        $tax = $request->tax;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $amount = str_replace('.', '', $price[$i]);
                $amount = str_replace(',', '', $amount);
                $cant = str_replace('.', '', $qty[$i]);
                $cant = str_replace(',', '', $cant);
                $cant_taxt = str_replace('.', '', $tax[$i]);
                $cant_taxt = str_replace(',', '', $cant_taxt);
                $orderFp = OrderFormProducts::create([
                    'order_form_id' => $orderForm->id,
                    'product_id' => $products[$i],
                    'qty' => $cant,
                    'price' => $amount,
                    'tax' => $cant_taxt,
                ]);

                //provedor historial
                $countPROV = ProviderHistorial::where('product_id',$products[$i])
                    ->where('provider_id',$request->provider_id)
                    ->count();
                if($countPROV > 0){
                    $getPROV = ProviderHistorial::where('product_id',$products[$i])
                        ->where('provider_id',$request->provider_id)
                        ->get();
                    $getPROV_SAVE = ProviderHistorial::find($getPROV[0]->id);
                    $getPROV_SAVE->cost = $amount;
                    $getPROV_SAVE->save();
                }else{
                    ProviderHistorial::create([
                        'product_id' => $products[$i],
                        'provider_id' => $request->provider_id,
                        'cost' => $amount,
                    ]);
                }
                //ending

                $cant_rest = 0;
                if($cant > 0){
                    $orderProducts = OrderProduct::where('order_products.product_id',$products[$i])
                        ->join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
                        ->whereIn('purchase_orders.status',['pedido','enviado'])
                        ->whereColumn('order_products.qty','>','order_products.missing')
                        ->select('order_products.*',DB::raw('qty - missing as totaly'))
                        ->orderBy('totaly', 'desc')
                        ->get();
                    $finish = 1;
                    foreach ($orderProducts as $key => $o){
                        if($finish == 1){
                            $update = OrderProduct::find($o->id);
                            $o_totaly = $o->qty - $o->missing;
                            if($key == 0){
                                $cant_rest = $cant - $o_totaly;
                                $older = $cant;
                            }else{
                                $older = $cant_rest;
                                $cant_rest = $cant_rest - $o_totaly;
                            }
                            if($cant_rest >= 0){
                                $update->missing = $o_totaly;
                            }else{
                                $update->missing = $older + $update->missing;
                                $finish = 0;
                            }
                            $update->update();
                            $purchase_order = OrderPurchase::find($o->purchase_order_id);
                            $purchase_order->status = 'enviado';
                            $purchase_order->update();
                            OrderPurchaseConnection::create([
                                'order_purchase_id'=>$o->purchase_order_id,
                                'order_form_id'=>$orderForm->id,
                                'product_id'=>$products[$i],
                                'order_form_p_id'=>$update->id,
                                'order_rest'=>$update->missing
                            ]);
                        }
                    }
                }

            }
        }
        return response(json_encode($orderForm), 200)->header('Content-Type', 'text/json');

    }

    public function show($id)
    {
        $this->authorize('view', PurchaseOrder::class);
        $purchase = OrderForm::find($id);
        //dd($purchase->id);
        return view('purchase-orders.new.show', [
            'purchase' => $purchase,
        ]);
    }

    public function anulate(Request $request)
    {
        $id = $request->id;
        $orderForm = OrderForm::find($id);
        $orderForm->status = 'anulada';
        $orderForm->motivo = $request->motivo;
        $orderForm->update();
        $orderFormConnection = OrderPurchaseConnection::where('order_form_id',$id)->get();
        foreach ($orderFormConnection as $or){
            $productP = OrderProduct::find($or->order_form_p_id);
            $productP->missing = $productP->missing - $or->order_rest;
            $productP->update();
        }
        $orderForm->connection()->delete();
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }

    public function anulateFaltantes(Request $request)
    {
        $id = $request->id;
        $orderForm = OrderForm::find($id);
        $orderForm->status = 'cerrada';
        $orderForm->update();
        foreach ($orderForm->faltantes as $f){
            $orderFormConnection = OrderPurchaseConnection::where('order_form_id',$id)
                ->where('product_id',$f->product_id)
                ->get();
            foreach ($orderFormConnection as $or){
                $productP = OrderProduct::find($or->order_form_p_id);
                $productP->missing = $productP->missing - $f->qty;
                $productP->update();
            }
            $orderFormProducts = OrderFormProducts::find($f->id);
            $orderFormProducts->status = 'fault_2';
            $orderFormProducts->save();
        }
        return response(json_encode('complet'), 201)->header('Content-Type', 'text/json');
    }

    public function edit(OrderForm $orderForm)
    {
        $this->authorize('create', PurchaseOrder::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $orderForm = OrderForm::find($id[2]);
        if($orderForm->status == 'realizada' || $orderForm->status == 'recibida'){
            return redirect('purchase-orders');
        }
        return view('purchase-orders.new.edit', [
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name')->get(),
            'providers' => Provider::where('status', 'activo')->orderBy('company')->get(),
            'centers' => ShoppingCenter::where(['status' => 'activo'])->orderBy('name')->get(),
            'accounts' => Account::where(['status' => 'activo'])->orderBy('account')->get(),
            'cellars' => Cellar::where(['status' => 'activo'])->orderBy('name')->get(),
            'orderForm' => $orderForm,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('create', PurchaseOrder::class);
        request()->validate([
            'products' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'receive_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'bill' => 'required|string',
            'center_cost_id' => 'required|integer',
            'delivery' => 'required|string',
            'cellar_id' => 'required|integer',
            'method_of_pay' => 'required|string',
            'way_of_pay' => 'required|string',
            'comment' => 'required|string|min:0|max:10000'
        ]);
        $orderForm = OrderForm::find($request->id_order_form);
        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);

        $orderForm->update([
            //'user_id' => Auth::id(),
            'receive_id' => $request->receive_id,
            'provider_id' => $request->provider_id,
            'bill' => $request->bill,
            'center_cost_id' => $request->center_cost_id,
            'delivery' => $request->delivery,
            'cellar_id' => $request->cellar_id,
            'payment_method' => $request->method_of_pay,
            'way_of_pay' => $request->way_of_pay,
            'days' => $request->days,
            'expiration' => $request->expiration,
            'account_id' => $request->account_id,
            'bank' => $request->bank,
            'account' => $request->account,
            'total' => $amount,
            'comment' => $request->comment,
            'status' => 'creada',
        ]);
        $orderForm->products()->delete();
        $vector_v[0]=0;
        foreach ($orderForm->connection as $key => $d){
            $productP = OrderProduct::find($d->order_form_p_id);
            $vector_v[$key] = $d->id;
            $productP->missing = $productP->missing - $d->order_rest;
            $productP->update();
        }
        //return response(json_encode($vector_v), 400)->header('Content-Type', 'text/json');

        $products = $request->products;
        $qty = $request->qty;
        $price = $request->price;
        $tax = $request->tax;
        $cont = 0;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $amount = str_replace('.', '', $price[$i]);
                $amount = str_replace(',', '', $amount);
                $cant = str_replace('.', '', $qty[$i]);
                $cant = str_replace(',', '', $cant);
                $cant_taxt = str_replace('.', '', $tax[$i]);
                $cant_taxt = str_replace(',', '', $cant_taxt);
                $orderFp = OrderFormProducts::create([
                    'order_form_id' => $orderForm->id,
                    'product_id' => $products[$i],
                    'qty' => $cant,
                    'price' => $amount,
                    'tax' => $cant_taxt,
                ]);
                $cant_rest = 0;
                if($cant > 0){
                    $orderPurchaseConn = OrderPurchaseConnection::where('order_form_id',$orderForm->id)
                        ->where('product_id',$products[$i])
                        ->get();
                    if(count($orderPurchaseConn) > 0) {
                        $orderProducts = OrderProduct::where('order_products.product_id', $products[$i])
                            ->join('purchase_orders', 'purchase_orders.id', 'order_products.purchase_order_id')
                            ->whereIn('purchase_orders.status', ['pedido', 'enviado'])
                            ->whereColumn('order_products.qty', '>', 'order_products.missing')
                            ->select('order_products.*',DB::raw('qty - missing as totaly'))
                            ->orderBy('totaly', 'desc')
                            ->get();
                        $finish = 1;
                        foreach ($orderProducts as $key => $o) {
                            if ($finish == 1) {
                                $update = OrderProduct::find($o->id);
                                $o_totaly = $o->qty - $o->missing;
                                if ($key == 0) {
                                    $cant_rest = $cant - $o_totaly;
                                    $older = $cant;
                                } else {
                                    $older = $cant_rest;
                                    $cant_rest = $cant_rest - $o_totaly;
                                }
                                if ($cant_rest >= 0) {
                                    $update->missing = $o_totaly;
                                } else {
                                    $update->missing = $older + $update->missing;
                                    $finish = 0;
                                }
                                $update->update();
                                $purchase_order = OrderPurchase::find($o->purchase_order_id);
                                $purchase_order->status = 'enviado';
                                $purchase_order->update();
                                OrderPurchaseConnection::create([
                                    'order_purchase_id'=>$o->purchase_order_id,
                                    'order_form_id'=>$orderForm->id,
                                    'product_id'=>$products[$i],
                                    'order_form_p_id'=>$update->id,
                                    'order_rest'=>$update->missing
                                ]);
                                /*if(count($orderPurchaseConn) > 0) {
                                $orderPurchaseC = OrderPurchaseConnection::where('order_form_p_id',$update->id)->first();
                                $Vector[$cont] = $orderPurchaseC;
                                $cont++;
                                $orderPurchaseC->update([
                                    'order_rest' => $update->missing
                                ]);
                                }else{
                                    $purchase_order = OrderPurchase::find($o->purchase_order_id);
                                    $purchase_order->status = 'enviado';
                                    $purchase_order->update();
                                    OrderPurchaseConnection::create([
                                        'order_purchase_id'=>$o->purchase_order_id,
                                        'order_form_id'=>$orderForm->id,
                                        'product_id'=>$products[$i],
                                        'order_form_p_id'=>$update->id,
                                        'order_rest'=>$update->missing
                                    ]);
                                }
                                */
                            }
                        }
                    }
                }
            }
        }
        if($vector_v[0] != 0){
            for ($i = 0;$i<count($vector_v);$i++){
                $delete = OrderPurchaseConnection::find($vector_v[$i]);
                $delete->delete();
            }
        }
        //$orderForm->connection()->delete();
        /*
        $query_2 = OrderPurchaseConnection::where('order_form_id',$orderForm->id);
        for ($i = 0;$i<count($Vector);$i++){
            $query_2->where('order_form_p_id','<>',$Vector[$i]);
        }
        $delete_2 = $query_2->get();
        foreach ($delete_2 as $d){
            $delete_2_delete = OrderPurchaseConnection::find($d->id);
            $delete_2_delete->delete();
        }*/
        //return response(json_encode($request->id_order_form), 400)->header('Content-Type', 'text/json');
        return response(json_encode($orderForm), 200)->header('Content-Type', 'text/json');
    }

    public function searchHistory(Request $request)
    {
        $id = $request->id;
        $order_p = OrderProduct::where('order_products.product_id',$id)
            ->join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
            ->whereIn('purchase_orders.status',['pedido','enviado'])
            ->whereColumn('order_products.qty','>','order_products.missing')
            ->select('order_products.*')
            ->orderBy('order_products.id','asc')
            ->get();
        return view('purchase-orders.new.history',[
            'order_p'=>$order_p
        ]);
    }

    public function doStatus($id)
    {
        $this->authorize('update', PurchaseOrder::class);
        $purchase = OrderForm::find($id);
        if($purchase->status == 'realizada' || $purchase->status == 'anulada' || $purchase->status == 'recibida'){
            return redirect()->route('purchase-orders.show',$id);
        }
        $purchase->status = 'realizada';
        $purchase->save();
        return redirect()->route('purchase-orders.show',$id);
    }

    public function generatePDF($id)
    {
        $id = str_replace('OC-','',$id);
        $data = OrderForm::find($id);
        $title="ORDEN DE COMPRA Y DE SERVICIO";
        $pdf = $this->pdf->loadView('pdf.purchase-orders',
            ['data' => $data, 'title'=>$title,])->setPaper('a4', 'landscape');
        return $pdf->stream('comprobante-de-order-de-compra.pdf');
    }

    public function generatePDFfault($id)
    {
        $id = str_replace('OC-','',$id);
        $data = OrderForm::find($id);
        $title="ORDEN DE COMPRA Y DE SERVICIO";
        $pdf = $this->pdf->loadView('pdf.purchase-orders-fault',
            ['data' => $data, 'title'=>$title,])->setPaper('a4', 'landscape');
        return $pdf->stream('comprobante-de-order-de-compra.pdf');
    }

    public function lotes(Request $request)
    {
        request()->validate([
            'id' => 'required|string',
        ]);
        $name = $request->id;
        $data_1 = PurchaseProduct::with('product', 'cellar', 'product.presentation')
            ->whereHas('product', function ($q) use ($name) {
                $q->where('name', 'like', '%'.$name.'%');
            })
            ->where('inventory','=','si')
            ->where('qty_inventory','>','0')
            ->whereDate('expiration', '>=', date("Y-m-d"))
            //->groupBy('expiration', 'product_id')
            ->selectRaw('*, qty_inventory as cant')
            ->limit(15)
            ->orderBy('expiration')
            ->get();
        $data_2 = PurchaseProduct::with('product', 'cellar', 'product.presentation')
            ->whereHas('product', function ($q) use ($name) {
                $q->where('name', 'like', '%'.$name.'%');
                $q->where('category_id', '=',12);
            })
            ->where('inventory','=','si')
            ->where('qty_inventory','>','0')
            ->selectRaw('*, qty_inventory as cant')
            ->limit(15)
            ->orderBy('expiration')
            ->get();
        $data = $data_1->merge($data_2);

        $data_3 = PurchaseProduct::with('product', 'cellar', 'product.presentation')
            ->whereHas('product', function ($q) use ($request,$name) {
                $q->where('name', 'like', '%'.$name.'%');
            })
            ->where('purchase_id','=',0)
            ->where('inventory','=','si')
            ->where('qty_inventory','>','0')
            ->selectRaw('*, qty_inventory as cant')
            ->limit(15)
            ->orderBy('expiration')
            ->get();
        $data = $data->merge($data_3);
        $array=[];
        foreach ($data as $d){
            $array[] = ["id" => $d->id, "text" =>'Lote: '.$d->lote.' Cant: '.$d->cant];
        }
        return response(json_encode($array), 200)->header('Content-Type', 'text/json');
    }


    public function inventory(Request $request){
        $this->authorize('create', PersonalInventory::class);
        request()->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required',
            'lote_id'=> 'required',
            'product_qty'=> 'required',
            'observations' => 'required|string',
        ]);

        $lote_id = $request->lote_id;
        $qty = $request->product_qty;
        $user_id = $request->user_id;
        $observations = $request->observations;
        $product_id = $request->product_id;
        $id_order_product = $request->id_order_product;

        $purchaseP = PurchaseProduct::find($lote_id);
        if($qty>$purchaseP->qty_inventory){
            return 'La cantidad a colocar en inventario personal no esta disponible en el lote '
                    .$purchaseP->lote.
                    ' en el producto '.$purchaseP->product->name.
                    ' la cantidad disponible es '.$purchaseP->qty_inventory;
        }
        $orderP = OrderProduct::find($id_order_product);
        if( $qty > ($orderP->qty - $orderP->missing) ){
            return 'La cantidad solicitada en esta orden de pedido no es correcta, la cantidad solicitada es: '.($orderP->qty - $orderP->missing);
        }
        //return 'entro';
        $orderP->missing = $orderP->missing + $qty;
        $orderP->save();

        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $todayh = getdate();
        $d = date("d");
        $m = date("m");
        $y = $todayh['year'];
        $date = $y.'-'.$m.'-'.$d;
        PersonalInventoryObservations::create([
            'user_id' => $user_id,
            'purchase_products_id' => $lote_id,
            'qty' => $qty,
            'observations' => $observations,
            'date' => $date,
        ]);


        $countPI = PersonalInventory::where('product_id',$product_id)
            ->where('user_id',$user_id)
            ->count();
        if($countPI > 0){
            $getPI= PersonalInventory::where('product_id',$product_id)
                ->where('user_id',$user_id)
                ->get();
            $getPI_SAVE = PersonalInventory::find($getPI[0]->id);
            $getPI_SAVE->user_id = $user_id;
            $getPI_SAVE->product_id = $product_id;
            $getPI_SAVE->qty = $getPI_SAVE->qty + $qty;
            $getPI_SAVE->save();
        }else{
            PersonalInventory::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'qty' => $qty,
            ]);
        }

        $purchaseP = PurchaseProduct::find($lote_id);
        $cant_final = $purchaseP->qty_inventory - $qty;
        if(($purchaseP->qty_inventory - $qty) < 0){
            $cant_final = 0;
        }
        $purchaseP->qty_inventory = $cant_final;
        $purchaseP->qty_inventory_personal = $purchaseP->qty_inventory_personal + $qty;
        $purchaseP->qty_inventory_personal_ever = $purchaseP->qty_inventory_personal_ever + $qty;
        $purchaseP->qty_inventory_ever = $purchaseP->qty_inventory_ever - $qty;
        $purchaseP->save();

        //$orderP = OrderProduct::find($id_order_product);

        return 1;
    }

}
