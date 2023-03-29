<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Schedule;
use App\Models\SurgicalDescription;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurgicalDescriptionController extends Controller
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
        $this->authorize('view', SurgicalDescription::class);
        $patient = session()->get('patient');
        $idBefore = SurgicalDescription::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        $surgery = User::where('status','activo')
            ->where('role_id',2)
            ->orderBy('name','asc')
            ->get();
        $assistant= User::where('status','activo')
            ->where('role_id',7)
            ->orderBy('name','asc')
            ->get();
        $anesthesiologist = User::where('status','activo')
            ->where('role_id',8)
            ->orderBy('name','asc')
            ->get();
        $instrument= User::where('status','activo')
            ->where('role_id',10)
            ->orderBy('name','asc')
            ->get();

        $dateToday = date("Y-m-d");
        $sch = Schedule::where('date','=',$dateToday)
            ->where('patient_id',$id)
            ->where('status','programada')
            ->orwhere('status','reprogramada')
            ->orderBy('id','desc')
            ->count();
        $sch = 1;
        return view('surgical-description.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'surgery'=>$surgery,
            'assistant'=>$assistant,
            'anesthesiologist'=>$anesthesiologist,
            'instrument'=>$instrument,
            'sch'=>$sch,
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
        $this->authorize('create', SurgicalDescription::class);
        request()->validate([
            'diagnosis'  => 'required|string|min:1|max:100',
            'preoperative_diagnosis' => 'required|string|min:1',
            'postoperative_diagnosis' => 'required|string|min:1',
            'surgeon'  => 'required|string|min:1|max:100',
            //'anesthesiologist'  => 'required|string|min:1|max:100',
            //'assistant'  => 'required|string|min:1|max:100',
            //'surgical_instrument'  => 'required|string|min:1|max:100',
            'date'  => 'required|string|min:1|max:100',
            'start_time'  => 'required|string|min:1|max:100',
            'end_time'  => 'required|string|min:1|max:100',
            //'code_cups'  => 'required|string|min:1|max:100',
            'intervention'  => 'required|string|min:1|max:100',
            //'control_compresas'  => 'required|string|min:1|max:100',
            'type_anesthesia'  => 'required|string|min:1|max:100',
            'description_findings' => 'required|string|min:1',
            'observations' => 'required|string|min:1',
        ]);


        $SurgicalDescription =  SurgicalDescription::create($request->except('user_id'));

        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $replace = str_replace("\r","<br>",$request->description_findings);

        $SurgicalDescription->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
            'description_findings'=>$replace
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
            'id_type'=>16,
            'id_relation'=>$SurgicalDescription->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);


        return redirect()->route('surgical-description.show',$request->patient_id)
            ->with('success','Descripción Quirúrgica creada exitosamente.');
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
    public function edit(SurgicalDescription $SurgicalDescription)
    {
        $this->authorize('update', SurgicalDescription::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = SurgicalDescription::find($id[2]);
        $surgery = User::where('status','activo')
            ->where('role_id',2)
            ->orderBy('name','asc')
            ->get();
        $assistant= User::where('status','activo')
            ->where('role_id',7)
            ->orderBy('name','asc')
            ->get();
        $anesthesiologist = User::where('status','activo')
            ->where('role_id',8)
            ->orderBy('name','asc')
            ->get();
        $instrument= User::where('status','activo')
            ->where('role_id',10)
            ->orderBy('name','asc')
            ->get();
        return view('surgical-description.show',[
            'value'=>$value,
            'surgery'=>$surgery,
            'assistant'=>$assistant,
            'anesthesiologist'=>$anesthesiologist,
            'instrument'=>$instrument,
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
    public function update(Request $request, SurgicalDescription $SurgicalDescription)
    {
        $this->authorize('update', SurgicalDescription::class);
        request()->validate([
            'diagnosis'  => 'required|string|min:1|max:100',
            'preoperative_diagnosis' => 'required|string|min:1',
            'postoperative_diagnosis' => 'required|string|min:1',
            'surgeon'  => 'required|string|min:1|max:100',
            //'anesthesiologist'  => 'required|string|min:1|max:100',
            //'assistant'  => 'required|string|min:1|max:100',
            //'surgical_instrument'  => 'required|string|min:1|max:100',
            'date'  => 'required|string|min:1|max:100',
            'start_time'  => 'required|string|min:1|max:100',
            'end_time'  => 'required|string|min:1|max:100',
            'intervention'  => 'required|string|min:1|max:100',
            'type_anesthesia'  => 'required|string|min:1|max:100',
            'description_findings' => 'required|string|min:1',
            'observations' => 'required|string|min:1',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $SurgicalDescription = SurgicalDescription::find($id[2]);
        $SurgicalDescription->update($request->all());
        $replace = str_replace("\r","<br>",$request->description_findings);
        $SurgicalDescription->update([
            'description_findings'=>$replace
        ]);
        return redirect()->route('surgical-description.edit',$id[2])
            ->with('success','Descripción Quirúrgica actualizada exitosamente.');
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
