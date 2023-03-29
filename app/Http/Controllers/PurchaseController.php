<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Cellar;
use App\Models\CenterCost;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\ShoppingCenter;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
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
        return view('purchases.index', [
           'purchases' => Purchase::orderBy('id','desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = false)
    {
        $this->authorize('create', Purchase::class);
        if ($id) {
            $order = PurchaseOrder::find($id);
        } else {
            $order = [];
        }
        return view('purchases.create', [
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
            'providers' => Provider::where('status', 'activo')->orderBy('company')->get(),
            'centers' => ShoppingCenter::where(['status' => 'activo'])->orderBy('name')->get(),
            'accounts' => Account::where(['status' => 'activo'])->orderBy('account')->get(),
            'cellars' => Cellar::where(['status' => 'activo'])->orderBy('name')->get(),
            'order' => $order,
            'orders' => $order->products
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
        $this->authorize('create', Purchase::class);
        request()->validate([
            'products' => 'required|array',
            //'date_expiration' => 'required|array',
            //'lote' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'provider_id' => 'required|integer',
            'center_cost_id' => 'required|integer',
            'cellar_id' => 'required|integer',
            'method_of_pay' => 'required|string',
            'way_of_pay' => 'required|string',
            'bill' => 'required|string',
            //'amount' => 'required|numeric',
            'comment' => 'required|min:5|max:500'
        ]);

        $amount = str_replace('.', '', $request->amount);
        $amount = str_replace(',', '', $amount);

        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'provider_id' => $request->provider_id,
            'payment_method' => $request->method_of_pay,
            'way_of_pay' => $request->way_of_pay,
            'bill' => $request->bill,
            'center_cost_id' => $request->center_cost_id,
            'total' => $amount,
            'days' => $request->days,
            'expiration' => $request->expiration,
            'account_id' => $request->account_id,
            'bank' => $request->bank,
            'account' => $request->account,
            'center_cost_id' => $request->center_cost_id,
            'cellar_id' => $request->cellar_id,
            'comment' => $request->comment,
            'status' => 'activo',
        ]);

        if ($request->has('purchase_order')) {
            PurchaseOrder::find($request->purchase_order)->update([
                'status' => 'inventariado'
            ]);
        }

        $products = $request->products;
        $qty = $request->qty;
        $lote = $request->lote;
        $price = $request->price;
        $date_expiration = $request->date_expiration;
        $tax = $request->tax;

        foreach ($products as $i => $p) {
            if ($p != "") {
                $amount = str_replace('.', '', $price[$i]);
                $amount = str_replace(',', '', $amount);
                $cant = str_replace('.', '', $qty[$i]);
                $cant = str_replace(',', '', $cant);
                PurchaseProduct::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $products[$i],
                    //'lote' => $lote[$i],
                    'expiration' => "",
                    'price' => $amount,
                    'qty' => $cant,
                    'tax' => $tax[$i],
                    'cellar_id' => $request->cellar_id,
                    'full_amount' => $cant,
                ]);
                /*Product::find($products[$i])->update([
                   'cost' => $amount,
                    'tax' => $tax[$i]
                ]);*/
            }
        }
        return response(json_encode($purchase), 200)->header('Content-Type', 'text/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Purchase::class);
        return view('purchases.show', [
           'purchase' => Purchase::find($id),
            'cellars' => Cellar::where('status','activo')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }
    public function update_p_p(Request $request, Purchase $purchase)
    {
        $PurchaseProduct=PurchaseProduct::find($request->id);
        if($request->action=="lote"){
            $PurchaseProduct->lote=$request->value;
        }else if ($request->action=="date") {
            $PurchaseProduct->expiration=$request->value;
        }else if ($request->action=="quanty") {
            if($request->value > $PurchaseProduct->full_amount){
                return 'El valor de cantidad es mayor al solicitado que es: '.$PurchaseProduct->full_amount;
            }
            $PurchaseProduct->missing = $request->value;
            $PurchaseProduct->qty = $PurchaseProduct->full_amount - $request->value;
        }else if($request->action=='cellar'){
            $PurchaseProduct->cellar_id = $request->cellar;
        }else if($request->action=='price'){
            $amount = str_replace('.', '', $request->value);
            $amount = str_replace(',', '', $amount);
            $PurchaseProduct->price = $amount;
        }else if($request->action=='tax'){
            $amount = str_replace('.', '', $request->value);
            $amount = str_replace(',', '', $amount);
            $PurchaseProduct->tax = $amount;
        }

        $PurchaseProduct->save();

        $purchase = Purchase::find($PurchaseProduct->purchase_id);
        $ft=false;
        foreach ($purchase->products as $p) {
            if(intval($p->missing)!=0){
                $ft=true;
            }
        }
        if($ft){
            $purchase->update([
                "status"=>"incompleta",
            ]);
        }else{
            $purchase->update([
                "status"=>"activo",
            ]);
        }

        return '1';
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
    public function generatePDFIn($id)
    {
        $title="";
        $data = Purchase::find($id);
        $title="Comprobante de compra";
        $pdf = $this->pdf->loadView('pdf.purchaseIn',
        [
            'data' => $data,
            'title'=>$title,
        ]);
        return $pdf->stream('Comprobante-de-compra.pdf');
    }

    public function generatePDFInComplet($id)
    {
        $title="";
        $data = Purchase::find($id);
        $title="Comprobante de compra de incompletos";
        $pdf = $this->pdf->loadView('pdf.purchaseInComplet',
            [
                'data' => $data,
                'title'=>$title,
            ]);
        return $pdf->stream('Comprobante-de-compra-incompletos.pdf');
    }

    public function generatePDF($id)
    {
        $title="";

        $typePurchase=explode("-",$id);

        if(count($typePurchase)>1){
            $id=$typePurchase[1];
            $data = PurchaseOrder::find($id);
            if($typePurchase[0]=="O"){
                $title="Orden de compra";
            }
        }else{
            $data = PurchaseOrder::find($id);
            $title="Comprobante de compra";
        }

        $pdf = $this->pdf->loadView('pdf.purchase',
        [
            'data' => $data,
            'title'=>$title,
        ]);

        return $pdf->stream('Comprobante-de-compra.pdf');

    }

    public function payment(Request $request)
    {
        request()->validate([
            'purchase_id' => 'required|integer',
            'amount' => 'required',
            'comment' => 'required|min:3|max:250'
        ]);

        $amount = str_replace('$ ', '', $request->amount);
        $amount = str_replace(',', '', $amount);
        $amount = str_replace('.', '', $amount);

        $payment = Payment::create([
           'user_id' => Auth::id(),
           'purchase_id' => $request->purchase_id,
           'amount' => $amount,
           'comment' => $request->comment
        ]);

        $purchase = Purchase::find($request->purchase_id);
        if ($purchase->balance < $amount)
            return response(json_encode(["message" => "No se puede realizar la operación"]), 400)->header('Content-Type', 'text/json');
        $purchase->update([
            'balance' => $purchase->balance - $amount
        ]);

        return response(json_encode($payment), 201)->header('Content-Type', 'text/json');

    }

    public function cancel(Request $request) {
        $this->authorize('delete', Purchase::class);
        request()->validate([
            'id' => 'required|integer'
        ]);

        Purchase::find($request->id)->update([
            'status' => 'anulado'
        ]);

        return response(json_encode(["Message" => "Anulado"]), 201)->header('Content-Type', 'text/json');
    }

    public function Inventory(Request $request){
        $this->authorize('update', Purchase::class);
        request()->validate([
            'id' => 'required|integer'
        ]);
        $purchase = Purchase::find($request->id);
        if($purchase->status == 'incompleta'){
            return response(json_encode(["Message" => "Incompleta"]), 202)->header('Content-Type', 'text/json');
        }
        $purchase->update([
            'status' => 'inventariada'
        ]);
        $products = PurchaseProduct::where('purchase_id',$request->id)->where('inventory','no')->get();
        foreach ($products as $p){
            $product = PurchaseProduct::find($p->id);
            $product->qty_inventory = $product->qty;
            $product->qty_inventory_ever = $product->qty;
            $product->inventory = 'si';
            $product->save();
        }
        return response(json_encode(["Message" => "Inventariado"]), 201)->header('Content-Type', 'text/json');
    }

    public function search(Request $request)
    {
        $data_1 = PurchaseProduct::with('product', 'cellar', 'product.presentation')
            ->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->query("search").'%');
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
            ->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->query("search").'%');
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
            ->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->query("search").'%');
            })
            ->where('purchase_id','=',0)
            ->where('inventory','=','si')
            ->where('qty_inventory','>','0')
            ->selectRaw('*, qty_inventory as cant')
            ->limit(15)
            ->orderBy('expiration')
            ->get();
        $data = $data->merge($data_3);
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function expired()
    {
        $products = PurchaseProduct::with('product', 'cellar', 'product.presentation', 'product.category')
            ->whereBetween('expiration', [date("Y-m-d"), date("Y-m-d", strtotime("+90 days"))])
            //->groupBy('expiration', 'product_id')
            ->selectRaw('*, qty_inventory as cant')
            ->orderBy('expiration')->get();

        return view('products-expired.index', [
            'products' => $products
        ]);
    }

    public function anulatesale(Request $request)
    {
        request()->validate([
            'id' => 'required|integer'
        ]);
        Sale::find($request->id)->update([
            'status'=>'anulada'
        ]);
        return response(json_encode(["Message" => "Anulado"]), 201)->header('Content-Type', 'text/json');
    }
}
