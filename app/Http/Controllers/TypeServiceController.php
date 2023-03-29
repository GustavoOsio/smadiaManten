<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TypeService;
use Illuminate\Http\Request;

class TypeServiceController extends Controller
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
        $this->authorize('view', TypeService::class);
        $data = TypeService::orderByDesc('created_at')->get();
        return view('type-services.index', ['types_service' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', TypeService::class);
        return view('type-services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', TypeService::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        TypeService::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('type-services.index')
            ->with('success','Tipo de Servicio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', TypeService::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeService $type_service)
    {
        $this->authorize('update', TypeService::class);
        return view('type-services.edit',['type_service' => $type_service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeService $type_service)
    {
        $this->authorize('update', TypeService::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        $type_service->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('type-services.index')
            ->with('success','Tipo de Servicio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeService $type_service)
    {
        $this->authorize('delete', TypeService::class);
        $type_service->delete();
        return redirect()->route('type-services.index')
            ->with('success','Tipo de Servicio eliminado exitosamente');
    }
}
