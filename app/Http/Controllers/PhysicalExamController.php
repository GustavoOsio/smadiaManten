<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\PhysicalExam;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhysicalExamController extends Controller
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
        $this->authorize('view', PhysicalExam::class);
        $patient = session()->get('patient');
        $idBefore = PhysicalExam::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        return view('physical-exams.index', [
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
        //$types = Type::where('status', 'activo')->orderBy('name')->get();
        //$providers = Provider::where('status', 'activo')->orderBy('company')->get();
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
        $this->authorize('create', PhysicalExam::class);
        request()->validate([
            'weight' => 'required|numeric',
            'height' => 'required|string|min:1',
            'imc' => 'required|string|min:1',
            'head_neck' => 'required|string|min:1',
            'cardiopulmonary' => 'required|string|min:1',
            'abdomen' => 'required|string|min:1',
            'extremities' => 'required|string|min:1',
            'nervous_system' => 'required|string|min:1',
            'skin_fanera' => 'required|string|min:1',
            //'others' => 'required|string|min:3|max:500',
            //'observations' => 'required|string|min:3|max:500',
        ]);


        $PhysicalExam = PhysicalExam::create($request->all());

        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $PhysicalExam->update([
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
            'id_type'=>3,
            'id_relation'=>$PhysicalExam->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);


        return redirect()->route('physical-exams.show',$request->patient_id)
            ->with('success','Exámen físico creado exitosamente.');
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
    public function edit(PhysicalExam $PhysicalExam)
    {
        $this->authorize('update', PhysicalExam::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = PhysicalExam::find($id[2]);
        return view('physical-exams.show',[
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
    public function update(Request $request, PhysicalExam $PhysicalExam)
    {
        $this->authorize('update', PhysicalExam::class);
        request()->validate([
            'weight' => 'required|numeric',
            'height' => 'required|string|min:1',
            'imc' => 'required|string|min:1',
            'head_neck' => 'required|string|min:1',
            'cardiopulmonary' => 'required|string|min:1',
            'abdomen' => 'required|string|min:1',
            'extremities' => 'required|string|min:1',
            'nervous_system' => 'required|string|min:1',
            'skin_fanera' => 'required|string|min:1',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $PhysicalExam = PhysicalExam::find($id[2]);
        $PhysicalExam->update($request->all());
        return redirect()->route('physical-exams.edit',$id[2])
            ->with('success','Exámen físico actualizada exitosamente.');
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
