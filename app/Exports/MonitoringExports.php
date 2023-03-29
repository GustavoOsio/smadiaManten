<?php

namespace App\Exports;

use App\Models\Monitoring;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonitoringExports implements FromView, ShouldAutoSize
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
        /*$date_end = new \Carbon\Carbon($date_end);
        $date_end = $date_end->addDays(1);*/
        if ($date_start != "" && $date_end != "") {
            $data = Monitoring::whereBetween("date", [$date_start, $date_end])->get();
        } else {
            $data = Monitoring::all();
        }

        return view('exports.monitorings', [
            'data' => $data
        ]);
    }
}
