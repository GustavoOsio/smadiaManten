<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use App\Models\comisionesdepartamentos;
use App\Models\presupuesto_venta;
use App\Models\Service;
use App\Models\Role;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Cell;

class PresupuestoVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = presupuesto_venta::with('relacion_mes')->get();
        return view('presupuestoVenta.index', ['productos' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Product::orderByDesc('created_at')->get();
        $Service = Service::where('status', 'activo')->orderByDesc('created_at')->get();

        return view('productosComisiones.create', ['productos' => $data, 'services' => $Service]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'Lipoval' => 'required',
            'Post' => 'required',
            'cabinas' => 'required',
            'depilacion' => 'required',
            'mesfiltro' => 'required',
            'metaGlobal' => 'required',
            'metaMad' => 'required',
            'suero' => 'required',
            'valoracion' => 'required',
            'diasHabiles' => 'required',
            'otros' => 'required'
        ]);

        try {
            $presupuestoVenta = new presupuesto_venta();
            $presupuestoVenta->metaTotal = $request->metaGlobal;
            $presupuestoVenta->metaMad = $request->metaMad;
            $presupuestoVenta->metaLipoval = $request->Lipoval;
            $presupuestoVenta->metaPost = $request->Post;
            $presupuestoVenta->metaCabinas = $request->cabinas;
            $presupuestoVenta->metaSuero = $request->suero;
            $presupuestoVenta->metaValoraciones = $request->valoracion;
            $presupuestoVenta->metaOtros = $request->otros;
            $presupuestoVenta->metaDepilacion = $request->depilacion;
            $presupuestoVenta->mes = $request->mesfiltro;
            $presupuestoVenta->diasHabiles = $request->diasHabiles;

            $presupuestoVenta->save();
            return response(json_encode($presupuestoVenta), 200)->header('Content-Type', 'text/json');
        } catch (\Throwable $th) {
            throw $th;
        }
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
        return view('cellars.edit', ['cellar' => $cellar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        
        // $this->authorize('update', presupuesto_venta::class);

        request()->validate([
            'id_presupuesto' => 'required'
        ]);
        try {
            $sql=presupuesto_venta::where('idPresupuesto',$request->id_presupuesto)->update([
                'metaTotal' => $request->metaGlobal,
                'metaMad' => $request->metaMad,
                'metaLipoval' => $request->Lipoval,
                'metaPost' => $request->Post,
                'metaCabinas' => $request->cabinas,
                'metaSuero' => $request->suero,
                'metaValoraciones' => $request->valoracion,
                'metaDepilacion' => $request->depilacion,
                'mes' => $request->mesfiltro,
                'diasHabiles' => $request->diasHabiles,
                'metaOtros' => $request->otros,
            ]);
            return response(json_encode($sql), 200)->header('Content-Type', 'text/json');
        } catch (\Throwable $th) {
            throw $th;
        }
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

    public function getPresupuesto(Request $req)
    {
        // $presupuesto = new presupuesto_venta();
        $sql = presupuesto_venta::where('idPresupuesto', $req->id)->first();
        try {
            return $sql;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
