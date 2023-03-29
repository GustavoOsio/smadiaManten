<?php

namespace App\Http\Controllers;

use App\Models\Requisitions;
use App\Models\RequisitionsProducts;
use App\Models\RequisitionsProductCategory;
use App\Models\RequisitionsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RequisitionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $this->authorize('view', Requisitions::class);
        return view('requisitions.index', [
            'requisitions' => Requisitions::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Requisitions::class);
        return view('requisitions.create', [
            'category' => RequisitionsCategory::all(),
            'products' => RequisitionsProductCategory::all()
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
        $this->authorize('create', Requisitions::class);
        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $Requisitions = new Requisitions();
        $observations = $request->input('observations');
        $Requisitions->observations = $observations;
        $Requisitions->save();

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RequisitionsProducts = new RequisitionsProducts();
                $Requisitions_id = $Requisitions->id;
                $product = $request->input('product'.$i);
                $category = $request->input('category'.$i);
                $RequisitionsProducts->create([
                    'requisition_id' =>$Requisitions_id,
                    'category' =>$category,
                    'product' =>$product,
                ]);
            }
        }

        return redirect()->route('requisitions.index')
            ->with('success','Requisicion creada exitosamente.');
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
        $this->authorize('update', Requisitions::class);
        return view('requisitions.edit', [
            'category' => RequisitionsCategory::all(),
            'products' => RequisitionsProductCategory::all(),
            'requisition' => Requisitions::find($id),
            'relation' => RequisitionsProducts::where('requisition_id',$id)->get(),
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
        $this->authorize('update', Requisitions::class);
        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $Requisitions = Requisitions::find($id);
        $observations = $request->input('observations');
        $Requisitions->observations = $observations;
        $Requisitions->save();

        for($i = 0; $i < count($vector); ++$i){
            $Requisitions_id = $Requisitions->id;
            $category = $request->input('category'.$i);
            $product = $request->input('product'.$i);
            if($vector[$i] == 'si'){
                $id_rel =  $request->input('id_rel'.$i);
                $RequisitionsProducts = RequisitionsProducts::find($id_rel);
                $RequisitionsProducts->update([
                    'category' =>$category,
                    'product' =>$product,
                ]);
            }else if($vector[$i] == 'new'){
                $RequisitionsProducts = new RequisitionsProducts();
                $RequisitionsProducts->create([
                    'requisition_id' =>$Requisitions_id,
                    'category' =>$category,
                    'product' =>$product,
                ]);
            }
        }

        return redirect()->route('requisitions.index')
            ->with('success','Requisicion actualizada exitosamente.');
    }

    public function cumplir($id)
    {
        $this->authorize('update', Requisitions::class);
        $cumplir = Requisitions::find($id);
        $cumplir->status = 'cumplida';
        $cumplir->save();
        return redirect()->route('requisitions.index')
            ->with('success','Requisicion cumplida exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Requisitions::class);
        $Requisitions = Requisitions::find($id);
        $requisitionProducts = RequisitionsProducts::where('requisition_id',$Requisitions->id)->get();
        foreach($requisitionProducts as $pro){
            $delete = RequisitionsProducts::find($pro->id);
            $delete->delete();
        }
        $Requisitions->delete();
        return redirect()->route('requisitions.index')
            ->with('success','Requisicion eliminada exitosamente.');
    }
}
