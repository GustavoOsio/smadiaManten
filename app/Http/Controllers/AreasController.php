<?php

namespace App\Http\Controllers;


use App\Models\Areas;
use App\Models\Cellar;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AreasController extends Controller
{
    public function index()
    {
        $this->authorize('view', Areas::class);
        $data = Areas::where('status', 'activo')
            ->orderBy('name','asc')
            ->get();
        return view('areas.index', [
            'areas' => $data,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Areas::class);
        return view('areas.create',[
            'cellar' => Cellar::where('status','activo')
                ->orderBy('name','asc')
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Areas::class);
        request()->validate([
            'name' => 'required|string',
            'status' => 'required',
            'cellar_id' => 'required',
        ]);
        Areas::create([
            'name' => $request->name,
            'status' => $request->status,
            'cellar_id' => $request->cellar_id,
        ]);
        return redirect()->route('areas.index')
            ->with('success','Area creada exitosamente.');
    }

    public function edit(Areas $areas)
    {
        $this->authorize('update', Areas::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $areas = Areas::find($id[2]);
        return view('areas.edit', [
            'areas' => $areas,
            'cellar' => Cellar::where('status','activo')
                ->orderBy('name','asc')
                ->get()
        ]);
    }

    public function update(Request $request, Areas $areas)
    {
        $this->authorize('update', Areas::class);
        request()->validate([
            'name' => 'required|string',
            'status' => 'required',
            'cellar_id' => 'required',
        ]);
        $areas = Areas::find($request->id);
        $areas->update([
            'name' => $request->name,
            'status' => $request->status,
            'cellar_id' => $request->cellar_id,
        ]);
        return redirect()->route('areas.index')
            ->with('success','Area actualizada exitosamente.');
    }

    public function delete($id)
    {
        $this->authorize('delete', Areas::class);
        $areas = Areas::find($id);
        $areas->delete();
        return redirect()->route('areas.index')
            ->with('success','Area eliminada exitosamente');
    }

}
