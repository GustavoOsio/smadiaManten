<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticAids;
use Illuminate\Http\Request;

class DiagnosticAidsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', DiagnosticAids::class);
        $data = DiagnosticAids::orderByDesc('created_at')->get();
        return view('diagnostic_aids.index', ['diagnostic_aids' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', DiagnosticAids::class);
        return view('diagnostic_aids.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', DiagnosticAids::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|alpha|max:8',
        ]);


        DiagnosticAids::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('diagnostic_aids.index')
            ->with('success','Ayuda Diagnostica creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiagnosticAids  $diagnosticAids
     * @return \Illuminate\Http\Response
     */
    public function show(DiagnosticAids $diagnosticAids)
    {
        $this->authorize('view', DiagnosticAids::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiagnosticAids  $diagnosticAids
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', DiagnosticAids::class);
        $diagnostic_aids = DiagnosticAids::find($id);
        return view('diagnostic_aids.edit',['diagnostic_aids' => $diagnostic_aids]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiagnosticAids  $diagnosticAids
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', DiagnosticAids::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|alpha|max:8',
        ]);
        $diagnosticAids = DiagnosticAids::find($request->id);
        $diagnosticAids->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return redirect()->route('diagnostic_aids.index')
            ->with('success','Ayuda Diagnostica actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiagnosticAids  $diagnosticAids
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', DiagnosticAids::class);
        $diagnosticAids = DiagnosticAids::find($id);
        $diagnosticAids->delete();
        return redirect()->route('diagnostic_aids.index')
            ->with('success','Ayuda Diagnostica eliminada exitosamente');
    }


    public function delete($id)
    {
        $this->authorize('delete', DiagnosticAids::class);
        $diagnosticAids = DiagnosticAids::find($id);
        $diagnosticAids->delete();
        return redirect()->route('diagnostic_aids.index')
            ->with('success','Ayuda Diagnostica eliminada exitosamente');
    }
}
