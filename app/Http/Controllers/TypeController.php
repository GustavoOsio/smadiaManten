<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
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
        $this->authorize('view', Type::class);
        $data = Type::orderByDesc('created_at')->get();
        return view('types.index', ['types' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Type::class);
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Type::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'type' => 'required|string|max:20',
            'status' => 'required|alpha|max:8',
            'p_deducible_t' => 'required|numeric',
            'p_deducible_no' => 'required|numeric',
            'p_comision' => 'required|numeric',
        ]);


        Type::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'p_deducible_t' => $request->p_deducible_t,
            'p_deducible_no' => $request->p_deducible_no,
            'p_comision' => $request->p_comision,

        ]);


        return redirect()->route('types.index')
            ->with('success','Categoria de producto creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Type::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        $this->authorize('update', Type::class);
        return view('types.edit',['type' => $type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $this->authorize('update', Type::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'type' => 'required|string|max:20',

            'status' => 'required|alpha|max:8',

        ]);


        $type->update([
            'name' => $request->name,
            'type' => $request->type,
            'p_deducible_t' => $request->p_deducible_t,
            'p_deducible_no' => $request->p_deducible_no,
            'p_comision' => $request->p_comision,
            'status' => $request->status,

        ]);

        return redirect()->route('types.index')
            ->with('success','Categoria de producto actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $this->authorize('delete', Type::class);
        $type->delete();
        return redirect()->route('types.index')
            ->with('success','Categoria de producto eliminada exitosamente');
    }
}
