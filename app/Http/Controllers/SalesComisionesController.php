<?php

namespace App\Http\Controllers;

use App\Exports\ComissionSaleExport;
use App\Models\BalanceBox;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Patient;
use App\Models\SalesComisiones;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SalesComisionesController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    public function index()
    {
        $this->authorize('view', SalesComisiones::class);
        return view('sales-comisiones.index', [
            'sales_c' => SalesComisiones::orderBy('id','desc')->get()
        ]);
    }

    public function exportComision(Request $request){
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "filter_user" => $request->query("filter_user")
        ];
        //dd($data);
        return Excel::download(new ComissionSaleExport($data), 'comisiones-ventas.xlsx');
    }

}
