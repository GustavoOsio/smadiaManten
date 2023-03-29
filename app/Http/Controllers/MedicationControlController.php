<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\MedicationControl;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Provider;
use App\Models\RelationMedicationControl;
use App\Models\RelationSurgeryExpensesSheet;
use App\Models\SurgeryExpensesSheet;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicationControlController extends Controller
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
        $this->authorize('view', MedicationControl::class);
        $patient = session()->get('patient');
        $idBefore = MedicationControl::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationMedicationControl::where('medication_control_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $products = Product::where('status','activo')
            ->get();
        return view('medication_control.index', [
            'products' => $products,
            'idBefore'=>$idBefore,
            'relation'=>$relation,
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
        $this->authorize('create', MedicationControl::class);
        request()->validate([
            'service' => 'required|string|min:1|max:100',
        ]);

        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $MedicationControl =  MedicationControl::create($request->all());
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());

        $MedicationControl->update([
            'user_id' =>$id->id,
            'patient_id' =>$patient->id,
        ]);

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationMedicationControl = new RelationMedicationControl();
                $medication_control_id = $MedicationControl->id;
                $code = $request->input('code'.$i);
                $product = $request->input('product'.$i);
                $hour = $request->input('hour'.$i);
                $date = $request->input('date'.$i);
                $initial = $request->input('initial'.$i);
                $RelationMedicationControl->create([
                    'medication_control_id' => $medication_control_id,
                    'medicine' => $product,
                    'date' =>$date,
                    'hour' =>$hour,
                    'initial' => $initial,
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
            'id_type'=>19,
            'id_relation'=>$MedicationControl->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('medication-control.show',$request->patient_id)
            ->with('success','Control de medicamentos creado exitosamente.');

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
    public function edit(MedicationControl $MedicationControl)
    {
        $this->authorize('update', MedicationControl::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = MedicationControl::find($id[2]);
        $relation = RelationMedicationControl::where('medication_control_id',$value->id)->get();
        $products = Product::where('status','activo')
            ->get();
        return view('medication_control.show',[
            'value'=>$value,
            'relation'=>$relation,
            'products'=>$products,
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
    public function update(Request $request, MedicationControl $MedicationControl)
    {
        $this->authorize('update', MedicationControl::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $MedicationControl = MedicationControl::find($id[2]);
        $MedicationControl->update($request->all());

        $array = $request->input('numberList');
        $vector = explode(',',$array);
        $medication_control_id = $MedicationControl->id;
        for($i = 0; $i < count($vector); ++$i){
            $product = $request->input('product'.$i);
            $hour = $request->input('hour'.$i);
            $date = $request->input('date'.$i);
            $initial = $request->input('initial'.$i);
            if($vector[$i] == 'new'){
                $RelationMedicationControl = new RelationMedicationControl();
                $RelationMedicationControl->create([
                    'medication_control_id' => $medication_control_id,
                    'medicine' => $product,
                    'date' =>$date,
                    'hour' =>$hour,
                    'initial' => $initial,
                ]);
            }elseif($vector[$i] == 'si'){
                $id_rel = $request->input('id_rel'.$i);
                $RelationMedicationControl = RelationMedicationControl::find($id_rel);
                $RelationMedicationControl->update([
                    'medicine' => $product,
                    'date' =>$date,
                    'hour' =>$hour,
                    'initial' => $initial,
                ]);
            }
        }

        return redirect()->route('medication-control.edit',$id[2])
            ->with('success','Control de medicamento actualizada exitosamente.');
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
