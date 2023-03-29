<?php

namespace App\Http\Controllers;

use App\Models\Requisitions;
use App\Models\RequisitionsProducts;
use App\Models\RequisitionsProductCategory;
use App\Models\RequisitionsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RequisitionsProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $this->authorize('view', RequisitionsProductCategory::class);
        return view('requisitions-product-category.index', [
            'requisitionsProductCategory' =>  RequisitionsProductCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', RequisitionsProductCategory::class);
        return view('requisitions-product-category.create',[
            "requisitionsCategory"=>RequisitionsCategory::all()
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
        $this->authorize('create', RequisitionsProductCategory::class);
        foreach ([
            "requisition_category_id"=>$request->category,
            "name"=>$request->name
        ] as $value) {
            //dd($value);
            if($value==""){
                return redirect()->route('requisitions-product-category.create')
                ->with('danger','Llene todos los campos.');
            }
        }
        RequisitionsProductCategory::create([
            "requisition_category_id"=>$request->category,
            "name"=>$request->name
        ]);

        return redirect()->route('requisitions-product-category.index')
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
        dd("dds");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', RequisitionsProductCategory::class);
        $product = RequisitionsProductCategory::find($id);
        return view('requisitions-product-category.edit',[
            'product'=>$product,
            "requisitionsCategory"=>RequisitionsCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', RequisitionsProductCategory::class);
        foreach ([
                     "requisition_category_id"=>$request->category,
                     "name"=>$request->name
                 ] as $value) {
            //dd($value);
            if($value==""){
                return redirect()->route('requisitions-product-category.edit')
                    ->with('danger','Llene todos los campos.');
            }
        }

        $update = RequisitionsProductCategory::find($id);
        $update->requisition_category_id = $request->category;
        $update->name = $request->name;
        $update->update();
        return redirect()->route('requisitions-product-category.index')
            ->with('success','Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', RequisitionsProductCategory::class);
        $delete = RequisitionsProductCategory::find($id);
        $delete->delete();
        return redirect()->route('requisitions-product-category.index')
            ->with('success','Producto eliminado exitosamente.');
    }
}
