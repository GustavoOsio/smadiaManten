<?php

namespace App\Http\Controllers;

use App\Models\EmailConfirmation;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EmailConfirmationController extends Controller
{
    public function index()
    {
        $this->authorize('view', EmailConfirmation::class);
        $email = EmailConfirmation::find(1);
        return view('email-confirmation.index',[
            'email'=>$email
        ]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', EmailConfirmation::class);
        request()->validate([
            'text' => 'required',
            'address' => 'required',
            'firm' => 'required',
        ]);
        $EmailConfirmation = EmailConfirmation::find($request->id);
        $EmailConfirmation->text = $request->text;
        $EmailConfirmation->address = $request->address;
        $EmailConfirmation->firm = $request->firm;
        $EmailConfirmation->save();
        return redirect()->route('email-confirmation.index')
            ->with('success','Datos actualizados exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
