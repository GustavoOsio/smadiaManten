<?php

namespace App\Http\Controllers;

use App\Exports\PatientsExport;
use App\Models\Account;
use App\Models\CenterCost;
use App\Models\City;
use App\Models\Consumed;
use App\Models\ContactSource;
use App\Models\Contract;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Income;
use App\Models\Issue;
use App\Models\MedicalHistory;
use App\Models\Monitoring;
use App\Models\Patient;
use App\Models\PatientsFiles;
use App\Models\ReservationDate;
use App\Models\SurgicalDescription;
use App\Models\Sale;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\State;
use App\Models\TypeMedicalHistory;
use App\Models\Sucess;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Anamnesis;
use App\Models\SystemReview;
use App\Models\PhysicalExam;
use App\Models\Measurements;
use App\Models\ClinicalDiagnostics;
use App\Models\TreatmentPlan;
use App\Models\BiologicalMedicinePlan;
use App\Models\MedicalEvolutions;
use App\Models\CosmetologicalEvolution;
use App\Models\InfirmaryEvolution;
use App\Models\FormulationAppointment;
use App\Models\ExpensesSheet;
use App\Models\SurgeryExpensesSheet;
use App\Models\InfirmaryNotes;
use App\Models\MedicationControl;
use App\Models\LiquidControl;
use App\Models\arrayHistory;
use App\Models\LaboratoryExams;

