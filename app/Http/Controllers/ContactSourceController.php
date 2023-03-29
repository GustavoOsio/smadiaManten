<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactSource;
use Illuminate\Http\Request;

class ContactSourceController extends Controller
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
        $this->authorize('view', ContactSource::class);
        $data = ContactSource::orderByDesc('created_at')->get();
        return view('contact-sources.index', ['contact_sources' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ContactSource::class);
        return view('contact-sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', ContactSource::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        ContactSource::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('contact-sources.index')
            ->with('success','Fuente de contacto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', ContactSource::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactSource $contact_source)
    {
        $this->authorize('update', ContactSource::class);
        return view('contact-sources.edit',['contact_source' => $contact_source]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactSource $contact_source)
    {
        $this->authorize('update', ContactSource::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        $contact_source->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('contact-sources.index')
            ->with('success','Fuente de contacto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactSource $contact_source)
    {
        $this->authorize('delete', ContactSource::class);
        $contact_source->delete();
        return redirect()->route('contact-sources.index')
            ->with('success','Fuente de contacto eliminado exitosamente');
    }
}
