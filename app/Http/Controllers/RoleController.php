<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceRole;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        $this->authorize('view', Role::class);
        $roles = Role::orderByDesc('created_at')->get();
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $services = Service::where(['status' => 'activo'])->orderBy('name')->get();
        return view('roles.create', [
            'services'=>$services,
            'menus' => Menu::where('status', 'activo')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        request()->validate([
            'name' => 'required|string|max:50|unique:roles',
            'superadmin' => 'required|numeric|max:1',
            'status' => 'required|alpha|max:8',
        ]);


        $role = Role::create([
            'name' => $request->name,
            'superadmin' => $request->superadmin,
            'status' => $request->status
        ]);

        foreach ($request->menu as $menu) {
            MenuRole::create([
                'menu_id' => $menu,
                'role_id' => $role->id,
                'visible' => $request->input("visible-" . $menu),
                'create' => $request->input("create-" . $menu),
                'update' => $request->input("update-" . $menu),
                'delete' => $request->input("delete-" . $menu),
            ]);
        }

        $services = $request->services;
        foreach ($services as $i => $p){
            $id = $services[$i];
            ServiceRole::create([
                'service_id'=>$id,
                'role_id' => $role->id,
            ]);
        }

        return redirect()->route('roles.index')
            ->with('success','Rol creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Role::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('update', Role::class);
        $array = [];
        $menuRole = [];
        foreach ($role->menus as $menu) {
            $array[] = $menu->id;
            $tem = MenuRole::where(['role_id' => $role->id, 'menu_id' => $menu->id])->first();
            if ($tem->visible == 1) {
                $menuRole[] = "visible-" . $menu->id . "-" . $role->id;
            }
            if ($tem->create == 1) {
                $menuRole[] = "create-" . $menu->id . "-" . $role->id;
            }
            if ($tem->update == 1) {
                $menuRole[] = "update-" . $menu->id . "-" . $role->id;
            }
            if ($tem->delete == 1) {
                $menuRole[] = "delete-" . $menu->id . "-" . $role->id;
            }
        }
        $array_2 = [];
        $service_user = ServiceRole::where('role_id',$role->id)->get();
        //dd($service_user);
        foreach ($service_user as $service) {
            $array_2[] = $service->service_id;
        }
        $services = Service::where(['status' => 'activo'])->orderBy('name')->get();
        return view('roles.edit',[
            'array_2' => $array_2,
            'services'=>$services,
            'menus' => Menu::where('status', 'activo')->get(), 'role' => $role, 'array' => $array, 'menuRole' => $menuRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', Role::class);
        request()->validate([
            'name' => 'required|string|max:50',
            'superadmin' => 'required|numeric|max:1',
            'status' => 'required|alpha|max:8',
        ]);

        $role->update([
            'name' => $request->name,
            'superadmin' => $request->superadmin,
            'status' => $request->status
        ]);
        $role->menus()->sync($request->menu);
        foreach ($request->menu as $menu) {
            $menuRol = MenuRole::where(['role_id' => $role->id, 'menu_id' => $menu]);
            $menuRol->update([
                'visible' => $request->input("visible-" . $menu),
                'create' => $request->input("create-" . $menu),
                'update' => $request->input("update-" . $menu),
                'delete' => $request->input("delete-" . $menu),
            ]);
        }

        $servicesUser = ServiceRole::where('role_id',$role->id)->delete();
        //$servicesUser->delete();
        $services = $request->services;
        //dd($services);
        if(!empty($services)){
            foreach ($services as $i => $p){
                $id = $services[$i];
                ServiceRole::create([
                    'service_id'=>$id,
                    'role_id' => $role->id,
                ]);
            }
        }

        return redirect()->route('roles.index')
            ->with('success','Rol actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', Role::class);
        if($role->id <> 1 && $role->id <> 2 && $role->id <> 7 && $role->id <> 8 && $role->id <> 9 && $role->id && 10){
            //$role->menus()->delete();
            $role->delete();
            return redirect()->route('roles.index')
                ->with('success','Rol eliminado exitosamente');
        }else{
            return redirect()->route('roles.index')
                ->with('success','Este Rol no puede ser eliminado');
        }
    }
}
