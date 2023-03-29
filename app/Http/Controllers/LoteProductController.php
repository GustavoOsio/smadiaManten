<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoteProducts;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoteProductExport;
use App\Models\PurchaseProduct;
use App\Models\Purchase;
class LoteProductController extends Controller
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
        //$this->authorize('view', PurchaseProduct::class);
        $data = Purchase::orderByDesc('created_at')->get();
        return view('lote-products.index', [
            'Purchase' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', PurchaseProduct::class);
        $products = Product::where('status', 'activo')->orderBy('name')->get();
        return view('lote-products.create', [ 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', LoteProducts::class);
        request()->validate([
            'product_id' => 'required|numeric',
            'lote' => 'required|string|max:199',
            'cant' => 'required|numeric',
            'date' => 'required|string|max:199',
        ]);
        LoteProducts::create($request->all());
        return redirect()->route('lote-products.index')
            ->with('success','Lote de producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', LoteProducts::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseProduct $product)
    {
        $this->authorize('update', LoteProducts::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $product = PurchaseProduct::all()->where("purchase_id",$id[2]);
        
        $purchase = Purchase::all()->where("id",$id[2])->first();
        return view('lote-products.edit', ['purchase'=>$purchase,'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseProduct $product)
    {
        $this->authorize('update', LoteProducts::class);
        
/*         request()->validate([
            'purchase_products_id' => 'required|numeric',
            'lote' => 'required|string|max:199',
            'expiration' => 'required|string|max:199',
            //'missing' => 'required|string',
            //'full_amount'=>'required|string',
            'qty' => 'required|numeric',
        ]); */
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $ft=false;
        $purch;
        foreach ($request->lote as $key => $value) {
            $product = PurchaseProduct::find($request->purchase_products_id[$key]);
            $resp=[
                //'purchase_products_id' => $request->purchase_products_id[$key],
                'lote' => $request->lote[$key],
                'expiration' => $request->expiration[$key],
                'missing' => $request->missing[$key],
                'full_amount'=>$request->full_amount[$key],
                'qty' => (intval($request->full_amount[$key])-intval($request->missing[$key])),
            ];
            $product->update($resp);
            if(intval($request->missing[$key])!=0){
                $ft=true;
            }
            $purch=Purchase::find($product->purchase_id);
        }
        if($ft){
            $purch
            ->update([
                "status"=>"incompleta",
            ]);
        }else{
            $purch
            ->update([
                "status"=>"activo",
            ]);
        }
        return redirect()->route('lote-products.index')
            ->with('success','Lote de Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoteProducts $LoteProducts)
    {
        $this->authorize('delete', LoteProducts::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $LoteProducts = LoteProducts::find($id[2]);
        $LoteProducts->delete();
        return redirect()->route('lote-products.index')
            ->with('success','Lote de Producto eliminado exitosamente');
    }

    public function search(Request $request) {
        request()->validate([
            'id' => 'required|integer'
        ]);
        $product = Product::with('presentation', 'unit')->find($request->id);
        return response(json_encode($product), 200)->header('Content-Type', 'text/json');
    }

    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
        ];
        return Excel::download(new LoteProductExport($data), 'LoteProductos.xlsx');
    }
}
