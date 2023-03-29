<?php

namespace App\Exports;

use App\Models\SalesComisiones;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ComissionSaleExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data=[])
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $date_start = $this->data["date_start"];
        $date_end = $this->data["date_end"];
        $user = $this->data["filter_user"];
        $date_end = new \Carbon\Carbon($date_end);
        $date_end = $date_end->addDays(1);
        if ($date_start != "" && $date_end != "" && $user != "") {
            $data = SalesComisiones::whereBetween("created_at", [$date_start, $date_end])->where('seller_id', $user)->get();
        } else if ($date_start != "" && $date_end != "") {
            $data = SalesComisiones::whereBetween("created_at", [$date_start, $date_end])->get();
        } else if ($user != ""){
            $data = SalesComisiones::where('seller_id', $user)->get();
        }else{
            $data = SalesComisiones::get();
        }
        //dd($data);
        return view('exports.comission_sales', [
            'sales_c' => $data
        ]);
    }
}
