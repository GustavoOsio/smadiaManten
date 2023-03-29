<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Bank;
use Illuminate\Http\Request;

class AccountController extends Controller
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
        $this->authorize('view', Account::class);
        $data = Account::orderByDesc('created_at')->get();
        return view('accounts.index', ['accounts' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Account::class);
        return view('accounts.create', ['banks' => Bank::where('status', 'activo')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Account::class);
        request()->validate([
            'account' => 'required|string|max:40',
            'type' => 'required|alpha|max:10',
            'bank_id' => 'required|integer',
            'status' => 'required|alpha|max:8',
        ]);


        Account::create($request->all());


        return redirect()->route('accounts.index')
            ->with('success','Cuenta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Account::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $this->authorize('update', Account::class);
        return view('accounts.edit',['account' => $account, 'banks' => Bank::where('status', 'activo')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $this->authorize('update', Account::class);
        request()->validate([
            'account' => 'required|string|max:40',
            'type' => 'required|alpha|max:10',
            'bank_id' => 'required|integer',
            'status' => 'required|alpha|max:8',
        ]);


        $account->update([
            'account' => $request->account,
            'type' => $request->type,
            'bank_id' => $request->bank_id,
            'status' => $request->status,
        ]);

        return redirect()->route('accounts.index')
            ->with('success','Cuenta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $this->authorize('delete', Account::class);
        $account->delete();
        return redirect()->route('accounts.index')
            ->with('success','Cuenta eliminada exitosamente');
    }
}
