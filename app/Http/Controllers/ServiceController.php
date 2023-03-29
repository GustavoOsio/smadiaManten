<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ElectronicEquipment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Item;
use App\Models\Contract;
use App\Models\Schedule;
use App\Models\ServiceRole;
use App\Models\ServiceUser;
use App\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
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

    public function index()
    {
        $this->authorize('view', Service::class);
        $services = Service::orderBy('name')->get();
        return view('services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Service::class);
        $users = User::where(['status' => 'activo', 'schedule' => 'si'])->orderByRaw('name ASC, lastname ASC')->get();
        return view('services.create', [
            'users' => $users,
            'equipments' => ElectronicEquipment::Orderby("name")->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request) {
        request()->validate([
            'id' => 'required|integer'
        ]);
        $service = Service::find($request->id);
        return response(json_encode($service), 200)->header('Content-Type', 'text/json');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Service::class);
        request()->validate([
            'name' => 'required|string|max:80',
            'price' => 'required|numeric',
            'price_pay' => 'required|numeric',
            'price_input' => 'required|numeric',
            'percent' => 'required|integer',
            'xpenses_sheet' => 'required|string|max:15',
            'restricted' => 'required|alpha|max:2',
            'contract' => 'required|alpha|max:2',
            'status' => 'required|alpha|max:8',
            'depilcare' => 'required|alpha|max:2',
            'type' => 'required|string|max:10',
            'p_deducible_t' => 'required|numeric',
            'p_deducible_no' => 'required|numeric',
            'p_comision' => 'required|numeric',

        ]);


        $service = Service::create([
            'name' => $request->name,
            'price' => $request->price,
            'price_pay' => $request->price_pay,
            'price_input' => $request->price_input,
            'percent' => $request->percent,
            'xpenses_sheet' => $request->xpenses_sheet,
            'restricted' => $request->restricted,
            'contract' => $request->contract,
            'electronic_equipment_id' => $request->electronic_equipment_id,
            'depilcare' => $request->depilcare,
            'type' => $request->type,
            'deducible' => $request->deducible,
            'status' => $request->status,
            'p_deducible_t' => $request->p_deducible_t,
            'p_deducible_no' => $request->p_deducible_no,
            'p_comision' => $request->p_comision,
        ]);

        //$service->users()->attach($request->users);


        return redirect()->route('services.index')
            ->with('success','Servicio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Service::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $this->authorize('update', Service::class);
        $users = User::where(['status' => 'activo', 'schedule' => 'si'])->orderBy('name', 'lastname')->get();
        $array = [];
        //dd($service->users);
        foreach ($service->users as $user) {
            $array[] = $user->id;
        }
        return view('services.edit',[
            'service' => $service,
            'users' => $users,
            'array' => $array,
            'equipments' => ElectronicEquipment::Orderby("name")->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $this->authorize('update', Service::class);
        request()->validate([
            'name' => 'required|string|max:80',
            'price' => 'required|numeric',
            'price_pay' => 'required|numeric',
            'price_input' => 'required|numeric',
            'percent' => 'required|integer',
//            'equipment_id' => 'required|integer',
            'xpenses_sheet' => 'required|string|max:15',
            'restricted' => 'required|alpha|max:2',
            'contract' => 'required|alpha|max:2',
            'status' => 'required|alpha|max:8',
            'depilcare' => 'required|alpha|max:2',
            'type' => 'required|string|max:80',
        ]);


        $service->update([
            'name' => $request->name,
            'price' => $request->price,
            'price_pay' => $request->price_pay,
            'price_input' => $request->price_input,
            'percent' => $request->percent,
            'xpenses_sheet' => $request->xpenses_sheet,
            'restricted' => $request->restricted,
            'contract' => $request->contract,
            'status' => $request->status,
            'electronic_equipment_id' => $request->electronic_equipment_id,
            'depilcare' => $request->depilcare,
            'type' => $request->type,
            'deducible' => $request->deducible,
        ]);

        //$service->users()->sync($request->users);

        return redirect()->route('services.index')
            ->with('success','Servicio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', Service::class);
        $service->delete();
        return redirect()->route('services.index')
            ->with('success','Servicio eliminado exitosamente');
    }

    public function users(Request $request) {
        request()->validate([
            'id' => 'required|integer',
        ]);
        $data = ServiceUser::where('service_id',$request->id)->get();
        $array=[];
        //$array[] = ["id" => '', "text" => 'Seleccione profesional'];
        foreach ($data as $u) {
            //$answer[] = array("id" => $u->users->id, "text" => $u->users->name.' '.$u->users->lastname);
            $array[] = ["id" => $u->user_id, "text" => $u->users->name.' '.$u->users->lastname];
        }
        return response(json_encode($array), 200)->header('Content-Type', 'text/json');
    }

    public function users_rol(Request $request) {
        request()->validate([
            'id' => 'required|integer',
        ]);
        $service_rol = ServiceRole::where('service_id',$request->id)->get();
        $array=[];
        $array[] = ["id" => '', "text" => 'Seleccione profesional'];
        foreach ($service_rol as $s) {
            $data = User::where('role_id',$s->role_id)
                ->where('status','activo')
                ->get();
            foreach ($data as $u) {
                $array[] = ["id" => $u->id, "text" => $u->name.' '.$u->lastname];
            }
        }
        return response(json_encode($array), 200)->header('Content-Type', 'text/json');
    }


    public function contracts(Request $request) {
        request()->validate([
            'id' => 'required|integer',
        ]);
        $patient = session()->get('patient_schedule');
        $service = Service::find($request->id);
        $items = Item::join('contracts','items.contract_id','=','contracts.id')
            ->where('contracts.patient_id',$patient->id)
            ->where('items.service_id',$service->id)->select('items.*')
            ->groupBy('contracts.id')
            ->get();
        $array=[];
        $key_count = 0;
        $count_qty = 0;
        $value_v = 0;
        foreach($items as $key => $i){
            $contract = Contract::find($i->contract_id);
            if(!empty($contract)){
                if($contract->status == 'activo'){
                    $items_2 = Item::where('items.contract_id',$i->contract_id)
                        ->where('items.service_id',$service->id)->select('items.*')
                        ->get();
                    foreach ($items_2 as $key2 => $i_2){
                        $schedule = Schedule::where('patient_id',$patient->id)
                            ->where('contract_id',$contract->id)
                            ->where('service_id',$service->id)
                            ->whereIn('status',['programada', 'confirmada','completada','vencida'])
                            ->count();
                        if($schedule >= 0){
                            $key_count++;
                            $service= Service::find($service->id);
                            if($service->type == 'sesion'){
                                if ($schedule > $i_2->qty) {
                                    if ($key2 > 0) {
                                        $pos = intval($key2)-1;
                                        $count_qty = $count_qty - $items_2[$pos]->qty;
                                    }else{
                                        $count_qty = $schedule;
                                    }
                                } else {
                                    if ($key2 > 0) {
                                        $count_qty = 0;
                                    } else {
                                        $count_qty = $schedule;
                                    }
                                }
                            }else{
                                if($schedule >= 1){
                                    if ($key2 > 0) {
                                        $pos = intval($key2)-1;
                                        $value_v = $count_qty;
                                        $count_qty = $count_qty - $items_2[$pos]->qty;
                                        if($count_qty >= 1){
                                            $count_qty = $i_2->qty;
                                        }else{
                                            $count_qty = 0;
                                        }
                                    }else{
                                        $count_qty = $i_2->qty;
                                        if($schedule > $i_2->qty){
                                            $count_qty = $schedule;
                                        }
                                    }
                                }else{
                                    $count_qty = 0;
                                }
                            }
                            if($count_qty < $i_2->qty){
                                $item = Item::where('id',$i_2->id)
                                    ->where('contract_id',$contract->id)
                                    ->first();
                                $array[] = [
                                    "id" => $contract->id,
                                    "text" =>"C-" . $contract->id .' Servicio: '.$service->name.' ('.$count_qty.' de '.$i_2->qty.')'
                                ];
                            }
                        }else{
                            if($contract->patient_id == $patient->id){
                                $array[] = ["id" => $contract->id, "text" =>"C-" . $contract->id];
                            }
                        }
                    }
                }
            }
        }
        return response(json_encode($array), 200)->header('Content-Type', 'text/json');
    }

    public function contracts_2(Request $request) {
        request()->validate([
            'id' => 'required|integer',
        ]);
        $patient = Patient::find($request->id_patient);
        $service = Service::find($request->id);

         $items = Item::join('contracts','items.contract_id','=','contracts.id')
            ->where('contracts.patient_id',$patient->id)
            ->where('items.service_id',$service->id)->select('items.*')
            ->groupBy('contracts.id')
            ->get();
        $array=[];
        $key_count = 0;
        $count_qty = 0;
        $value_v = 0;
        foreach($items as $key => $i){
             $contract = Contract::find($i->contract_id);
            if(!empty($contract)){
                if($contract->status == 'activo'){
                    $items_2 = Item::where('items.contract_id',$i->contract_id)
                        ->where('items.service_id',$service->id)->select('items.*')
                        ->get();
                    foreach ($items_2 as $key2 => $i_2){
                        $schedule = Schedule::where('patient_id',$patient->id)
                            ->where('contract_id',$contract->id)
                            ->where('service_id',$service->id)
                            ->whereIn('status',['programada', 'confirmada','completada','vencida'])
                            ->count();
                        if($schedule >= 0){

                            $key_count++;
                            $service= Service::find($service->id);
                            if($service->type == 'sesion'){
                                if ($schedule > $i_2->qty) {
                                    if ($key2 > 0) {
                                        $pos = intval($key2)-1;
                                        $count_qty = $count_qty - $items_2[$pos]->qty;
                                    }else{
                                        $count_qty = $schedule;
                                    }
                                } else {
                                    if ($key2 > 0) {
                                        $count_qty = 0;
                                    } else {
                                        $count_qty = $schedule;
                                    }
                                }
                            }else{
                                if($schedule >= 1){
                                    if ($key2 > 0) {
                                        $pos = intval($key2)-1;
                                        $value_v = $count_qty;
                                        $count_qty = $count_qty - $items_2[$pos]->qty;
                                        if($count_qty >= 1){
                                            $count_qty = $i_2->qty;
                                        }else{
                                            $count_qty = 0;
                                        }
                                    }else{
                                        $count_qty = $i_2->qty;
                                        if($schedule > $i_2->qty){
                                            $count_qty = $schedule;
                                        }
                                    }
                                }else{
                                    $count_qty = 0;
                                }
                            }
                            if($count_qty <= $i_2->qty){

                                $item = Item::where('id',$i_2->id)
                                    ->where('contract_id',$contract->id)
                                    ->first();
                                $array[] = [
                                    "id" => $contract->id,
                                    "text" =>"C-" . $contract->id .' Servicio: '.$service->name.' ('.$count_qty.' de '.$i_2->qty.')'
                                ];
                            }
                        }
                        else{

                            if($contract->patient_id == $patient->id){
                                $array[] = ["id" => $contract->id, "text" =>"C-" . $contract->id];
                            }
                        }
                    }
                }
            }
        }
        return $array;
        return response(json_encode($array), 200)->header('Content-Type', 'text/json');
    }

    public function serviceListPatients(Request $request)
    {
        request()->validate([
            'id' => 'required|integer',
        ]);
        $patient_id = $request->id_patient;
        $services1 = \App\Models\Service::join('items','services.id','=','items.service_id')
            ->join('contracts','items.contract_id','=','contracts.id')
            ->where('contracts.patient_id',$patient_id)
            ->where(['services.status' => 'activo'])
            ->where('contracts.status','!=','anulado')
            ->where('contracts.status','!=','liquidado')
            ->where(['services.contract' => 'SI'])
            ->orderBy('services.name')
            ->select('services.*')
            ->groupBy('services.id')
            ->get();
        $services_2 = \App\Models\Service::where('status','activo')
            ->where('contract','no')
            ->get();
        $servicesSchedule = $services1->merge($services_2);
        return response(json_encode($servicesSchedule), 200)->header('Content-Type', 'text/json');
    }

    public function delete($id)
    {
        $this->authorize('delete', Service::class);
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('services.index')
            ->with('success','Servicio eliminado exitosamente');
    }
}
