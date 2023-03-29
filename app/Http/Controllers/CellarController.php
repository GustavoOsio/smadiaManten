<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Cell;

class CellarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Cellar::class);
        $data = Cellar::orderByDesc('created_at')->get();
        return view('cellars.index', ['cellars' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Cellar::class);
        return view('cellars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cellar::class);
        request()->validate([
            'name' => 'required|string|min:3|max:100',
            'status' => 'required|alpha|max:8',
        ]);


        Cellar::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('cellars.index')
            ->with('success','Bodega creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cellar $cellar)
    {
        $this->authorize('update', Cellar::class);
        return view('cellars.edit',['cellar' => $cellar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cellar $cellar)
    {
        $this->authorize('update', Cellar::class);
        request()->validate([
            'name' => 'required|string|min:3|max:100',
            'status' => 'required|alpha|max:8',
        ]);


        $cellar->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('cellars.index')
            ->with('success','Bodega actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
