<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetDashboard;
use Illuminate\Http\Request;

class BudgetDashboardController extends Controller
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
        $this->authorize('view', BudgetDashboard::class);
        $budget = BudgetDashboard::orderByDesc('created_at')
                ->get();
        $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        return view('budget.index', ['budget' => $budget,'meses'=>$meses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', BudgetDashboard::class);
        $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $year=date("Y");
        return view('budget.create', [
            'meses'=>$meses,
            'year'=>$year
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
        $this->authorize('create', BudgetDashboard::class);

        $validate = BudgetDashboard::where('mouth',$request->mouth)
            ->where('year',$request->year)
            ->first();
        if(!empty($validate)){
            return redirect()->route('budget.create')
                ->with('alert','Ya se ha añadido un presupuesto en esa fecha');
        }
        request()->validate([
            'mouth' => 'required|numeric|max:12',
            'year' => 'required|numeric|max:3000',
            'value' => 'required|numeric ',
            'patients' => 'required|numeric',
        ]);


        $budgetDashboard = BudgetDashboard::create([
            'mouth' => $request->mouth,
            'year' => $request->year,
            'value' => $request->value,
            'patients' => $request->patients
        ]);

        return redirect()->route('budget.index')
            ->with('success','Presupuesto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', BudgetDashboard::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetDashboard $budget)
    {
        $this->authorize('update', BudgetDashboard::class);
        $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        setlocale(LC_ALL,"es_CO");
        ini_set('date.timezone','America/Bogota');
        date_default_timezone_set('America/Bogota');
        $year=date("Y");
        return view('budget.edit',
            [
                'budget' => $budget,
                'meses'=>$meses,
                'year'=>$year
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetDashboard $budgetDashboard)
    {
        $this->authorize('update', BudgetDashboard::class);
        $validate = BudgetDashboard::where('mouth',$request->mouth)
            ->where('year',$request->year)
            ->where('id','<>',$request->id)
            ->first();
        if(!empty($validate)){
            return redirect()->route('budget.edit',$request->id)
                ->with('alert','Ya se ha añadido un presupuesto en esa fecha');
        }
        request()->validate([
            'mouth' => 'required|numeric|max:12',
            'year' => 'required|numeric|max:3000',
            'value' => 'required|numeric ',
            'patients' => 'required|numeric',
        ]);

        $budgetDashboard = BudgetDashboard::find($request->id);
        $budgetDashboard->update([
            'mouth' => $request->mouth,
            'year' => $request->year,
            'value' => $request->value,
            'patients' => $request->patients
        ]);

        return redirect()->route('budget.index')
            ->with('success','Presupuesto actualizado exitosamente.');
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
        $role->menus()->delete();
        $role->delete();
        return redirect()->route('roles.index')
            ->with('success','Rol eliminado exitosamente');
    }
}
