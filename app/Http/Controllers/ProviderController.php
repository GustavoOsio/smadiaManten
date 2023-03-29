<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\State;
use Illuminate\Http\Request;

class ProviderController extends Controller
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
        $this->authorize('view', Provider::class);
        $data = Provider::orderByDesc('created_at')->get();
        return view('providers.index', ['providers' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Provider::class);
        return view('providers.create', [
            'states' => State::orderBy('name')->get(),
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
        $this->authorize('create', Provider::class);
        request()->validate([
            'nit' => 'required|string|max:15|min:6',
            'company' => 'required|string|max:255',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'phone' => 'required|string|max:12',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:providers',
            'cellphone' => 'required|string|max:12',
            'status' => 'required|alpha|max:8',
        ]);


        Provider::create([
            'nit' => $request->nit,
            'company' => $request->company,
            'address' => $request->address,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone_contact' => $request->phone_contact,
            'cellphone' => $request->cellphone,
            'status' => $request->status,
        ]);


        return redirect()->route('providers.index')
            ->with('success','Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Provider::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        $this->authorize('update', Provider::class);
        return view('providers.edit',[
            'Provider' => $provider,
            'states' => State::orderBy('name')->get(),
            'cities' => State::find($provider->state_id)->cities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $this->authorize('update', Provider::class);
        request()->validate([
            'nit' => 'required|string|max:15|min:6',
            'company' => 'required|string|max:255',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'phone' => 'required|string|max:12',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'cellphone' => 'required|string|max:12',
            'status' => 'required|alpha|max:8',
        ]);


        $provider->update([
            'nit' => $request->nit,
            'company' => $request->company,
            'address' => $request->address,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone_contact' => $request->phone_contact,
            'cellphone' => $request->cellphone,
            'status' => $request->status,
        ]);

        return redirect()->route('providers.index')
            ->with('success','Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $this->authorize('delete', Provider::class);
        $provider->delete();
        return redirect()->route('providers.index')
            ->with('success','Proveedor eliminado exitosamente');
    }
}
