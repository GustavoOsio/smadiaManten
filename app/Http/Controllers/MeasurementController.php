<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Measurements;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PhysicalExam;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
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
        $this->authorize('view', Measurements::class);
        $patient = session()->get('patient');
        $count = PhysicalExam::where('patient_id',$id)->orderBy('created_at','desc')->count();
        if($count == 0){
            $imc = 0;
            $weight = 0;
            $height = 0;
        }else{
            $imcSearch = PhysicalExam::where('patient_id',$id)->orderBy('created_at','desc')->take(1)->get();
            $imc = $imcSearch[0]->imc;
            $weight = $imcSearch[0]->weight;
            $height = $imcSearch[0]->height;
        }
        $idBefore = Measurements::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('measurements.index', [
            'imc' => $imc,
            'weight' => $weight,
            'height' => $height,
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
        $this->authorize('create', Measurements::class);
        request()->validate([
            'imc' => 'required|numeric',
            'weight' => 'required|string',
            'bust' => 'required|string',
            'contour' => 'required|string',
            'waistline' => 'required|string',
            'umbilical' => 'required|string',
            'abd_lower' => 'required|string',
            'abd_higher' => 'required|string',
            'hip' => 'required|string',
            'legs' => 'required|string',
            'right_thigh' => 'required|string',
            'left_thigh' => 'required|string',
            'right_arm' => 'required|string',
            'left_arm' => 'required|string',
            //'observations' => 'required|string|min:3|max:500'
        ]);


        $Measurements = Measurements::create($request->all());

        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $Measurements->update([
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
            'id_type'=>4,
            'id_relation'=>$Measurements->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('measurements.show',$request->patient_id)
            ->with('success','Tabla de medidas creada exitosamente.');
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
    public function edit(Measurements $Measurements)
    {
        $this->authorize('update', Measurements::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = Measurements::find($id[2]);
        $patient = session()->get('patient');
        $count = PhysicalExam::where('patient_id',$value->patient_id)->orderBy('created_at','desc')->count();
        if($count == 0){
            $height = 0;
        }else{
            $imcSearch = PhysicalExam::where('patient_id',$value->patient_id)->orderBy('created_at','desc')->take(1)->get();
            $height = $imcSearch[0]->height;
        }
        return view('measurements.show',[
            'value'=>$value,
            'height'=>$height,
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
    public function update(Request $request, Measurements $Measurements)
    {
        $this->authorize('update', Measurements::class);
        request()->validate([
            'imc' => 'required|numeric',
            'weight' => 'required|numeric',
            'bust' => 'required|numeric',
            'contour' => 'required|numeric',
            'waistline' => 'required|numeric',
            'umbilical' => 'required|numeric',
            'abd_lower' => 'required|numeric',
            'abd_higher' => 'required|numeric',
            'hip' => 'required|numeric',
            'legs' => 'required|numeric',
            'right_thigh' => 'required|numeric',
            'left_thigh' => 'required|numeric',
            'right_arm' => 'required|numeric',
            'left_arm' => 'required|numeric',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $Measurements = Measurements::find($id[2]);
        $Measurements->update($request->all());
        return redirect()->route('measurements.edit',$id[2])
            ->with('success','Tabla de medidas actualizada exitosamente.');
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
