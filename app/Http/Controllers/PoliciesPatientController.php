<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InformedConsents;
use App\Models\Item;
use App\Models\Patient;
use App\Models\PoliciesPatients;
use App\Models\Schedule;
use App\Models\Service;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PoliciesPatientController extends Controller
{

    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index(){
        $this->authorize('view', PoliciesPatients::class);
        $data = PoliciesPatients::orderBy('id','desc')->get();
        return view('policies-patients.index', [
            'products' => 'fedf',
            'data'=>$data,
        ]);
    }

    public function services(Request $request){
        request()->validate([
            'id' => 'required|integer',
        ]);
        $items = Item::where('contract_id',$request->id)
            ->whereIn('service_id',[70,69,119,114,1,90,123])
            ->groupBy('service_id')
            ->get();
        $array=[];
        $array[] = ["id" => '', "text" => 'Seleccionar'];
        foreach ($items as $i) {
            $service = Service::find($i->service_id);
            $police = PoliciesPatients::where('service_id',$service->id)
                ->where('contract_id',$request->id)
                ->count();
            if ($police == 0) {
                $array[] = ["id" => $service->id, "text" => $service->name];
            }
        }
        return response(json_encode($array), 200)->header('Content-Type', 'text/json');
    }

    public function store(Request $request)
    {

        try {
            if ($request->isMethod('post')) {

                $type = $request->input('type');
                $path = '';
                if($type == 'pdf'){
                    $file = $request->file('file');
                    if($file != ''){
                        $filename = $file->getClientOriginalName();
                        $path = Storage::disk('public')->put('polizas/'. time().str_slug(''), $file);
                    }
                }

                $contract = $request->input('contract');
                $service = $request->input('service');
                $patient = $request->input('patient');

                $schedule = Schedule::where('date',date("Y-m-d"))
                    ->where('service_id',$service)
                    ->where('contract_id',$contract)
                    ->where('patient_id',$patient)
                    ->count();
                if($schedule > 0){
                    $responsable_id = $schedule->personal_id;
                }else{
                    $responsable_id = Auth::id();
                }
                $poliza = new PoliciesPatients();
                $poliza->contract_id = $contract;
                $poliza->service_id = $service;
                $poliza->patient_id = $patient;
                $poliza->responsable_id = $responsable_id;
                $poliza->type = $type;
                $poliza->file = $path;
                if($type == 'firma'){
                    $client = Patient::find($patient);
                    $string = str_random(10);
                    $randPass = rand(1111,9999);
                    $vectorName = explode(" ", $client->name);
                    $vectorName = substr($vectorName[0],0,5);
                    $token = uniqid("URL{$contract}{$service}{$string}");
                    $poliza->token = $token;
                    $poliza->link = 'https://contract.smadiaclinic.com'.'/policies/'.$token;
                    $poliza->user = "{$vectorName}{$contract}{$service}";
                    $poliza->password = "$randPass";
                }else{
                    $poliza->status = 'CONFIRMADO';
                }
                if ($poliza->save()) {
                    session(['menu_patient_show' => 10]);
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }catch (Exception $e) {
            return " Error: " . $e->getMessage();
        }
    }

    public function generatePDF($id)
    {
        $data = PoliciesPatients::find($id);
        $pdf = $this->pdf->loadView('pdf.policies_patients', ['data' => $data]);
        return $pdf->stream('polizas-Smadia.pdf');
        //return view('pdf.contract');
    }
}
