<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticAids;
use App\Models\Laboratory;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
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
        $this->authorize('view', Laboratory::class);
        $data = Laboratory::orderByDesc('created_at')->get();
        return view('laboratories.index', ['laboratories' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Laboratory::class);
        $diagnostics = DiagnosticAids::where('status','activo')->get();
        return view('laboratories.create',['diagnostics'=>$diagnostics]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Laboratory::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'status' => 'required|alpha|max:8',
        ]);


        Laboratory::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);


        return redirect()->route('laboratories.index')
            ->with('success','Laboratorio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Laboratory::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratory $laboratory)
    {
        $this->authorize('update', Laboratory::class);
        $diagnostics = DiagnosticAids::where('status','activo')->get();
        return view('laboratories.edit',['laboratory' => $laboratory,'diagnostics'=>$diagnostics]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        $this->authorize('update', Laboratory::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'status' => 'required|alpha|max:8',
        ]);
        $laboratory->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('laboratories.index')
            ->with('success','Laboratorio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratory $laboratory)
    {
        $this->authorize('delete', Laboratory::class);
        $laboratory->delete();
        return redirect()->route('laboratories.index')
            ->with('success','Laboratorio eliminado exitosamente');
    }
}
