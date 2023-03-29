<?php

namespace App\Exports;

use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ScheduleExport implements FromView, ShouldAutoSize
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
        //$date_end = new \Carbon\Carbon($date_end);
        $status = $this->data["states"];
        $filter = $this->data["filter"];
        //$date_end = $date_end->addDays(1);
        if($filter == 'all'){
            $data = Schedule::all();
        }else if($filter == 'date'){
            if ($date_start != "" && $date_end != "") {
                $data = Schedule::whereBetween("date", [$date_start, $date_end])->get();
            }else{
                $data = Schedule::all();
            }
        }else if($filter == 'states'){
            $data = Schedule::where('status',$status)
                ->whereBetween("date", [$date_start, $date_end])
                ->get();
        }
        //dd($data);
        return view('exports.schedule', [
            'data' => $data
        ]);
    }
}
