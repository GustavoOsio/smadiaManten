<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FormulationAppointment;
use App\Models\MedicalHistory;
use App\Models\Product;
use App\Models\Provider;
use App\Models\RelationFormulationAppointment;
use App\Models\Type;
use App\Models\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;

class FormulationAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function show($id)
    {
        $this->authorize('view', FormulationAppointment::class);
        $patient = session()->get('patient');
        $idBefore = FormulationAppointment::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationFormulationAppointment::where('formulation_appointment_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $form = Product::where('status','activo')
            ->where('form','si')
            ->orderBy('name','asc')
            ->get();
        return view('formulation-appointment.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'relation'=>$relation,
            'form'=>$form,
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
        $this->authorize('create', FormulationAppointment::class);
        /*request()->validate([
            'name' => 'required|string|max:40',
        ]);*/


        $array = $request->input('numberList');
        $vector = explode(',',$array);

        $FormulationAppointment = new FormulationAppointment();
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $FormulationAppointment->user_id = $id->id;
        $FormulationAppointment->patient_id = $patient->id;
        $FormulationAppointment->save();

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationFormulationAppointment = new RelationFormulationAppointment();
                $formulation_appointment_id = $FormulationAppointment->id;
                $formula = $request->input('formula'.$i);
                $other = $request->input('other'.$i);
                $another_formula = $request->input('another_formula'.$i);
                $indications = $request->input('indications'.$i);
                $formulation = $request->input('formulation'.$i);
                $RelationFormulationAppointment->create([
                    'formulation_appointment_id' =>$formulation_appointment_id,
                    'formula' =>$formula,
                    'other' => $other,
                    'another_formula' => $another_formula,
                    'indications'=>$indications,
                    'formulation' => $formulation,
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
            'id_type'=>12,
            'id_relation'=>$FormulationAppointment->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('formulation-appointment.show',$request->patient_id)
            ->with('success','Formulacion para Cita creada exitosamente.');
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
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FormulationAppointment $FormulationAppointment)
    {
        $this->authorize('update', FormulationAppointment::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = FormulationAppointment::find($id[2]);
        $form = Product::where('status','activo')
            ->where('form','si')
            ->orderBy('name','asc')
            ->get();
        $relation = RelationFormulationAppointment::where('formulation_appointment_id',$value->id)->get();
        return view('formulation-appointment.show',[
            'value'=>$value,
            'form'=>$form,
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
    public function update(Request $request, FormulationAppointment $FormulationAppointment)
    {
        $this->authorize('update', FormulationAppointment::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $FormulationAppointment = FormulationAppointment::find($id[2]);
        $array = $request->input('numberList');
        $vector = explode(',',$array);
        for($i = 0; $i < count($vector); ++$i){
            $formulation_appointment_id = $FormulationAppointment->id;
            $formula = $request->input('formula'.$i);
            $another_formula = $request->input('another_formula'.$i);
            $indications = $request->input('indications'.$i);
            $formulation = $request->input('formulation'.$i);
            if($vector[$i] == 'new'){
                $RelationFormulationAppointment = new RelationFormulationAppointment();
                $RelationFormulationAppointment->create([
                    'formulation_appointment_id' =>$formulation_appointment_id,
                    'formula' =>$formula,
                    'another_formula' =>$another_formula,
                    'indications' =>$indications,
                    'formulation' => $formulation,
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel = $request->input('id_rel'.$i);
                $RelationFormulationAppointment = RelationFormulationAppointment::find($id_rel);
                $RelationFormulationAppointment->formula = $formula;
                $RelationFormulationAppointment->another_formula = $another_formula;
                $RelationFormulationAppointment->indications = $indications;
                $RelationFormulationAppointment->formulation = $formulation;
                $RelationFormulationAppointment->save();
            }
        }
        return redirect()->route('formulation-appointment.edit',$id[2])
            ->with('success','Formulación Médica actualizada exitosamente.');
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

    public function generatePDF($id)
    {
        $formulation = FormulationAppointment::find($id);
        $data = Patient::find($formulation->patient_id);
        $user = User::find($formulation->user_id);
        $relation = RelationFormulationAppointment::where('formulation_appointment_id',$formulation->id)
            ->get();
        $pdf = $this->pdf->loadView('pdf.formulation_appointment', [
            'data'=>$data,
            'user'=>$user,
            'formulation' => $formulation,
            'relation'=>$relation,
            ]);
        return $pdf->stream('formulation_appointment.pdf');
    }
}
