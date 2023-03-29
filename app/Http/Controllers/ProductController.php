<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderFormProducts;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
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
        $this->authorize('view', Product::class);
        $data = Product::orderByDesc('created_at')->get();
        $type = Type::where('status', 'activo')->where('type', 'inventory')->orderBy('name')->get();

        $user = Auth::user();
        return view('products.index', [
            'products' => $data,
            'type'=>$type,
            'user'=>$user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        $types = Type::where('status', 'activo')->orderBy('name')->get();
        $providers = Provider::where('status', 'activo')->orderBy('company')->get();
        return view('products.create', ['types' => $types, 'providers' => $providers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'reference' => 'required|string|max:30',
            'tax' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'presentation_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'category_id' => 'required|integer',
            'inventory_id' => 'required|integer',
            //'provider_id' => 'required|integer',
            'form' => 'required|alpha|max:8',
            'status' => 'required|alpha|max:8',
            'price_vent' => 'required|numeric',
            'invima' => 'required',
            'date_invima' => 'required',
            'por_comision' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success','Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Product::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', Product::class);
        $types = Type::where('status', 'activo')->orderBy('name')->get();
        $providers = Provider::where('status', 'activo')->orderBy('company')->get();
        return view('products.edit',['product' => $product, 'types' => $types, 'providers' => $providers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', Product::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'reference' => 'required|string|max:30',
            'tax' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'presentation_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'category_id' => 'required|integer',
            'inventory_id' => 'required|integer',
            //'provider_id' => 'required|integer',
            'form' => 'required|alpha|max:8',
            'status' => 'required|alpha|max:8',
            'price_vent' => 'required|numeric',
            'invima' => 'required',
            'date_invima' => 'required',
            'por_comision' => 'required',
        ]);


        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success','Producto actualizado exitosamente.');
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

    public function search(Request $request) {
        request()->validate([
            'id' => 'required|integer'
        ]);
        $product = Product::select('*')
            ->with('presentation', 'unit')
            ->find($request->id);
        if($request->validate == 0){
            $orderProducts = OrderProduct::where('order_products.product_id',$request->id)
                ->join('purchase_orders','purchase_orders.id','order_products.purchase_order_id')
                ->whereIn('purchase_orders.status',['pedido','enviado'])
                ->select('order_products.*',DB::raw('SUM(qty - missing) as totaly'))
                ->groupBy('product_id')
                ->get();
            $qty = 0;
            foreach ($orderProducts as $o){
                if($o->totaly > 0){
                    $qty = $qty + $o->totaly;
                }
            }
        }else{
            $orderForm = OrderFormProducts::where('order_form_id',$request->validate)
                ->where('product_id',$request->id)
                ->select('order_form_products.*',DB::raw('SUM(qty) as totaly'))
                ->groupBy('product_id')
                ->get();
            $qty = 0;
            foreach ($orderForm as $o){
                if($o->totaly > 0){
                    $qty = $qty + $o->totaly;
                }
            }
        }

        if($request->provider_id == 0){
            //if($product->cost == ''){
                $cost = "0.00";
            //}else{
                //$cost = $product->cost;
            //}
        }else{
            $providerHistorial = \App\Models\ProviderHistorial::where('provider_id',$request->provider_id)
                ->where('product_id',$request->id)
                ->get();
            if(count($providerHistorial)>0){
                $cost = $providerHistorial[0]->cost;
            }else{
                //if($product->cost == ''){
                    $cost = "0.00";
                //}else{
                    //$cost = $product->cost;
                //}
            }
        }
        $data['first'] = $product;
        $data['second'] = $qty;
        $data['third'] = $cost;
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "type" => $request->query("type")
        ];
        return Excel::download(new ProductExport($data), 'Productos.xlsx');
    }

    public function searchHistory(Request $request)
    {
        $id = $request->id;
        $purchase = \App\Models\PurchaseProduct::where('product_id',$id)
            ->where('qty_inventory','>',0)
            ->where('inventory','si')
            ->get();
        $personalInventory = \App\Models\PersonalInventory::where('product_id',$id)
            ->where('qty','>',0)
            ->get();
        $transferObs = \App\Models\TransferWineryObservations::where('product_id',$id)
            ->where('qty_falt','>',0)
            ->groupBy('product_id')
            ->select('product_id',DB::raw('SUM(qty_falt) as totaly'))
            ->get();
        return view('products.history',[
            'purchase'=>$purchase,
            'personalInventory'=>$personalInventory,
            'transferObs'=>$transferObs
        ]);
    }
}
