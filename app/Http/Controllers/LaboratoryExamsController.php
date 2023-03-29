<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticAids;
use App\Models\Laboratory;
use App\Models\LaboratoryExams;
use App\Models\MedicalHistory;
use App\Models\Product;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\RelationLaboratoryExams;
use App\Models\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;

class LaboratoryExamsController extends Controller
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
        $this->authorize('view', LaboratoryExams::class);
        $patient = session()->get('patient');
        $idBefore = LaboratoryExams::where('patient_id',$id)
            ->orderBy('id','desc')
            ->first();
        if(!empty($idBefore)){
            $relation = RelationLaboratoryExams::where('laboratory_exams_id',$idBefore->id)
                ->get();
        }else{
            $relation = '';
        }
        $exams = Laboratory::where('status','activo')->orderBy('name','asc')->get();
        $diagnostics = DiagnosticAids::where('status','activo')->get();
        return view('laboratory-exams.index', [
            'products' => 'fedf',
            'idBefore'=>$idBefore,
            'relation'=>$relation,
            'exams'=>$exams,
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
        $this->authorize('create', LaboratoryExams::class);
        request()->validate([
            //'comments' => 'required|string',
        ]);

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        $LaboratoryExams = new LaboratoryExams();
        $patient = Patient::find($request->patient_id);
        $id = User::find(Auth::id());
        $comments = $request->input('comments');
        $LaboratoryExams->user_id = $id->id;
        $LaboratoryExams->patient_id = $patient->id;
        $LaboratoryExams->comments = $comments;
        $LaboratoryExams->save();

        for($i = 0; $i < count($vector); ++$i){
            if($vector[$i] == 'si'){
                $RelationLaboratoryExams = new RelationLaboratoryExams();
                $laboratory_exams_id = $LaboratoryExams->id;
                $diagnosis = $request->input('diagnosis'.$i);
                $exam = $request->input('exam'.$i);
                $other_exam = $request->input('other_exam'.$i);
                $RelationLaboratoryExams->create([
                    'laboratory_exams_id' =>$laboratory_exams_id,
                    'diagnosis'=>$diagnosis,
                    'exam' =>$exam,
                    'other_exam' => $other_exam,
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
            'id_type'=>8,
            'id_relation'=>$LaboratoryExams->id,
            'patient_id'=>$patient->id,
            'date'=>$date,
        ]);

        return redirect()->route('laboratory-exams.show',$request->patient_id)
            ->with('success','Examenes de Laboratorio creados exitosamente.');
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
    public function edit(LaboratoryExams $LaboratoryExams)
    {
        $this->authorize('update', LaboratoryExams::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $value = LaboratoryExams::find($id[2]);
        $exams = Laboratory::where('status','activo')->orderBy('name','asc')->get();
        $diagnostics = DiagnosticAids::where('status','activo')->get();
        $relation = RelationLaboratoryExams::where('laboratory_exams_id',$value->id)->get();
        return view('laboratory-exams.show',[
            'value'=>$value,
            'exams'=>$exams,
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
    public function update(Request $request, LaboratoryExams $LaboratoryExams)
    {
        $this->authorize('update', LaboratoryExams::class);
        request()->validate([
            //'comments' => 'required|string',
        ]);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $LaboratoryExams = LaboratoryExams::find($id[2]);
        $LaboratoryExams->update($request->all());

        $array = $request->input('numberList');
        $vector = explode(',',$array);

        for($i = 0; $i < count($vector); ++$i){
            $laboratory_exams_id = $LaboratoryExams->id;
            $diagnosis = $request->input('diagnosis'.$i);
            $exam = $request->input('exam'.$i);
            $other_exam = $request->input('other_exam'.$i);
            if($vector[$i] == 'new'){
                $RelationLaboratoryExams = new RelationLaboratoryExams();
                $RelationLaboratoryExams->create([
                    'laboratory_exams_id' =>$laboratory_exams_id,
                    'diagnosis'=>$diagnosis,
                    'exam' =>$exam,
                    'other_exam'=>$other_exam
                ]);
            }else if($vector[$i] == 'si'){
                $id_rel = $request->input('id_rel'.$i);
                $RelationLaboratoryExams = RelationLaboratoryExams::find($id_rel);
                $RelationLaboratoryExams->update([
                    'diagnosis'=>$diagnosis,
                    'exam' =>$exam,
                    'other_exam'=>$other_exam
                ]);
            }
        }
        return redirect()->route('laboratory-exams.edit',$id[2])
            ->with('success','Ayuda Diagnostica actualizada exitosamente.');
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
        $laboratoryExams = LaboratoryExams::find($id);
        $data = Patient::find($laboratoryExams->patient_id);
        $user = User::find($laboratoryExams->user_id);
        $RelationLaboratoryExams = RelationLaboratoryExams::where('laboratory_exams_id',$laboratoryExams->id)
            ->get();
        $pdf = $this->pdf->loadView('pdf.laboratory_exams', [
            'data'=>$data,
            'user'=>$user,
            'laboratory' => $laboratoryExams,
            'relation'=>$RelationLaboratoryExams,
            ]);
        return $pdf->stream('laboratory_exams.pdf');
    }
}
