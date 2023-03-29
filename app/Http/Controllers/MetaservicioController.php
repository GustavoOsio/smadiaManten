<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\mesesdelanio;
use App\Models\MetasLineaServicio;

class MetaservicioController extends Controller
{
    public function index()
    {
        $sql_servicios = Service::Where('status', 'activo')->get();

        return view('metasServicio.index', ['servicios' => $sql_servicios]);
    }

    public function create()
    {
        $sql_servicios = Service::Where('status', 'activo')->get();
        $mes = mesesdelanio::all();
        $metasCreadas = MetasLineaServicio::where('estado', '1')->with('servicio_meta')->with('mes_meta')->get();

        return view(
            'metasServicio.create',
            [
                'serviciosDisponibles' => $sql_servicios,
                'meses' => $mes,
                'meseselect' => $mes,
                'MetasCreadas' => $metasCreadas,
                'selectService' => $sql_servicios
            ]
        );
    }

    public function store(Request $request)
    {


        $metalinea = new MetasLineaServicio();

        $metalinea->servicio = $request->servicio;
        $metalinea->meta = $request->meta;
        $metalinea->mes = $request->mes;
        $metalinea->estado = $request->estado;

        $metalinea->save();
        return response(json_encode($metalinea), 200)->header('Content-Type', 'text/json');
    }

    public function show($id)
    {
        return $sql = MetasLineaServicio::where('id', $id)->with('servicio_meta')->with('mes_meta')->get();
    }
    public function update(Request $request)
    {
        $metas_linea= new MetasLineaServicio();
        $metas_linea->where('id',$request->id_meta)->update([
            'servicio' => $request->servicio,
            'meta' => $request->meta,
            'mes' => $request->mes,
            'estado' => $request->estado,
        ]);
        return response(json_encode($metas_linea), 200)->header('Content-Type', 'text/json');
    }
}
