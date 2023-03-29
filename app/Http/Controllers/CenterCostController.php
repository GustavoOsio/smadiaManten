<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CenterCost;
use Illuminate\Http\Request;

class CenterCostController extends Controller
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
        $this->authorize('view', CenterCost::class);
        $data = CenterCost::orderByDesc('created_at')->get();
        return view('center-costs.index', ['costs' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', CenterCost::class);
        return view('center-costs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', CenterCost::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'type' => 'required|alpha|max:8',
            'status' => 'required|alpha|max:8',
        ]);


        CenterCost::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);


        return redirect()->route('center-costs.index')
            ->with('success','Centro de costo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', CenterCost::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CenterCost $center_cost)
    {
        $this->authorize('update', CenterCost::class);
        return view('center-costs.edit',['center_cost' => $center_cost]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CenterCost $center_cost)
    {
        $this->authorize('update', CenterCost::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'type' => 'required|alpha|max:8',
            'status' => 'required|alpha|max:8',
        ]);


        $center_cost->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('center-costs.index')
            ->with('success','Centro de costo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CenterCost $center_cost)
    {
        $this->authorize('delete', CenterCost::class);
        $center_cost->delete();
        return redirect()->route('center-costs.index')
            ->with('success','Centro de costo eliminado exitosamente');
    }
}
