<?php

namespace App\Http\Controllers;

use App\Models\ContactSource;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Item;
use App\Models\OrderProduct;
use App\Models\OrderPurchase;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\PurchaseOrder;
use App\Models\Service;
use App\Models\State;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderControllerOlder extends Controller
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
        //dd('hello');
        $this->authorize('view', PurchaseOrder::class);
        $data = PurchaseOrder::where('id_purchase', '!=', '')->orderByDesc('created_at')->get();
        return view('purchase-orders.index', ['purchases' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', PurchaseOrder::class);
        return view('purchase-orders.create', [
            'products' => Product::where('status', 'activo')->orderBy('name')->get(),
            'sellers' => User::where('status', 'activo')->orderBy('name')->get(),
            'providers' => Provider::where('status', 'activo')->orderBy('company')->get(),
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
        $this->authorize('create', PurchaseOrder::class);

        request()->validate([
            'receive_id' => 'required|integer',
            'products' => 'required|array',
            //'type' => 'required|array',
            //'area' => 'required|array',
            'qty' => 'required|array',
            'provider_id' => 'required|integer',
            'method_of_payment' => 'required|string',
            'way_of_payment' => 'required|string',
            'delivery' => 'required|string',
            'comment' => 'required|string|min:0|max:10000'
        ]);

        $id_purchase = PurchaseOrder::max('id_purchase');

        $purchase = PurchaseOrder::create([
            'receive_id' => $request->receive_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'provider_id' => $request->provider_id,
            'method_of_payment' => $request->method_of_payment,
            'way_of_payment' => $request->way_of_payment,
            'delivery' => $request->delivery,
            'status' => 'enviado',
            'id_purchase' => $id_purchase + 1
        ]);

        $products = $request->products;
        $qty = $request->qty;
        //$area = $request->area;
        //$type = $request->type;

        foreach ($products as $i => $p) {
            if ($p != "") {
                OrderProduct::create([
                    'purchase_order_id' => $purchase->id,
                    'product_id' => $products[$i],
//                    'type' => $type[$i],
                    'qty' => $qty[$i],
                    //'area' => $area[$i],
                ]);
            }
        }
//        $data = ["document" => $this->PDFEmail($purchase->id)];
//        Mail::to($contract->patient->email)->send(new \App\Mail\Contract($data, $contract));
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
        $this->authorize('view', PurchaseOrder::class);
        return view('purchase-orders.show', [
            'purchase' => PurchaseOrder::find($id)
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
        $this->authorize('update', PurchaseOrder::class);

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
        $this->authorize('update', PurchaseOrder::class);
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
        $this->authorize('update', PurchaseOrder::class);
        request()->validate([
            'id' => 'required|integer',
        ]);


        $contract = Contract::find($request->id);
        $contract->update(['status' => 'activo']);
        return response(json_encode(["message" => "Saved"]), 200)->header('Content-Type', 'text/json');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patien)
    {
        $this->authorize('delete', PurchaseOrder::class);
        $patien->delete();
        return redirect()->route('patients.index')
            ->with('success','Paciente eliminado exitosamente');
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
