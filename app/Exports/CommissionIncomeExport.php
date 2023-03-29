<?php

namespace App\Exports;

use App\Models\IncomesComisiones;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CommissionIncomeExport implements FromView, ShouldAutoSize
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
            $data = IncomesComisiones::whereBetween("created_at", [$date_start, $date_end])->where('seller_id', $user)->get();
        } else if ($date_start != "" && $date_end != "") {
            $data = IncomesComisiones::whereBetween("created_at", [$date_start, $date_end])->get();
        } else if ($user != ""){
            $data = IncomesComisiones::where('seller_id', $user)->get();
        }else{
            $data = IncomesComisiones::get();
        }
        //dd($data);
        return view('exports.comission_incomes', [
            'data' => $data
        ]);
    }
}
