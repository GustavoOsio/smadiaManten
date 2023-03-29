<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BiologicalMedicinePlan;
use App\Models\MedicalHistory;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiologicalMedicinePlanController extends Controller
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
        $this->authorize('view', BiologicalMedicinePlan::class);
        $patient = session()->get('patient');
        $idBefore = BiologicalMedicinePlan::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        $medicines = Medicine::where('status','activo')->orderBy('name','asc')->get();

        $last = BiologicalMedicinePlan::where('patient_id',$id)->get()->last();
        if(!empty($last)){
            $cicle = $last->cicle;
            $sesion = $last->sesion + 1;
        }else{
            $cicle = 1;
            $sesion = 1;
        }
        return view('biological-medicine-plan.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'medicines'=>$medicines,
            'cicle'=>$cicle,
            'sesion'=>$sesion,
            'patient_id'=>$id,
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
        $this->authorize('create', BiologicalMedicinePlan::class);
        request()->validate([
            'vector' => 'required|string|min:4',
            'cicle' => 'required|integer|min:1',
            'sesion' => 'required|integer|min:1',
        ]);

        $array = $request->input('vector');
        $vector = explode(',',$array);
        $array_db = array();
        $observation_db = array();
        $cont = 0;
        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] != 'no' && $vector[$i] != 'si'){
                $array_db[$cont] = $vector[$i];
                $observation_db[$cont] = $request->input('observation_'.$i);
                $cont= $cont + 1;
            }
        }

        $BiologicalMedicinePlan = new BiologicalMedicinePlan();
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $BiologicalMedicinePlan->user_id = $id->id;
        $BiologicalMedicinePlan->patient_id = $patient->id;
        $BiologicalMedicinePlan->array_biological_medicine = json_encode($array_db);
        $BiologicalMedicinePlan->array_observations = json_encode($observation_db);
        $BiologicalMedicinePlan->cicle = $request->input('cicle');
        $BiologicalMedicinePlan->sesion = $request->input('sesion');
        $BiologicalMedicinePlan->save();

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
            'id_type'=>7,
            'id_relation'=>$BiologicalMedicinePlan->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('biological-medicine-plan.show',$request->patient_id)
            ->with('success','Plan de Medicina Biologica creado exitosamente.');
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
    public function edit(BiologicalMedicinePlan $BiologicalMedicinePlan)
    {
        $this->authorize('update', BiologicalMedicinePlan::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = BiologicalMedicinePlan::find($id[2]);
        $relation = json_decode($value->array_biological_medicine);
        $observations = json_decode($value->array_observations);
        $medicines = Medicine::where('status','activo')->orderBy('name','asc')->get();
        return view('biological-medicine-plan.show',[
            'value'=>$value,
            'relation'=>$relation,
            'observations'=>$observations,
            'medicines'=>$medicines,
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
    public function update(Request $request, BiologicalMedicinePlan $BiologicalMedicinePlan)
    {
        $this->authorize('update', BiologicalMedicinePlan::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $BiologicalMedicinePlan = BiologicalMedicinePlan::find($id[2]);

        $array = $request->input('vector');
        $vector = explode(',',$array);
        $array_db = array();
        $observation_db = array();
        $cont = 0;
        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] != 'no'){
                $array_db[$cont] = $request->input('biological_medicine'.$i);
                $observation_db[$cont] = $request->input('observation_'.$i);
                $cont= $cont + 1;
            }
        }
        $BiologicalMedicinePlan->update([
            'array_biological_medicine' => json_encode($array_db),
            'array_observations' => json_encode($observation_db),
        ]);
        return redirect()->route('biological-medicine-plan.edit',$id[2])
            ->with('success','Plan de Medicina Biologica actualizado exitosamente.');
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
