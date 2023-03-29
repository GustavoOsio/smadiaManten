<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\ContactSource;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Item;
use App\Models\OrderProduct;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\OrderPurchase;
use App\Models\PurchaseOrder;
use App\Models\Service;
use App\Models\State;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderPurchaseController extends Controller
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
        $this->authorize('view', OrderPurchase::class);
        $data = OrderPurchase::where('id_order', '!=', '')->orderByDesc('created_at')->get();
        return view('order-purchases.index', ['purchases' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', OrderPurchase::class);
        return view('order-purchases.create', [
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
            'areas' => Areas::where('status', 'activo')->orderBy('name','asc')->get(),
            'users' => User::where('status', 'activo')->orderBy('name','asc')->get(),
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
        $this->authorize('create', OrderPurchase::class);

        request()->validate([
            'products' => 'required|array',
            /*'type' => 'required|array',*/
            'qty' => 'required|array',
            'receive_id' => 'required',
            /*'area' => 'required|min:2|max:50',*/
            'comment' => 'required|min:5|max:500'
        ]);

        $id_order = OrderPurchase::max('id_order');

        $purchase = OrderPurchase::create([
            'receive_id' => $request->receive_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'area' => $request->area,
            'status' => 'pedido',
            'id_order' => $id_order + 1
        ]);

        $products = $request->products;
        $qty = $request->qty;
        /*$type = $request->type;*/

        foreach ($products as $i => $p) {
            $cant = str_replace('.', '', $qty[$i]);
            $cant = str_replace(',', '', $cant);
            if ($p != "") {
                OrderProduct::create([
                    'purchase_order_id' => $purchase->id,
                    'product_id' => $products[$i],
                    /*'type' => $type[$i],*/
                    'qty' => $cant,
                ]);
            }
        }

        return response(json_encode($purchase), 201)->header('Content-Type', 'text/json');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', OrderPurchase::class);
        return view('order-purchases.show', [
            'purchase' => OrderPurchase::find($id),
            'sellers' => User::where('status', 'activo')->orderBy('name')->get(),
            'providers' => Provider::where('status', 'activo')->orderBy('company')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patien)
    {
        $this->authorize('update', OrderPurchase::class);

        return view('patients.edit', [
            'patien' => $patien,
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'eps' => Filter::where(['status' => 'activo', 'type' => 'eps'])->orderBy('name')->get(),
            'contact_sources' => ContactSource::where(['status' => 'activo'])->orderBy('name')->get(),
            'cities' => State::find($patien->state_id)->cities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patien)
    {
        $this->authorize('update', OrderPurchase::class);
        request()->validate([
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'gender_id' => 'required|integer',
            'service_id' => 'required|integer',
            'contact_source_id' => 'required|integer',
            'cellphone' => 'required|numeric|unique:patients',
        ]);


        $patien->update($request->all());

        if ($request->file('photo')) {
            $path = $request->file('photo')->store('profile');
            $patien->update([
                'photo' => $path
            ]);
        }


        return redirect()->route('patients.index')
            ->with('success','Paciente actualizado exitosamente.');
    }

    public function approved(Request $request)
    {
        $this->authorize('create', PurchaseOrder::class);
        request()->validate([
            'id' => 'required|integer',
            'provider_id' => 'required|integer',
            'receive_id' => 'required|integer',
            'delivery' => 'required|string|max:80',
            'comment' => 'required|string|min:3'
        ]);
        $purchase = OrderPurchase::find($request->id);
        $id_purchase = OrderPurchase::max('id_purchase');
        $purchase->update([
            'status' => 'enviado',
            'id_purchase' => $id_purchase + 1,
            'provider_id' => $request->provider_id,
            'receive_id' => $request->receive_id,
            'delivery' => $request->delivery,
            'comment' => $request->comment
        ]);
        return response(json_encode($purchase), 201)->header('Content-Type', 'text/json');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', OrderPurchase::class);
        $order = OrderPurchase::find($id);
        if($order->status != 'pedido'){
            return redirect()->route('order-purchases.index')
                ->with('success','Orden de pedido ya ha cambiado de estado');
        }
        $order->delete();
        $orderProduct = OrderProduct::where('purchase_order_id',$id)->get();
        foreach ($orderProduct as $op){
            $delete = OrderProduct::find($op->id);
            $delete->delete();
        }
        return redirect()->route('order-purchases.index')
            ->with('success','Orden de pedido eliminada exitosamente');
    }

    public function generatePDF($id)
    {
        $data = Contract::find($id);
        $pdf = $this->pdf->loadView('pdf.contract', ['data' => $data]);
        return $pdf->stream('Contrato-Smadia.pdf');
        //return view('pdf.contract');
    }

    public function PDFEmail($id)
    {
        $data = Contract::find($id);
        $pdf = $this->pdf->loadView('pdf.contract', ['data' => $data]);
        return $pdf->output();
        //return view('pdf.contract');
    }
}
