<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use App\Models\comisionesmedicas;
use App\Models\Service;
use App\Models\CenterCost;
use App\User;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComisionesExport;
use App\Models\Income;
use App\Models\PaymentAssistance;
use App\Models\procedimientosmeta;
use App\Models\SaleProduct;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\metasMedico;
use App\Models\mesesdelanio;

class comisionesMedicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = comisionesmedicas::orderByDesc('created_at')->get();
        $medicos = User::where('role_id', 2)->orderByDesc('created_at')->get();
        return view('comisionesMedicas.index', ['cellars' => $data, 'medicos' => $medicos]);
    }

    public function medico(Request $request)
    {
        $data = comisionesmedicas::orderByDesc('created_at')->get();
        $medicos = User::where('role_id', 2)->orderByDesc('created_at')->get();
        return view('comisionesMedicas.index', ['cellars' => $data, 'medicos' => $medicos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = User::where('role_id', 2)->orderByDesc('created_at')->get();
        $Service = CenterCost::where('status', 'activo')->orderBy('name', 'ASC')->get();
        $mesanio = mesesdelanio::all();
        $metasCreadas = metasMedico::where('activo','1')->with('mes_meta')->with('medico_meta')->get();

        return view(
            'comisionesMedicas.create',
            [
                'med' => $data,
                'medicos' => $data,
                'services' => $Service,
                'meses' => $mesanio,
                'metas' => $metasCreadas,

            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //Crear meta medico
            $metaMedico = new metasMedico();
            $metaMedico->id_medico = $request->medico;
            $metaMedico->meta_mes = $request->meta;
            $metaMedico->mes = $request->mes;
            $metaMedico->activo = $request->estado;

            $metaMedico->save();

            return response(json_encode($metaMedico), 200)->header('Content-Type', 'text/json');
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
    public function show(Request $request)
    {

        switch ($request->tipo) {
            case '1':
                #Buscar la meta medica especifica recibiendo el id 
                try {
                    $data = metasMedico::where('id_tbl_metaMedico', $request->id_meta)->get();
                    return $data;
                } catch (\Throwable $th) {
                    throw $th;
                };
                break;

            default:
                # code...
                break;
        }
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
     
        request()->validate([
            'id' => 'required',
            'tipo' => 'required',
        ]);
        switch ($request->tipo) {
            case '1':
                try {
                    // 'id_tbl_metaMedico',

                  $update=  metasMedico::where('id_tbl_metaMedico', $request->id)
                        ->update([
                            'id_medico' => $request->id_medico,
                            'meta_mes' => $request->meta,
                            'mes' => $request->mes,
                            'activo' => $request->estado
                        ]);
                        return response(json_encode($update), 200)->header('Content-Type', 'text/json');
                } catch (\Throwable $th) {
                    throw $th;
                }
                break;

            default:
                # code...
                break;
        }
        // $this->authorize('update', Cellar::class);
        // request()->validate([
        //     'name' => 'required|string|min:3|max:100',
        //     'status' => 'required|alpha|max:8',
        // ]);


        // $cellar->update([
        //     'name' => $request->name,
        //     'status' => $request->status,
        // ]);

        // return redirect()->route('cellars.index')
        //     ->with('success', 'Bodega actualizada exitosamente.');
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



    public function export(Request $request)
    {
        //return  $request;

        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "idMedico" =>  $request->idMedico
        ];
        $date_start = $request->query("date_start");
        $date_end = $request->query("date_end");
        $date_end = new \Carbon\Carbon($date_end);
        $date_end = $date_end->addDays(1);
        $idMedico = $request->idMedico;



        return Excel::download(new ComisionesExport($data), 'ComisionesMedicas.xlsx');
    }
    public function create_meta_medico(Request $req)
    {
        return "Hola mundo";
    }
}
