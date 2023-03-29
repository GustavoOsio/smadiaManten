<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CosmetologicalEvolution;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CosmetologicalEvolutionController extends Controller
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

    public function show($id)
    {
        $this->authorize('view', CosmetologicalEvolution::class);
        $patient = session()->get('patient');
        $idBefore = CosmetologicalEvolution::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('cosmetological-evolution.index', [
            'products' => 'fedf',
            'idBefore' => $idBefore,
            'patient_id'=>$id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        $types = Type::where('status', 'activo')->orderBy('name')->get();
        $providers = Provider::where('status', 'activo')->orderBy('company')->get();
        return view('products.create', ['types' => $types, 'providers' => $providers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', CosmetologicalEvolution::class);
        request()->validate([
            'evolution' => 'required|string|min:4',
        ]);
        $CosmetologicalEvolution =  CosmetologicalEvolution::create($request->except('user_id'));
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $CosmetologicalEvolution->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
        ]);
        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $todayh = getdate();
        $d = date("d");
        $m = date("m");
        $y = $todayh['year'];
        $date = $d.'/'.$m.'/'.$y;
        $medicalHistory = MedicalHistory::create([
            'user_id'=> $id->id,
            'id_type'=>10,
            'id_relation'=>$CosmetologicalEvolution->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);
        return redirect()->route('cosmetological-evolution.show',$request->patient_id)
            ->with('success','Evolución Cosmetológica creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function show($id)
    {
        $this->authorize('view', Product::class);
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CosmetologicalEvolution $CosmetologicalEvolution)
    {
        $this->authorize('update', CosmetologicalEvolution::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = CosmetologicalEvolution::find($id[2]);
        return view('cosmetological-evolution.show',[
            'value'=>$value,
            'patient_id'=>$value->patient_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CosmetologicalEvolution $CosmetologicalEvolution)
    {
        $this->authorize('update', CosmetologicalEvolution::class);
        request()->validate([
            'evolution' => 'required|string|min:4',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $CosmetologicalEvolution = CosmetologicalEvolution::find($id[2]);
        $CosmetologicalEvolution->update($request->all());
        return redirect()->route('cosmetological-evolution.edit',$id[2])
            ->with('success','Evolución Cosmetológica actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', Product::class);
        $product->delete();
        return redirect()->route('products.index')
            ->with('success','Producto eliminado exitosamente');
    }
}
