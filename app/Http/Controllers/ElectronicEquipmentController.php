<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ElectronicEquipment;
use Illuminate\Http\Request;

class ElectronicEquipmentController extends Controller
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
        $data = ElectronicEquipment::orderByDesc('created_at')->get();
        return view('electronic-equipments.index', ['equipments' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('electronic-equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|string|max:60',
            'number' => 'required|string|max:30',
            'brand' => 'required|string|max:60',
            'model' => 'required|string|max:30',
            'serial' => 'required|string|max:30',
            'voltage' => 'required|string|max:30',
            'location' => 'required|string|max:120',
            'status' => 'required|alpha|max:8',
        ]);


        ElectronicEquipment::create($request->all());


        return redirect()->route('electronic-equipments.index')
            ->with('success','Equipo creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ElectronicEquipment $electronicEquipment)
    {
        return view('electronic-equipments.edit',['equipment' => $electronicEquipment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ElectronicEquipment $electronicEquipment)
    {
        request()->validate([
            'name' => 'required|string|max:60',
            'number' => 'required|string|max:30',
            'brand' => 'required|string|max:60',
            'model' => 'required|string|max:30',
            'serial' => 'required|string|max:30',
            'voltage' => 'required|string|max:30',
            'location' => 'required|string|max:120',
            'status' => 'required|alpha|max:8',
        ]);


        $electronicEquipment->update($request->all());

        return redirect()->route('electronic-equipments.index')
            ->with('success','Equipo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ElectronicEquipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('electronic-equipments.index')
            ->with('success','Equipo eliminado exitosamente');
    }
}
