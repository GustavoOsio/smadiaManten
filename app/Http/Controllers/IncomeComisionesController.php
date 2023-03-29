<?php

namespace App\Http\Controllers;

use App\Exports\CommissionIncomeExport;
use App\Models\IncomesComisiones;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class IncomeComisionesController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index()
    {
        $this->authorize('view', IncomesComisiones::class);
        return view('incomes-comisiones.index', [
            'incomesC' => IncomesComisiones::orderBy('id','desc')->get()
        ]);
    }

    public function exportComision(Request $request){
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "filter_user" => $request->query("filter_user")
        ];
        return Excel::download(new CommissionIncomeExport($data), 'comisiones-ingresos.xlsx');
    }

}
