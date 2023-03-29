<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InformedConsents;
use App\Models\Item;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Service;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformedConsentsController extends Controller
{

    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index(){
        $this->authorize('view', InformedConsents::class);
        $data = InformedConsents::orderBy('id','desc')->get();
        return view('informed-consents.index', [
            'products' => 'fedf',
            'data'=>$data,
        ]);
    }
    public function show($id)
    {
        $this->authorize('view', InformedConsents::class);
        $data = InformedConsents::find($id);
        if($data->validate == 1){
            return view('informed-consents.show', [
                'products' => 'fedf',
                'data'=>$data,
            ]);
        }else{
            return redirect('informed_consents/pdf/'.$data->id);
        }
    }

    public function services(Request $request){
        request()->validate([
            'id' => 'required|integer',
        ]);
        $items = Item::where('contract_id',$request->id)->groupBy('service_id')->get();
        $array=[];
        $array[] = ["id" => '', "text" => 'Seleccionar'];
        foreach ($items as $i) {
            $service = Service::find($i->service_id);
            $informed = InformedConsents::where('service_id',$service->id)
                ->where('contract_id',$request->id)
                ->count();
            if ($informed == 0) {
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
                        $path = Storage::disk('public')->put('informed_consents/'. time().str_slug(''), $file);
                    }
                }

                $contract = $request->input('contract');
                $service = $request->input('service');
                $patient = $request->input('patient');

                $schedule = Schedule::where('date',date("Y-m-d"))
                    ->where('service_id',$service)
                    ->where('contract_id',$contract)
                    ->where('patient_id',$patient)
                    ->first();
                if(count($schedule) > 0){
                    $responsable_id = $schedule->personal_id;
                }else{
                    $responsable_id = Auth::id();
                }
                $informedconsents = new InformedConsents();
                $informedconsents->contract_id = $contract;
                $informedconsents->service_id = $service;
                $informedconsents->patient_id = $patient;
                $informedconsents->responsable_id = $responsable_id;
                $informedconsents->type = $type;
                $informedconsents->file = $path;
                if($type == 'firma'){
                    $client = Patient::find($patient);
                    $string = str_random(10);
                    $randPass = rand(1111,9999);
                    $vectorName = explode(" ", $client->name);
                    $vectorName = substr($vectorName[0],0,5);
                    $token = uniqid("URL{$contract}{$service}{$string}");
                    $informedconsents->token = $token;
                    $informedconsents->link = 'https://contract.smadiaclinic.com'.'/informed_consents/'.$token;
                    $informedconsents->user = "{$vectorName}{$contract}{$service}";
                    $informedconsents->password = "$randPass";
                }else{
                    $informedconsents->status = 'CONFIRMADO';
                }
                if ($informedconsents->save()) {
                    session(['menu_patient_show' => 9]);
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
        $data = InformedConsents::find($id);
        $pdf = $this->pdf->loadView('pdf.informed_consents', ['data' => $data]);
        return $pdf->stream('consentimiento-informado-Smadia.pdf');
        //return view('pdf.contract');
    }
}
