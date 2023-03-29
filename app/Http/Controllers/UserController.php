<?php

namespace App\Http\Controllers;

use App\Models\Blood;
use App\Models\Cellar;
use App\Models\CenterCost;
use App\Models\CommissionCentercost;
use App\Models\CommissionService;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceUser;
use App\Models\State;
use App\User;
use File;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $this->authorize('view', User::class);
        $users = User::orderByDesc('created_at')->get();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $services = Service::where(['status' => 'activo'])->orderBy('name')->get();
        return view('users.create', [
            'services'=>$services,
            'roles' => Role::where('status', 'activo')->get(),
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'arl' => Filter::where(['status' => 'activo', 'type' => 'arl'])->orderBy('name')->get(),
            'pension' => Filter::where(['status' => 'activo', 'type' => 'pension'])->orderBy('name')->get(),
            'bloods' => Blood::all(),
            'cellars' => Cellar::where('status','activo')->orderBy('name','asc')->get()
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
        $this->authorize('create', User::class);

        request()->validate([
            'role_id' => 'required|integer',
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'username' => 'required|string|max:30|unique:users',
            'identy' => 'required|string|max:10|min:7',
            'date_expedition' => 'required|date',
            'birthday' => 'required|date',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'gender_id' => 'required|integer',
            'address' => 'required|string|max:80',
            'phone' => 'required|numeric',
            'cellphone' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'arl_id' => 'required|integer',
            'pension_id' => 'required|integer',
            'blood_id' => 'required|integer',
            'f_name' => 'required|string|max:50',
            'f_lastname' => 'required|string|max:80',
            'f_address' => 'required|string|max:80',
            'f_cellphone' => 'required|numeric',
            'f_relationship' => 'required|string|min:3|max:20',
            'schedule' => 'required',
            'commission_contract'=>'required'
        ]);

        $user = User::create($request->except('photo'));

        if ($request->file('photo')) {
            $photo = time() . '-' . str_slug($user->name . " " . $user->lastname) . '.' .  $request->file('photo')->extension();
            $path = 'profile/' . $photo;
            $user->update([
                'photo' => $path
            ]);
            $request->file('photo')->move('profile', $photo);
        }
        /*
        $services = $request->services;
        foreach ($services as $i => $p){
            $id = $services[$i];
            ServiceUser::create([
                'service_id'=>$id,
                'user_id' => $user->id,
            ]);
        }
        */
        return redirect()->route('users.index')
            ->with('success','Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', User::class);
        return view('users.show', [
            'user' => User::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', User::class);
        $array = [];
        $service_user = ServiceUser::where('user_id',$user->id)->get();
        //dd($service_user);
        foreach ($service_user as $service) {
            $array[] = $service->service_id;
        }
        $services = Service::where(['status' => 'activo'])->orderBy('name')->get();
        $comissionCenterUser = CommissionCentercost::where('user_id',$user->id)->get();
        $comissionServiceUser = CommissionService::where('user_id',$user->id)->get();
        return view('users.edit', [
            'array' => $array,
            'services'=>$services,
            'roles' => Role::where('status', 'activo')->get(),
            'user' => $user,
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'arl' => Filter::where(['status' => 'activo', 'type' => 'arl'])->orderBy('name')->get(),
            'pension' => Filter::where(['status' => 'activo', 'type' => 'pension'])->orderBy('name')->get(),
            'bloods' => Blood::all(),
            'cities' => State::find($user->state_id)->cities,
            'cellars' => Cellar::where('status','activo')->orderBy('name','asc')->get(),
            'centers' => CenterCost::where(['status' => 'activo', 'type' => 'ingreso'])->orderBy('name')->get(),
            'comissionCenterUser'=>$comissionCenterUser,
            'comissionServiceUser'=>$comissionServiceUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);
        request()->validate([
            'role_id' => 'required|integer',
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'username' => 'required|string|max:30',
            'identy' => 'required|string|max:10|min:7',
            'date_expedition' => 'required|date',
            'birthday' => 'required|date',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'gender_id' => 'required|integer',
            'address' => 'required|string|max:80',
            'phone' => 'required|numeric',
            'cellphone' => 'required|numeric',
            'email' => 'required|email|',
            'pension_id' => 'required|integer',
            'blood_id' => 'required|integer',
            'blood_id' => 'required|integer',
            'f_name' => 'required|string|max:50',
            'f_lastname' => 'required|string|max:80',
            'f_address' => 'required|string|max:80',
            'f_phone' => 'required|numeric',
            'f_cellphone' => 'required|numeric',
            'f_relationship' => 'required|string|min:3|max:20',
            'schedule' => 'required',
        ]);

        if (!empty($request->password)) {
            request()->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user->update($request->except('photo'));
        } else {
            $user->update($request->except(['password', 'photo']));
        }

        if ($request->file('photo')) {
            $photo = time() . '-' . str_slug($user->name . " " . $user->lastname) . '.' .  $request->file('photo')->extension();
            $path = 'profile/' . $photo;
            $user->update([
                'photo' => $path
            ]);
            $request->file('photo')->move('profile', $photo);
        }
        /*
        $servicesUser = ServiceUser::where('user_id',$user->id)->delete();
        //$servicesUser->delete();
        $services = $request->services;
        foreach ($services as $i => $p){
            $id = $services[$i];
            ServiceUser::create([
                'service_id'=>$id,
                'user_id' => $user->id,
            ]);
        }
        */
        //comisiones_ingresos
        $comissionCenterUser = CommissionCentercost::where('user_id',$user->id)->delete();
        $center_cost = $request->center_cost_id;
        //dd($center_cost);
        $percent_center = $request->percent_center;
        if($center_cost != null){
            foreach ($center_cost as $i => $c){
                if($c != ''){
                    $id = $center_cost[$i];
                    $percent = $percent_center[$i];
                    if($percent > 0){
                        if($percent > 100){
                            $percent = 100;
                        }
                        CommissionCentercost::create([
                            'user_id' => $user->id,
                            'center_cost_id'=>$id,
                            'commission_income'=>$percent,
                        ]);
                    }
                }
            }
        }
        //comisiones_servicio
        $comissionServiceUser = CommissionService::where('user_id',$user->id)->delete();
        $service = $request->service_id;
        $percent_service = $request->percent_service;
        if($service != null) {
            foreach ($service as $i => $s) {
                if ($s != '') {
                    $id = $service[$i];
                    $percent = $percent_service[$i];
                    if ($percent > 0) {
                        if ($percent > 100) {
                            $percent = 100;
                        }
                        CommissionService::create([
                            'user_id' => $user->id,
                            'service_id' => $id,
                            'commission_service' => $percent,
                        ]);
                    }
                }
            }
        }
        return redirect()->route('users.index')
            ->with('success','Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);
        $user->delete();
        return redirect()->route('users.index')
            ->with('success','Usuario eliminado exitosamente');
    }
}
