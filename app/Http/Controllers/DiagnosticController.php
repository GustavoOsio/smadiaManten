<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diagnostic;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
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
        $this->authorize('view', Diagnostic::class);
        $data = Diagnostic::orderByDesc('created_at')->get();
        return view('diagnostics.index', ['diagnostics' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Diagnostic::class);
        return view('diagnostics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Diagnostic::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'type' => 'required|alpha|max:11',
            'status' => 'required|alpha|max:8',
        ]);


        Diagnostic::create([
            'name' => $request->name,
            'type' => $request->type,
            'code' => $request->code,
            'status' => $request->status,
        ]);


        return redirect()->route('diagnostics.index')
            ->with('success','Diagnóstico creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Diagnostic::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnostic $diagnostic)
    {
        $this->authorize('update', Diagnostic::class);
        return view('diagnostics.edit',['diagnostic' => $diagnostic]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diagnostic $diagnostic)
    {
        $this->authorize('update', Diagnostic::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|alpha|max:11',
            'code' => 'required|string|max:255',
            'status' => 'required|alpha|max:8',
        ]);


        $diagnostic->update([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('diagnostics.index')
            ->with('success','Diagnóstico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnostic $diagnostic)
    {
        $this->authorize('delete', Diagnostic::class);
        $diagnostic->delete();
        return redirect()->route('diagnostics.index')
            ->with('success','Diagnóstico eliminado exitosamente');
    }
}
