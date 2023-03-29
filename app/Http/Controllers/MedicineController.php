<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
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
        $this->authorize('view', Medicine::class);
        $data = Medicine::orderByDesc('created_at')->get();
        return view('medicines.index', ['medicines' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Medicine::class);
        return view('medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Medicine::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        Medicine::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('medicines.index')
            ->with('success','Medicamento biológico creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Medicine::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicine $medicine)
    {
        $this->authorize('update', Medicine::class);
        return view('medicines.edit',['medicine' => $medicine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicine $medicine)
    {
        $this->authorize('update', Medicine::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        $medicine->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('medicines.index')
            ->with('success','Medicamento biológico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine)
    {
        $this->authorize('delete', Medicine::class);
        $medicine->delete();
        return redirect()->route('medicines.index')
            ->with('success','Medicamento biológico eliminado exitosamente');
    }
}
