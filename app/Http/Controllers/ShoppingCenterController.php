<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCenter;
use Illuminate\Http\Request;

class ShoppingCenterController extends Controller
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
        $this->authorize('view', ShoppingCenter::class);
        $data = ShoppingCenter::orderByDesc('created_at')->get();
        return view('shopping-centers.index', ['shopping_centers' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ShoppingCenter::class);
        return view('shopping-centers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', ShoppingCenter::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|alpha|max:8',
        ]);


        ShoppingCenter::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('shopping-centers.index')
            ->with('success','Centro de compra creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', ShoppingCenter::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCenter $shopping_center)
    {
        $this->authorize('update', ShoppingCenter::class);
        return view('shopping-centers.edit',['shopping_center' => $shopping_center]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCenter $shopping_center)
    {
        $this->authorize('update', ShoppingCenter::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|alpha|max:8',
        ]);


        $shopping_center->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('shopping-centers.index')
            ->with('success','Centro de compra actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCenter $shopping_center)
    {
        $this->authorize('delete', ShoppingCenter::class);
        $shopping_center->delete();
        return redirect()->route('shopping-centers.index')
            ->with('success','Centro de compra eliminado exitosamente');
    }
}
