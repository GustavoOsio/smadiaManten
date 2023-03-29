<?php

namespace App\Http\Controllers;

use App\Models\Requisitions;
use App\Models\RequisitionsProducts;
use App\Models\RequisitionsProductCategory;
use App\Models\RequisitionsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RequisitionsCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $this->authorize('view', RequisitionsCategory::class);
        return view('requisitions-category.index', [
            'requisitionsCategory' =>  RequisitionsCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', RequisitionsCategory::class);
        return view('requisitions-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', RequisitionsCategory::class);
        RequisitionsCategory::create([
            "name"=>$request->name
        ]);
        return redirect()->route('requisitions-category.index')
        ->with('success','Categoría creada exitosamente.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', RequisitionsCategory::class);
        $category = RequisitionsCategory::find($id);
        return view('requisitions-category.edit',[
            'category'=>$category
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
        $this->authorize('update', RequisitionsCategory::class);
        $update = RequisitionsCategory::find($id);
        $update->name = $request->name;
        $update->update();
        return redirect()->route('requisitions-category.index')
            ->with('success','Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', RequisitionsCategory::class);
        $delete = RequisitionsCategory::find($id);
        $delete->delete();
        return redirect()->route('requisitions-category.index')
            ->with('success','Categoría eliminada exitosamente.');
    }
}
