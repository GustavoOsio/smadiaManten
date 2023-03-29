<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measurements;
use App\Models\MedicalEvolutions;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PhysicalExam;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalEvolutionController extends Controller
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
        $this->authorize('view', MedicalEvolutions::class);
        $patient = session()->get('patient');
        $count = PhysicalExam::where('patient_id',$id)->orderBy('created_at','desc')->count();
        if($count == 0){
            $imc = 0;
        }else{
            $imc = PhysicalExam::where('patient_id',$id)->orderBy('created_at','desc')->take(1)->get();
            $imc = $imc[0]->imc;
        }

        $count = Measurements::where('patient_id',$id)->orderBy('created_at','desc')->count();

        if($count == 0){
            $weight = '0.0';
            $bust = '0.0';
            $contour = '0.0';
            $waistline = '0.0';
            $umbilical = '0.0';
            $abd_lower = '0.0';
            $abd_higher = '0.0';
            $hip = '0.0';
            $legs = '0.0';
            $right_thigh = '0.0';
            $left_thigh = '0.0';
            $right_arm = '0.0';
            $left_arm = '0.0';
        }else{
            $measurements = Measurements::where('patient_id',$id)->orderBy('created_at','desc')->take(1)->get();
            $weight = $measurements[0]->weight;
            $bust = $measurements[0]->bust;
            $contour = $measurements[0]->contour;
            $waistline = $measurements[0]->waistline;
            $umbilical = $measurements[0]->umbilical;
            $abd_lower = $measurements[0]->abd_lower;
            $abd_higher = $measurements[0]->abd_higher;
            $hip = $measurements[0]->hip;
            $legs = $measurements[0]->legs;
            $right_thigh = $measurements[0]->right_thigh;
            $left_thigh = $measurements[0]->left_thigh;
            $right_arm = $measurements[0]->right_arm;
            $left_arm = $measurements[0]->left_arm;
        }


        $idBefore = MedicalEvolutions::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('medical-evolutions.index',[
            'imc' => $imc,
            'weight' => $weight,
            'bust' => $bust,
            'contour' => $contour,
            'waistline' => $waistline,
            'umbilical' => $umbilical,
            'abd_lower' => $abd_lower,
            'abd_higher' => $abd_higher,
            'hip' => $hip,
            'legs' => $legs,
            'right_thigh' => $right_thigh,
            'left_thigh' => $left_thigh,
            'right_arm' => $right_arm,
            'left_arm' => $left_arm,
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
        $this->authorize('create', MedicalEvolutions::class);
        request()->validate([
            'observations' => 'required|string|min:3',
        ]);


        $MedicalEvolutions = MedicalEvolutions::create($request->all());

        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $MedicalEvolutions->update([
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
            'id_type'=>9,
            'id_relation'=>$MedicalEvolutions->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);
        return redirect()->route('medical-evolutions.show',$request->patient_id)
            ->with('success','Evolución médica creada exitosamente.');
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
    public function edit(MedicalEvolutions $MedicalEvolutions)
    {
        $this->authorize('update', Product::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = MedicalEvolutions::find($id[2]);
        return view('medical-evolutions.show',[
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
    public function update(Request $request, MedicalEvolutions $MedicalEvolutions)
    {
        $this->authorize('update', MedicalEvolutions::class);
        request()->validate([
            'observations' => 'required|string|min:3',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $MedicalEvolutions = MedicalEvolutions::find($id[2]);
        $MedicalEvolutions->update($request->all());
        return redirect()->route('medical-evolutions.edit',$id[2])
            ->with('success','Evolución médica actualizada exitosamente.');
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
