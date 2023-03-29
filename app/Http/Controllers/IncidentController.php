<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Monitoring::class);

        request()->validate([
            'responsable_id' => 'required|integer',
            'monitoring_id' => 'required|integer',
            'date' => 'required|date',
            'comment' => 'required|string|min:5',
        ]);

        Incident::create([
            'monitoring_id' => $request->monitoring_id,
            'responsable_id' => $request->responsable_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'comment' => $request->comment,
        ]);
        Monitoring::find($request->monitoring_id)->update([
            'responsable_id' => $request->responsable_id,
            "status" => "activo",
            'date' => $request->date,
            'comment' => $request->comment,
        ]);

        return response(json_encode(["message" => "Saved"]), 201)->header('Content-Type', 'text/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        //
    }
}