class PatientController extends Controller
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

    public function index(Request $request)
    { //aqui
        $this->authorize('view', Patient::class);
        $query = Patient::orderBy('id', 'asc')
            ->where('status', '!=', 'delete');
        if ($request->id != '') {
            $query->where('id', 'LIKE', '%' . $request->id . '%');
        }
        if ($request->name != '') {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->lastname != '') {
            $query->where('lastname', 'LIKE', '%' . $request->lastname . '%');
        }
        if ($request->cc != '') {
            $query->where('identy', 'LIKE', '%' . $request->cc . '%');
        }
        if ($request->mail != '') {
            $query->where('email', 'LIKE', '%' . $request->mail . '%');
        }
        if ($request->phone != '') {
            $query->where('cellphone', 'LIKE', '%' . $request->phone . '%');
        }
        if ($request->status != '') {
            $query->where('status', 'LIKE', '%' . $request->status . '%');
        }
        $user = Auth::user();
        /*
        if($request->creator != ''){
            $user_creator = User::where('name','LIKE','%'.$request->creator.'%')->get();
            //dd($user_creator);
            foreach ($user_creator as $u){
                //dd($u->id);
                $query->where('user_id',$u->id);
            }
        }
        */
        $patients = $query->paginate(20);
        session()->forget('menu_patient_show');
        session(['menu_patient_show' => 1]);
        return view('patients.index', [
            'patients' => $patients,
            'request' => $request,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Patient::class);
        return view('patients.create', [
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'eps' => Filter::where(['status' => 'activo', 'type' => 'eps'])->orderBy('name')->get(),
            'civil' => Filter::where(['status' => 'activo', 'type' => 'estado'])->orderBy('name')->get(),
            'contact_sources' => ContactSource::where(['status' => 'activo'])->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Patient::class);

        request()->validate([
            'name' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            //'identy' => 'required|unique:patients',
            'gender_id' => 'required|integer',
            'email' => 'required|email|max:80',
            'service_id' => 'required|integer',
            'contact_source_id' => 'required|integer',
            'cellphone' => 'required|numeric|unique:patients',
        ]);
        if ($request->identy != '') {
            request()->validate([
                'identy' => 'required|unique:patients',
            ]);
        }
        $patien = Patient::create($request->except('photo'));

        if ($request->photo != "") {
            $data = base64_decode($request->photo);
            $path = 'profile/' . time() . '-' . str_slug($patien->name . " " . $patien->lastname) . '.jpeg';
            file_put_contents($path, $data);
            $patien->update([
                'photo' => $path
            ]);
        }

        return redirect()->route('patients.show', $patien->id)
            ->with('success', 'Paciente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Patient::class);

        $dateToday = date("Y-m-d");
        $updMoni = Monitoring::where('date', '<', $dateToday)
            ->where('status', 'activo')
            ->get();
        foreach ($updMoni as $m) {
            $updateMoni = Monitoring::find($m->id);
            $updateMoni->status = 'vencido';
            $updateMoni->save();
        }

        $schGet = Schedule::where('date', '<', $dateToday)
            ->where('status', 'programada')
            ->get();
        foreach ($schGet as $s) {
            $update = Schedule::find($s->id);
            $update->status = 'vencida';
            $update->save();
        }

        $referer = request()->headers->get('referer');
        if (strpos($referer, 'contracts') !== false) {
            $referer = true;
        } else {
            $referer = false;
        }
        $incomes = Income::join('contracts', 'contracts.id', '=', 'incomes.contract_id')
            ->where('incomes.patient_id', $id)
            //->where('contracts.status', 'activo')
            ->where('incomes.status', 'activo')
            ->where('incomes.amount', '>', 0)
            ->select('incomes.*')
            ->get();
        $totalIncome = 0;
        $totalConsumed = 0;
        $totalPending = 0;
        foreach ($incomes as $i) {
            $totalIncome += $i->amount;
        }
        $consumed = Consumed::join('contracts', 'contracts.id', '=', 'consumed.contract_id')
            ->select('consumed.*')
            ->where(['contracts.patient_id' => $id])
            ->get();
        foreach ($consumed as $c) {
            $totalConsumed += $c->amount;
        }
        $balance = $totalIncome - $totalConsumed;
        $contracts = Contract::where(['patient_id' => $id, 'status' => 'activo'])->whereColumn('amount', '!=', 'balance')->get();
        foreach ($contracts as $c) {
            $totalPending += $c->amount - $c->balance;
        }
        $patient = Patient::find($id);
        $schedule = Schedule::where(["patient_id" => $id, "status" => "en sala", "date" => date("Y-m-d")])->first();
        if ($schedule) $in_room = true;
        else $in_room = false;
        session(['patient' => $patient]);
        $medicalHistory = MedicalHistory::join('type_medical_history', 'type_medical_history.id', '=', 'medical_history.id_type')
            ->join('users', 'users.id', '=', 'medical_history.user_id')
            ->where('medical_history.patient_id', $id)
            ->select('medical_history.*', 'type_medical_history.name as NameMH', 'users.name as NameUser', 'users.lastname as LastNameUser', 'type_medical_history.href as url')
            ->orderBy('medical_history.id', 'desc')
            ->get();
        $sucess = Sucess::where('patient_id', $id)->orderBy('created_at', 'desc')->get();
        $moneyBox = 0;
        foreach ($patient->incomesCaja as $i) {
            $moneyBox = $moneyBox + $i->amount;
        }
        return view('patients.show', [
            'pending' => $totalPending,
            'balance' => $balance,
            'moneyBox' => $moneyBox,
            'patient' => $patient,
            'issues' => Issue::where('status', 'activo')->orderBy('name')->get(),
            'users' => User::where('status', 'activo')->orderBy('name')->get(),
            'user' => Auth::user(),
            'centers' => CenterCost::where(['status' => 'activo', 'type' => 'ingreso'])->orderBy('name')->get(),
            'accounts' => Account::where(['status' => 'activo'])->get(),
            'referer' => $referer,
            'medicalHistory' => $medicalHistory,
            'in_room' => $in_room,
            'sucess' => $sucess,
            'sales' => Sale::whereIn('status', ['activo', 'anulada'])->where('patient_id', $id)->orderByDesc('created_at')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $this->authorize('update', Patient::class);

        return view('patients.edit', [
            'patient' => $patient,
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'services' => Service::where('status', 'activo')->orderBy('name')->get(),
            'eps' => Filter::where(['status' => 'activo', 'type' => 'eps'])->orderBy('name')->get(),
            'contact_sources' => ContactSource::where(['status' => 'activo'])->orderBy('name')->get(),
            'civil' => Filter::where(['status' => 'activo', 'type' => 'estado'])->orderBy('name')->get(),
            'cities' => City::where('state_id', $patient->state_id)->orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $this->authorize('update', Patient::class);
        request()->validate([
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'gender_id' => 'required|integer',
            'email' => 'required|email|max:80',
            'service_id' => 'required|integer',
            'contact_source_id' => 'required|integer',
            'cellphone' => 'required|numeric',
        ]);

        if ($request->identy <> '') {
            if ($request->identy <> str_replace(' ', '', $patient->identy)) {
                //dd($request->identy.' entro '.$patient->identy);
                request()->validate([
                    'identy' => 'required|unique:patients',
                ]);
            }
        }
        //dd($request->identy);

        $dataP = $patient->update($request->all());

        if ($request->photo != "") {
            $data = base64_decode($request->photo);
            $path = 'profile/' . time() . '-' . str_slug($patient->name . " " . $patient->lastname) . '.jpeg';
            file_put_contents($path, $data);
            $patient->update([
                'photo' => $path
            ]);
        }

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Paciente actualizado exitosamente.');
        /*
        return redirect()->route('patients.index')
            ->with('success','Paciente actualizado exitosamente.');
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $this->authorize('delete', Patient::class);
        $patient->status = 'delete';
        $patient->update();
        //$patient->delete();
        return redirect()->route('patients.index')
            ->with('success', 'Paciente eliminado exitosamente');
    }

    public function search(Request $request)
    {
        $this->authorize('view', Patient::class);
        request()->validate([
            'patient' => 'required|numeric',
        ]);
        $data = Patient::with('city')
            ->where('identy', 'like', '%' . $request->patient . '%')
            ->orWhere('cellphone', 'like', '%' . $request->patient . '%')
            ->limit(20)->get();
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function search_2(Request $request)
    {
        $this->authorize('view', Patient::class);
        request()->validate([
            'patient' => 'required|string',
        ]);
        $data = Patient::with('city')
            ->where('name', 'like', '%' . $request->patient . '%')
            ->orWhere('lastname', 'like', '%' . $request->patient . '%')
            ->limit(20)->get();
        return response(json_encode($data), 200)->header('Content-Type', 'text/json');
    }

    public function modalHistoryClinic(Request $request)
    {
        try {
            $type_medical_history = TypeMedicalHistory::find($request->id_type);
            $patientId = $request->patiend_id;
            $idRelation = $request->id_relation;
            return view('patients.modal', [
                'type_medical_history' => $type_medical_history,
                'patientId' => $patientId,
                'idRelation' => $idRelation,
            ]);
        } catch (Exception $e) {
            return " Error: " . $e->getMessage();
        }
    }

    public function generatePDF($id)
    {
        $patient = Patient::find($id);
        $medicalHistory = MedicalHistory::where('patient_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();
        $pdf = $this->pdf->loadView('pdf.history_clinic', [
            'data' => $patient,
            'medicalHistory' => $medicalHistory,
        ]);
        return $pdf->stream('HistoriaClinica-Smadia.pdf');
    }

    public function generateDescripQuiruPDF($id)
    {
        $SurgicalDescription = SurgicalDescription::where('id', $id)->get();
        $medicalHistory = MedicalHistory::where('patient_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();
        return view('patients.history.surgical-description', [
            'data' => $SurgicalDescription,
            'medicalHistory' => $medicalHistory
        ]);
    }


    public function export(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end")
        ];
        return Excel::download(new PatientsExport($data), 'pacientes.xlsx');
    }

    public function uploadFiles(Request $request)
    {
        $name = $request->input('name');
        $file = $request->file('file');
        $patient = session()->get('patient');
        $id = User::find(Auth::id());
        $filename = $file->getClientOriginalName();
        $path = Storage::disk('public')->put('patientsFile/' . time() . str_slug($patient->name . " " . $patient->lastname), $file);

        $PatientsFiles = new PatientsFiles();
        $PatientsFiles->user_id = $id->id;
        $PatientsFiles->patient_id = $patient->id;
        $PatientsFiles->name = $name;
        $PatientsFiles->file = $path;
        $PatientsFiles->date = date('Y-m-d');
        if ($PatientsFiles->save()) {
            return redirect()->route('patients.show', $patient->id)
                ->with('success', 'Archivo de Paciente guardado exitosamente.');
        } else {
            return redirect()->route('patients.show', $patient->id)
                ->with('error', 'Error al subir el archivo del paciente.');
        }
    }

    public function patientShow($id)
    {
        session(['menu_patient_show' => 0]);
        return redirect('patients/' . $id);
    }

    public function newHcPdf(Request $request)
    {

        $req = json_decode($request->get('printHc'));

        $anamnesisArray = array();
        $systemArray = array();
        $PhysicalExam = array();
        $tmedias = array();
        $diagnostico = array();
        $tratamiento = array();
        $planBiologico = array();
        $medicalEvo = array();
        $cosmetologicalEvo = array();
        $EnfermerEvo = array();
        $formulacion = array();
        $ExpensesSheet = array();
        $ExpensesSheetSurgery = array();
        $notasdeEnfermeria = array();
        $controlMedicamento = array();
        $contolLiquidos = array();
        $descripcionquirurgica = array();
        $ayudaDiagnos = array();

        foreach ($req as $key => $value) {


            switch ($value->datos->tipo) {
                case 'anamnesis':
                    //anamnesis
                    try {
                        $sql = Anamnesis::where('id', $value->datos->id)
                            ->orderBy('id', 'desc')->get();
                        foreach ($sql as $key => $value) {
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp = array();
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['reason_consultation'] = $value->reason_consultation;
                            $temp['current_illness'] = $value->current_illness;
                            $temp['ant_patologico'] = $value->ant_patologico;
                            $temp['ant_surgical'] = $value->ant_surgical;
                            $temp['ant_allergic'] = $value->ant_allergic;
                            $temp['ant_traumatic'] = $value->ant_traumatic;
                            $temp['ant_medicines'] = $value->ant_medicines;
                            $temp['ant_gynecological'] = $value->ant_gynecological;
                            $temp['ant_fum'] = $value->ant_fum;
                            $temp['ant_habits'] = $value->ant_habits;
                            $temp['ant_familiar'] = $value->ant_familiar;
                            $temp['ant_nutritional'] = $value->ant_nutritional;
                            $temp['observations'] = $value->observations;
                            $temp['created_at'] = $fecha[0];
                            $temp['updated_at'] = $value->updated_at;

                            array_push($anamnesisArray, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error anamnesis: " . $e->getMessage();
                    }

                    break;
                case 'system-review':
                    //revision por sistemas
                    try {
                        $sql = SystemReview::where('id', $value->datos->id)->orderBy('id', 'desc')->get();

                        foreach ($sql as $key => $value) {
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                                $temp = array();
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['system_head_face_neck'] = $value->system_head_face_neck;
                            $temp['system_respiratory_cardio'] = $value->system_respiratory_cardio;
                            $temp['system_digestive'] = $value->system_digestive;
                            $temp['system_genito_urinary'] = $value->system_genito_urinary;
                            $temp['system_locomotor'] = $value->system_locomotor;
                            $temp['system_nervous'] = $value->system_nervous;
                            $temp['system_integumentary'] = $value->system_integumentary;
                            $temp['observations'] = $value->observations;
                            $temp['created_at'] = $fecha[0];
                            
                            array_push($systemArray, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error system-review: " . $e->getMessage();
                    }

                    break;
                case 'pysical':
                    //examen fisico
                    try {
                        $sql = PhysicalExam::where('id', $value->datos->id)->get();
                        foreach ($sql as $key => $value) {
                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['weight'] = $value->weight;
                            $temp['height'] = $value->height;
                            $temp['imc'] = $value->imc;
                            $temp['head_neck'] = $value->head_neck;
                            $temp['cardiopulmonary'] = $value->cardiopulmonary;
                            $temp['abdomen'] = $value->abdomen;
                            $temp['extremities'] = $value->extremities;
                            $temp['nervous_system'] = $value->nervous_system;
                            $temp['skin_fanera'] = $value->skin_fanera;
                            $temp['others'] = $value->others;
                            $temp['observations'] = $value->observations;
                            $temp['created_at'] = $fecha[0];
                            array_push($PhysicalExam, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error pysical: " . $e->getMessage();
                    }
                    break;
                case 'tmedidas':
                    //tabla de medidas 
                    try {
                        $sql = Measurements::where('id', $value->datos->id)->get();
                        foreach ($sql as $key => $value) {
                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                                
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['imc'] = $value->imc;
                            $temp['weight'] = $value->weight;
                            $temp['bust'] = $value->bust;
                            $temp['contour'] = $value->contour;
                            $temp['waistline'] = $value->waistline;
                            $temp['umbilical'] = $value->umbilical;
                            $temp['abd_lower'] = $value->abd_lower;
                            $temp['abd_higher'] = $value->abd_higher;
                            $temp['hip'] = $value->hip;
                            $temp['legs'] = $value->legs;
                            $temp['right_thigh'] = $value->right_thigh;
                            $temp['left_thigh'] = $value->left_thigh;
                            $temp['right_arm'] = $value->right_arm;
                            $temp['left_arm'] = $value->left_arm;
                            $temp['observations'] = $value->observations;
                            $temp['created_at'] = $fecha[0];
                            array_push($tmedias, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error tmedidas: " . $e->getMessage();
                    }
                    break;
                case 'diagnostico':
                    //diagnostico clinico
                    try {
                        $sql = ClinicalDiagnostics::with('relacion_diagnostico')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['observations1'] = $value->observations;
                            $temp['created_at'] = $value->created_at;
                            $temp['updated_at'] = $value->updated_at;
                            $temp['clinical_diagnostics_id'] = $value->relacion_diagnostico[0]->clinical_diagnostics_id;
                            $temp['diagnosis'] = $value->relacion_diagnostico[0]->diagnosis;
                            $temp['observations2'] = $value->relacion_diagnostico[0]->observations;
                            $temp['created_at'] = $fecha[0];
                            array_push($diagnostico, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error diagnostico: " . $e->getMessage();
                    }
                    break;
                case 'tratamiento':
                    //plan de tratamiento
                    try {
                        $sql =  TreatmentPlan::with('relacion')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['observations1'] = $value->relacion[0]->observations;
                            $temp['create'] = $value->created_at;
                            $temp['service_line'] = $value->relacion[0]->service_line;
                            $temp['observations'] = $value->observations;
                            $temp['created_at'] = $fecha[0];

                            array_push($tratamiento, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error tratamiento: " . $e->getMessage();
                    }

                    break;
                case 'plan-biologica':
                    //plan de medicina biologica pendiente
                    try {
                        // return $sql = BiologicalMedicinePlan::where('id', 1)
                        //     ->orderBy('id', 'desc')->get();

                        //     foreach ($sql as $key => $value) {

                        //         $temp = array();
                        //         $user = User::find($value->user_id);
                        //         $temp['id'] = $value->id;
                        //         $temp['user_id'] = $user->name . " " . $user->lastname;
                        //         $temp['patient_id'] = $value->patient_id;
                        //         $temp['observations1'] = $value->relacion[0]->observations;
                        //         $temp['create'] = $value->created_at;
                        //         $temp['service_line'] = $value->relacion[0]->service_line;
                        //         $temp['observations'] = $value->observations;


                        //         array_push($planBiologico, $temp);
                        //     }

                    } catch (\Exception $e) {
                        return " Error plan-biologica: " . $e->getMessage();
                    }
                    break;
                case 'laboratory-exams':
                    //ayudas diagnosticas
                    try {
                        $sql = LaboratoryExams::with('relacion_laboratorio')->where('id', $value->datos->id)
                            ->orderBy('id', 'desc')->get();
                        foreach ($sql as $key => $value) {


                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['datos'] = $value->relacion_laboratorio;
                            $temp['created_at'] = $fecha[0];


                            array_push($ayudaDiagnos, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error: " . $e->getMessage();
                    }
                    break;

                case 'medical-evolutions':
                    //Evoluciones medicas 
                    try {
                        $sql = MedicalEvolutions::where('id', $value->datos->id)
                            ->orderBy('id', 'desc')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['observations'] = $value->observations;
                            $temp['create'] = $value->created_at;
                            $temp['created_at'] = $fecha[0];
                            $temp['updated_at'] = $value->updated_at;


                            array_push($medicalEvo, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error medical-evolutions: " . $e->getMessage();
                    }

                    break;
                case 'cosmetological-evolution':
                    //evolucion de cosmetodologia
                    try {
                         $sql = CosmetologicalEvolution::where('id', $value->datos->id)
                            ->orderBy('id', 'desc')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['evolution'] = $value->evolution;
                            $temp['created_at'] = $fecha[0];
                            $temp['updated_at'] = $value->updated_at;


                            array_push($cosmetologicalEvo, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error cosmetological-evolution: " . $e->getMessage();
                    }

                    break;
                case 'infirmary-evolution':
                    //evolucion de enfermeria
                    try {
                        $sql = InfirmaryEvolution::where('id', $value->datos->id)
                            ->orderBy('id', 'desc')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['evolution'] = $value->evolution;
                            $temp['created_at'] = $fecha[0];
                            $temp['updated_at'] = $value->updated_at;


                            array_push($EnfermerEvo, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error infirmary-evolution: " . $e->getMessage();
                    }
                    break;
                case 'formulation-appointment':
                    //formulacion 
                    try {
                        $sql = FormulationAppointment::with('relacion_formulacion')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();

                        array_push($formulacion, $sql);
                    } catch (\Exception $e) {
                        return " Error formulation-appointment: " . $e->getMessage();
                    }
                    break;
                case 'expenses-sheet':
                    //hoja de gastos
                    try {
                        $sql = ExpensesSheet::with('relacion_expenses_sheet')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['observations'] = $value->observations;
                            $temp['created_at'] = $fecha[0];
                            $temp['updated_at'] = $value->updated_at;
                            $temp['relacion'] = $value->relacion_expenses_sheet;


                            array_push($ExpensesSheet, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error expenses-sheet: " . $e->getMessage();
                    }
                    break;
                case 'surgery-expenses-sheet':
                    //Hoja de gastos cirugia
                    try {
                        $sql = SurgeryExpensesSheet::with('relacion_expenses_sheet_surgery')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();
                        foreach ($sql as $key => $value) {

                            $temp = array();
                            $user = User::find($value->user_id);
                            $fecha = explode(" ", $value->created_at);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['date_of_surgery'] = $value->date_of_surgery;
                            $temp['room'] = $value->room;
                            $temp['weight'] = $value->weight;
                            $temp['type_patient'] = $value->type_patient;
                            $temp['type_anesthesia'] = $value->type_anesthesia;
                            $temp['type_surgery'] = $value->type_surgery;
                            $temp['surgery'] = $value->surgery;
                            $temp['time_entry'] = $value->time_entry;
                            $temp['start_time_surgery'] = $value->start_time_surgery;
                            $temp['end_time_surgery'] = $value->end_time_surgery;
                            $temp['surgeon'] = $value->surgeon;
                            $temp['assistant'] = $value->assistant;
                            $temp['anesthesiologist'] = $value->anesthesiologist;
                            $temp['rotary'] = $value->rotary;
                            $temp['instrument'] = $value->instrument;
                            $temp['created_at'] = $fecha[0];
                            $temp['updated_at'] = $value->updated_at;
                            $temp['relacion_expenses_sheet_surgery'] = $value->relacion_expenses_sheet_surgery;



                            array_push($ExpensesSheetSurgery, $temp);
                        }
                    } catch (\Exception $e) {
                        return " Error surgery-expenses-sheet: " . $e->getMessage();
                    }

                    break;
                case 'infirmary-notes':
                    //notas de enfermeria
                    try {
                         $sql = InfirmaryNotes::where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();
                        foreach ($sql as $key => $value) {
                            $fecha = explode(" ", $value->created_at);
                            $temp = array();
                            $user = User::find($value->user_id);
                            $temp['id'] = $value->id;
                            $temp['user_id'] = $user->name . " " . $user->lastname;
                            $temp['patient_id'] = $value->patient_id;
                            $temp['date'] = $value->date;
                            $temp['hour'] = $value->hour;
                            $temp['note'] = $value->note;
                            $temp['created_at'] = $fecha[0];

                            array_push($notasdeEnfermeria, $temp);
                        }
                      
                    } catch (\Exception $e) {
                        return " Error infirmary-notes: " . $e->getMessage();
                    }
                    break;
                case 'surgical-description':
                    //descripcion quirurgica
                    try {
                        $sql  = SurgicalDescription::where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();
                            foreach ($sql as $key => $value) {
                                $fecha = explode(" ", $value->created_at);
                                $temp = array();
                                $user = User::find($value->user_id);
                                $temp['id'] = $value->id;
                                $temp['user_id'] = $user->name . " " . $user->lastname;
                                $temp['patient_id'] = $value->patient_id;
                                $temp['diagnosis'] = $value->diagnosis;
                                $temp['preoperative_diagnosis'] = $value->preoperative_diagnosis;
                                $temp['postoperative_diagnosis'] = $value->postoperative_diagnosis;
                                $temp['surgeon'] = $value->surgeon;
                                $temp['anesthesiologist'] = $value->anesthesiologist;
                                $temp['assistant'] = $value->assistant;
                                $temp['surgical_instrument'] = $value->surgical_instrument;
                                $temp['date'] = $value->date;
                                $temp['start_time'] = $value->start_time;
                                $temp['end_time'] = $value->end_time;
                                $temp['intervention'] = $value->intervention;
                                $temp['type_anesthesia'] = $value->type_anesthesia;
                                $temp['description_findings'] = $value->description_findings;
                                $temp['observations'] = $value->observations;
                                $temp['created_at'] = $fecha[0];
    
                                array_push($descripcionquirurgica, $temp);
                            }
                        
                    } catch (\Exception $e) {
                        return " Error surgical-description: " . $e->getMessage();
                    }
                    break;
                case 'medication-control':
                    //control de medicamentos
                    try {

                        $sql = MedicationControl::with('relacion_control_medicamentos')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();

                            foreach ($sql as $key => $value) {
                                $fecha = explode(" ", $value->created_at);
                                $temp = array();
                                $user = User::find($value->user_id);
                                $temp['id'] = $value->id;
                                $temp['user_id'] = $user->name . " " . $user->lastname;
                                $temp['patient_id'] = $value->patient_id;
                                $temp['service'] = $value->service;
                                $temp['relacion_control_medicamentos'] = $value->relacion_control_medicamentos;
                                
                                $temp['created_at'] = $fecha[0];
    
                                array_push($controlMedicamento, $temp);
                            }
                        
                    } catch (\Exception $e) {
                        return " Error medication-control: " . $e->getMessage();
                    }
                    break;
                case 'liquid-control':
                    //control de liquidos
                    try {
                        $sql = LiquidControl::with('relacion_control_liquidos')->where('id', $value->datos->id)
                            ->orderBy('id', 'ASC')->get();

                            foreach ($sql as $key => $value) {
                                $fecha = explode(" ", $value->created_at);
                                $temp = array();
                                $user = User::find($value->user_id);
                                $temp['id'] = $value->id;
                                $temp['user_id'] = $user->name . " " . $user->lastname;
                                $temp['patient_id'] = $value->patient_id;
                                $temp['parental_1'] = $value->parental_1;
                                $temp['parental_2'] = $value->parental_2;
                                $temp['parental_3'] = $value->parental_3;
                                $temp['parental_4'] = $value->parental_4;
                                $temp['parental_5'] = $value->parental_5;
                                $temp['total_adm'] = $value->total_adm;
                                $temp['total_del'] = $value->total_del;
                                
                                $temp['relacion_control_liquidos'] = $value->relacion_control_liquidos;
                                
                                $temp['created_at'] = $fecha[0];
    
                                array_push($contolLiquidos, $temp);
                            }
                        
                    } catch (\Exception $e) {
                        return " Error liquid-control: " . $e->getMessage();
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }

        $patient = Patient::find($request->get('paciente'));

        $arrayData = [
            "anamnesis" => $anamnesisArray,
            "revisionXsistemas" => $systemArray,
            "examFisico" => $PhysicalExam,
            "tmedidas" => $tmedias,
            "diagnostico" => $diagnostico,
            "tratamiento" => $tratamiento,
            "planBiologico" => $planBiologico,
            "ayudaDiagnostica" => $ayudaDiagnos,
            "evolucionMedica" => $medicalEvo,
            "evolucionCosmetologia" => $cosmetologicalEvo,
            "evolucionEnfermera" => $EnfermerEvo,
            "formulacion" => $formulacion,
            "hojaGastos" => $ExpensesSheet,
            "hojaGastosCirugia" => $ExpensesSheetSurgery,
            "notasdeEnfermeria" => $notasdeEnfermeria,
            "descQuirurgica"=>$descripcionquirurgica,
            "controlMedicamento" => $controlMedicamento,
            "contolLiquidos" => $contolLiquidos,
            "paciente" => $patient,
        ];

        $json = json_encode($arrayData);
        $newHc = new arrayHistory();
        $newHc->patient = $patient->id;
        $newHc->patient = $patient->id;
        $newHc->array = $json;
        $newHc->agent = Auth::user()->id;

        $newHc->save();
        return $newHc->id;
    }

    function printNhc($id)
    {
        $medicalHistory = arrayHistory::with('relacion_paciente')->where('id', $id)
            ->orderBy('id', 'ASC')->get();


        $patient = Patient::find($medicalHistory[0]->relacion_paciente[0]->id);

        $deco = $medicalHistory[0]->array;

        $arr = json_decode($deco, TRUE);



        $pdf = $this->pdf->loadView('pdf.history_clinic_2', [
            'data' => $patient,
            'historia' => $arr,

        ]);


        return $pdf->stream('HistoriaClinica-Smadia.pdf');
    }
}
