<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InfirmaryEvolution;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfirmaryEvolutionController extends Controller
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
        $this->authorize('view', InfirmaryEvolution::class);
        $patient = session()->get('patient');
        $idBefore = InfirmaryEvolution::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('infirmary-evolution.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
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
        $this->authorize('create', InfirmaryEvolution::class);
        request()->validate([
            'evolution' => 'required|string|min:1',
        ]);

        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $array_db = array();
        $cont = 0;
        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $input = 'evolution'.$i;
                $array_db[$cont] = $request->input($input);
                $cont= $cont + 1;
            }
        }

        $infirmary = new InfirmaryEvolution();
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $infirmary->user_id = $id->id;
        $infirmary->patient_id = $patient->id;
        $infirmary->evolution = $request->input('evolution');
        $infirmary->array_evolutions = json_encode($array_db);
        $infirmary->save();

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
            'id_type'=>11,
            'id_relation'=>$infirmary->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('infirmary-evolution.show',$request->patient_id)
            ->with('success','Evolución de Enfermería creada exitosamente.');
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
    public function edit(InfirmaryEvolution $InfirmaryEvolution)
    {
        $this->authorize('update', InfirmaryEvolution::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = InfirmaryEvolution::find($id[2]);
        $relation = json_decode($value->array_evolutions);
        return view('infirmary-evolution.show',[
            'value'=>$value,
            'relation'=>$relation,
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
    public function update(Request $request, InfirmaryEvolution $product)
    {
        $this->authorize('update', InfirmaryEvolution::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $InfirmaryEvolution = InfirmaryEvolution::find($id[2]);
        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $array_db = array();
        $cont = 0;
        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] != 'no'){
                $input = 'evolution'.$i;
                $array_db[$cont] = $request->input($input);
                $cont= $cont + 1;
            }
        }
        $InfirmaryEvolution->evolution = $request->input('evolution');
        $InfirmaryEvolution->array_evolutions = json_encode($array_db);
        $InfirmaryEvolution->save();

        return redirect()->route('infirmary-evolution.edit',$id[2])
            ->with('success','Evolución de Enfermería actualizada exitosamente.');
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
