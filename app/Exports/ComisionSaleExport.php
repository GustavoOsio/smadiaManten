<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ComisionSaleExport implements FromView, ShouldAutoSize
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
            $data = Sale::whereBetween("created_at", [$date_start, $date_end])->where('seller_id', $user)->where('status','activo')->get();
        } else if ($date_start != "" && $date_end != "") {
            $data = Sale::whereBetween("created_at", [$date_start, $date_end])->where('status','activo')->get();
        } else if ($user != ""){
            $data = Sale::where('seller_id', $user)->where('status','activo')->get();
        }else{
            $data = Sale::where('status','activo')->get();
        }
        return view('exports.sale_comision', [
            'sales' => $data
        ]);
    }
}
