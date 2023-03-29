<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClinicalDiagnostics;
use App\Models\Diagnostic;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\RelationClinicalDiagnostics;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicalDiagnosticController extends Controller
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
        $this->authorize('view', ClinicalDiagnostics::class);
        $patient = session()->get('patient');
        $idBefore = ClinicalDiagnostics::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationClinicalDiagnostics::where('clinical_diagnostics_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $diagnostics = Diagnostic::where('status','activo')->orderBy('name','asc')->get();
        return view('clinical-diagnostics.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'relation'=>$relation,
            'diagnostics'=>$diagnostics,
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
        $this->authorize('create', ClinicalDiagnostics::class);
        $array = $request->input('numberList');
        $vector = explode(',',$array);

        $ClinicalDiagnostics = new ClinicalDiagnostics();
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $observations = $request->input('observations');
        $ClinicalDiagnostics->user_id = $id->id;
        $ClinicalDiagnostics->patient_id = $patient->id;
        $ClinicalDiagnostics->observations = $observations;
        $ClinicalDiagnostics->save();

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationClinicalDiagnostics = new RelationClinicalDiagnostics();
                $clinical_diagnostics_id = $ClinicalDiagnostics->id;
                $diagnosis = $request->input('diagnosis'.$i);
                $type = $request->input('type'.$i);
                $external_cause = $request->input('external_cause'.$i);
                $treatment_plan = $request->input('treatment_plan'.$i);
                $other = $request->input('other'.$i);
                $observations =  $request->input('observations'.$i);
                $RelationClinicalDiagnostics->create([
                    'clinical_diagnostics_id' =>$clinical_diagnostics_id,
                    'diagnosis' =>$diagnosis,
                    //'type' => $type,
                    //'external_cause' =>$external_cause,
                    //'treatment_plan' =>$treatment_plan,
                    //'other' => $other,
                    'observations' => $observations,
                ]);
                //print_r($vector[$i]);
                //print_r($i);
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
            'id_type'=>5,
            'id_relation'=>$ClinicalDiagnostics->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('clinical-diagnostics.show',$request->patient_id)
            ->with('success','Diagnostico clínico creado exitosamente.');
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
    public function edit(ClinicalDiagnostics $ClinicalDiagnostics)
    {
        $this->authorize('update', ClinicalDiagnostics::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = ClinicalDiagnostics::find($id[2]);
        $diagnostics = Diagnostic::where('status','activo')->orderBy('name','asc')->get();
        $relation = RelationClinicalDiagnostics::where('clinical_diagnostics_id',$value->id)->get();
        return view('clinical-diagnostics.show',[
            'value'=>$value,
            'diagnostics'=>$diagnostics,
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
    public function update(Request $request, ClinicalDiagnostics $ClinicalDiagnostics)
    {
        $this->authorize('update', ClinicalDiagnostics::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $ClinicalDiagnostics = ClinicalDiagnostics::find($id[2]);
        $ClinicalDiagnostics->update($request->all());

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        for($i = 0; $i < count($vector); ++$i){
            $clinical_diagnostics_id = $ClinicalDiagnostics->id;
            $diagnosis = $request->input('diagnosis'.$i);
            $observations =  $request->input('observations'.$i);
            if($vector[$i] == 'new'){
                $RelationClinicalDiagnostics = new RelationClinicalDiagnostics();
                $RelationClinicalDiagnostics->create([
                    'clinical_diagnostics_id' =>$clinical_diagnostics_id,
                    'diagnosis' =>$diagnosis,
                    'observations' => $observations,
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel =  $request->input('id_rel'.$i);
                $RelationClinicalDiagnostics = RelationClinicalDiagnostics::find($id_rel);
                $RelationClinicalDiagnostics->update([
                    'diagnosis' =>$diagnosis,
                    'observations' => $observations,
                ]);
            }
        }

        return redirect()->route('clinical-diagnostics.edit',$id[2])
            ->with('success','Diagnostico clínico actualizado exitosamente.');
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
