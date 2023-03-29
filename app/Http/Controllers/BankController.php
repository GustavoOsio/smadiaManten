<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
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
        $this->authorize('view', Bank::class);
        $data = Bank::orderByDesc('created_at')->paginate(10);
        return view('banks.index', ['banks' => $data])->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Bank::class);
        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Bank::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        Bank::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('banks.index')
            ->with('success','Banco creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Bank::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        $this->authorize('update', Bank::class);
        return view('banks.edit',['bank' => $bank]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $this->authorize('update', Bank::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        $bank->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('banks.index')
            ->with('success','Banco actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $this->authorize('delete', Bank::class);
        $bank->delete();
        return redirect()->route('banks.index')
            ->with('success','Banco eliminado exitosamente');
    }
}
