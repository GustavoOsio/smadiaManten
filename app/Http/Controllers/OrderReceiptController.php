<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoteProducts;
use App\Models\OrderForm;
use App\Models\OrderFormProducts;
use App\Models\OrderReceipt;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoteProductExport;
class OrderReceiptController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index()
    {
        $this->authorize('view', LoteProducts::class);
        $data = OrderForm::whereIn('status',['realizada','recibida'])->orderByDesc('created_at')->get();
        return view('lote-products.new.index', [
            'purchases' => $data,
        ]);
    }

    public function edit(OrderForm $product)
    {
        $this->authorize('create', LoteProducts::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $purchase = OrderForm::all()->where("id",$id[2])->first();
        return view('lote-products.new.edit', [
            'orderForm'=>$purchase,
            'product'=>$product,
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', LoteProducts::class);
        request()->validate([
            'products' => 'required|array',
            'qty' => 'required|array',
            'lote' => 'required|array',
            'date' => 'required|array',
            'observations' => 'required|string|min:0|max:10000'
        ]);
        $orderReceipt = OrderReceipt::create([
            'user_id' => Auth::id(),
            'order_form_id'=>$request->id_order_form,
            'observations' => $request->observations,
            'status' => 'creada',
        ]);
        $orderForm = OrderForm::find($request->id_order_form);
        $orderForm->update([
           'status'=>'recibida'
        ]);
        $products = $request->products;
        $qty = $request->qty;
        $lote = $request->lote;
        $date = $request->date;
        $invima = $request->invima;
        $date_invima = $request->date_invima;
        $renov_invima = $request->renov_invima;
        $packing = $request->packing;
        $transport = $request->transport;
        $inconfirmness = $request->inconfirmness;
        $temperature = $request->temperature;
        $accepted = $request->accepted;

        foreach ($products as $i => $p) {
            if ($p != "") {
                $cant = str_replace('.', '', $qty[$i]);
                $cant = str_replace(',', '', $cant);
                $orderProducts = OrderFormProducts::find($products[$i]);
                $status = 'new';
                if($cant >= $orderProducts->qty){
                    $status = 'complet';
                }else{
                    $status = 'new_2';
                }
                if($orderProducts->status == 'new' || $orderProducts->status == 'older'){
                    $status = 'older';
                }
                $orderProducts->update([
                    'qty_fal'=>$cant,
                    'lote'=>$lote[$i],
                    'expiration'=>$date[$i],
                    'invima'=>$invima[$i],
                    'date_invima'=>$date_invima[$i],
                    'renov_invima'=>$renov_invima[$i],
                    'packing'=>$packing[$i],
                    'transport'=>$transport[$i],
                    'inconfirmness'=>$inconfirmness[$i],
                    'temperature'=>$temperature[$i],
                    'accepted'=>$accepted[$i],
                    'status'=>$status,
                    'order_receipt_id'=>$orderReceipt->id,
                ]);
            }
        }

    }

    public function index_2()
    {
        $this->authorize('view', LoteProducts::class);
        $data = OrderReceipt::orderByDesc('created_at')->get();
        return view('lote-products.new.index_2', [
            'orderReceipt' => $data,
        ]);
    }


    public function show($id)
    {
        $this->authorize('view', LoteProducts::class);
        $orderReceipt = OrderReceipt::find($id);
        return view('lote-products.new.show', [
            'orderReceipt'=>$orderReceipt,
        ]);
    }

    public function edit_2()
    {
        $this->authorize('update', LoteProducts::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $orderReceipt = OrderReceipt::find($id[3]);
        $purchase = OrderForm::all()->where("id",$orderReceipt->order_form_id)->first();
        return view('lote-products.new.edit_2', [
            'orderForm'=>$purchase,
            'orderReceipt'=>$orderReceipt,
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', LoteProducts::class);
        request()->validate([
            'products' => 'required|array',
            'qty' => 'required|array',
            'lote' => 'required|array',
            'date' => 'required|array',
            'observations' => 'required|string|min:0|max:10000'
        ]);
        $orderReceipt = OrderReceipt::find($request->order_receipt_id);
        $orderReceipt->update([
            //'user_id' => Auth::id(),
            //'order_form_id'=>$request->id_order_form,
            'observations' => $request->observations,
            //'status' => 'creada',
        ]);

        $products = $request->products;
        $qty = $request->qty;
        $lote = $request->lote;
        $date = $request->date;
        $invima = $request->invima;
        $date_invima = $request->date_invima;
        $renov_invima = $request->renov_invima;
        $packing = $request->packing;
        $transport = $request->transport;
        $inconfirmness = $request->inconfirmness;
        $temperature = $request->temperature;
        $accepted = $request->accepted;

        foreach ($products as $i => $p) {
            if ($p != "") {
                $cant = str_replace('.', '', $qty[$i]);
                $cant = str_replace(',', '', $cant);
                $orderProducts = OrderFormProducts::find($products[$i]);
                $status = 'new';
                if($cant >= $orderProducts->qty){
                    $status = 'complet';
                }else{
                    $status = 'new_2';
                }
                if($orderProducts->status == 'new' || $orderProducts->status == 'older'){
                    $status = 'older';
                }
                $orderProducts->update([
                    'qty_fal'=>$cant,
                    'lote'=>$lote[$i],
                    'expiration'=>$date[$i],
                    'invima'=>$invima[$i],
                    'date_invima'=>$date_invima[$i],
                    'renov_invima'=>$renov_invima[$i],
                    'packing'=>$packing[$i],
                    'transport'=>$transport[$i],
                    'inconfirmness'=>$inconfirmness[$i],
                    'temperature'=>$temperature[$i],
                    'accepted'=>$accepted[$i],
                    'status'=>$status,
                    'order_receipt_id'=>$orderReceipt->id,
                ]);
            }
        }

    }

    public function do(Request $request)
    {
        $this->authorize('create', Purchase::class);
        $orderReceipt = OrderReceipt::find($request->id);
        if($orderReceipt->status == 'enviada'){
            return response(json_encode($orderReceipt->id), 201)->header('Content-Type', 'text/json');
            //return 2;
            //return redirect(order-receipt'/'.$id);
        }
        $orderReceipt->status = 'enviada';
        $orderReceipt->save();
        foreach ($orderReceipt->products as $p){
            if($p->qty_fal >= $p->qty){
                $status = 'complet';
            }else{
                $status = 'fault';
            }
            if($status == 'fault'){
                $fault = $p->qty - $p->qty_fal;
                if($fault<=0){
                    $fault = 0;
                }
                $orderFp = OrderFormProducts::create([
                    'order_form_id' => $p->order_form_id,
                    'product_id' => $p->product_id,
                    'qty' => $fault,
                    'price' => $p->price,
                    'tax' => $p->tax,
                    'status'=>'fault',
                    //'order_receipt'=>$orderReceipt->id,
                ]);
            }
        }
        //compra;
        $orderReceipt = OrderReceipt::find($request->id);
        $orderForm = OrderForm::find($orderReceipt->order_form_id);
        //$amount = str_replace('.00', '', $orderForm->total);
        //$amount = str_replace('.', '', $amount);
        //$amount = str_replace(',', '', $amount);
        $purchaseCount = Purchase::where('order_form_id',$orderForm->id)->get();
        if(count($purchaseCount) == 0){
            $purchase = Purchase::create([
                'user_id' => Auth::id(),
                'comment' => $orderForm->comment,
                'provider_id' => $orderForm->provider_id,
                'payment_method' => $orderForm->payment_method,
                'way_of_pay' => $orderForm->way_of_pay,
                'bill' => $orderForm->bill,
                'center_cost_id' => $orderForm->center_cost_id,
                'total' => $orderForm->total,
                'days' => $orderForm->days,
                'expiration' => $orderForm->expiration,
                'account_id' => $orderForm->account_id,
                'bank' => $orderForm->bank,
                'account' => $orderForm->account,
                'cellar_id' => $orderForm->cellar_id,
                'status' => 'activo',
                'order_form_id' => $orderForm->id,
            ]);
        }else{
            $purchase = Purchase::find($purchaseCount[0]->id);
        }
        foreach ($orderReceipt->products as $p){
            //$price = str_replace('.', '', $p->price);
            //$price = str_replace(',', '', $price);
            PurchaseProduct::create([
                'purchase_id' => $purchase->id,
                'product_id' => $p->product_id,
                'lote' => $p->lote,
                'expiration' => $p->expiration,
                'price' => $p->price,
                'qty' => $p->qty_fal,
                'tax' => $p->tax,
                'cellar_id' => $orderForm->cellar_id,
                'full_amount' => $p->qty_fal,
            ]);
        }
        return response(json_encode($purchase->id), 200)->header('Content-Type', 'text/json');
        //return 1;
        //return redirect('purchases/'.$purchase->id);
    }

    public function generatePDF($id)
    {
        $id = str_replace('RP-','',$id);
        $data = OrderReceipt::find($id);
        $title="RECEPCION DE MEDICAMENTOS";
        $pdf = $this->pdf->loadView('pdf.order-receipt',
            ['data' => $data, 'title'=>$title,])->setPaper('a4', 'landscape');
        return $pdf->stream('comprobante-de-recepcion-de-pedido.pdf');
    }


}
