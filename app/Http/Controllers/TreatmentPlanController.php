<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\RelationTreatmentPlan;
use App\Models\Service;
use App\Models\TreatmentPlan;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreatmentPlanController extends Controller
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
        $this->authorize('view', TreatmentPlan::class);
        $patient = session()->get('patient');
        $idBefore = TreatmentPlan::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationTreatmentPlan::where('tratment_plan_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $services = Service::where('status','activo')->orderBy('name','asc')->get();
        return view('treatment-plan.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'relation'=>$relation,
            'services'=>$services,
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
        $this->authorize('create', TreatmentPlan::class);
        request()->validate([
            //'observations' => 'required|string|max:500',
        ]);

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        $TreatmentPlan = new TreatmentPlan();
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $observations = $request->input('observations');
        $TreatmentPlan->user_id = $id->id;
        $TreatmentPlan->patient_id = $patient->id;
        $TreatmentPlan->observations = $observations;
        $TreatmentPlan->save();

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationTreatmentPlan = new RelationTreatmentPlan();
                $tratment_plan_id = $TreatmentPlan->id;
                $service_line= $request->input('service_line'.$i);
                $observations =  $request->input('observations'.$i);
                $RelationTreatmentPlan->create([
                    'tratment_plan_id' =>$tratment_plan_id,
                    'service_line' =>$service_line,
                    'observations' => $observations,
                ]);
            }
        }

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
            'id_type'=>6,
            'id_relation'=>$TreatmentPlan->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('treatment-plan.show',$request->patient_id)
            ->with('success','Plan de Tratamiento creado exitosamente.');
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
    public function edit(TreatmentPlan $TreatmentPlan)
    {
        $this->authorize('update', TreatmentPlan::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = TreatmentPlan::find($id[2]);
        $services = Service::where('status','activo')->orderBy('name','asc')->get();
        $relation = RelationTreatmentPlan::where('tratment_plan_id',$value->id)->get();
        return view('treatment-plan.show',[
            'value'=>$value,
            'services'=>$services,
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
    public function update(Request $request, TreatmentPlan $TreatmentPlan)
    {
        $this->authorize('update', TreatmentPlan::class);
        request()->validate([
            'observations' => 'required|string',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $TreatmentPlan = TreatmentPlan::find($id[2]);
        $TreatmentPlan->update($request->all());

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        for($i = 0; $i < count($vector); ++$i){
            $tratment_plan_id = $TreatmentPlan->id;
            $service_line= $request->input('service_line'.$i);
            $observations =  $request->input('observations'.$i);
            if($vector[$i] == 'new'){
                $RelationTreatmentPlan = new RelationTreatmentPlan();
                $RelationTreatmentPlan->create([
                    'tratment_plan_id' =>$tratment_plan_id,
                    'service_line' =>$service_line,
                    'observations' => $observations,
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel = $request->input('id_rel'.$i);
                $RelationTreatmentPlan = RelationTreatmentPlan::find($id_rel);
                $RelationTreatmentPlan->update([
                    'service_line' =>$service_line,
                    'observations' => $observations,
                ]);
            }
        }

        return redirect()->route('treatment-plan.edit',$id[2])
            ->with('success','Plan de Tratamiento actualizado exitosamente.');
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
