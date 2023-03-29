<?php

namespace App\Exports;

use App\Models\PayDoctors;
use App\Models\PaymentAssistance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PayDoctorExport implements FromView, ShouldAutoSize
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
        if ($date_start != "" && $date_end != "" && $user != "") {
            $data = PayDoctors::whereBetween("created_at", [$date_start." 00:00:00", $date_end." 23:59:59"])
                ->where('asyst', $user)
                ->get();
        } else if ($date_start != "" && $date_end != "") {
            $data = PayDoctors::whereBetween("created_at", [$date_start." 00:00:00", $date_end." 23:59:59"])
                ->get();
        } else if ($user != ""){
            $data = PayDoctors::where('assistant', $user)->get();
        }else{
            $data = PayDoctors::all();
        }
        return view('exports.pay_doctors', [
            'payment' => $data
        ]);
    }
}
