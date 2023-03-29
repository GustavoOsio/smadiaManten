<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductExport implements FromView, ShouldAutoSize
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
        $type = $this->data["type"];
        $date_start = $this->data["date_start"];
        $date_end = $this->data["date_end"];
        $date_end = new \Carbon\Carbon($date_end);
        $date_end = $date_end->addDays(1);
        if ($date_start != "" && $date_end != "") {
            $data = Product::whereBetween("created_at", [$date_start, $date_end])->get();
        } else if($type != ''){
            $data = Product::where("inventory_id",$type)->get();
        }else{
            $data = Product::all();
        }
        //dd(count($data));
        return view('exports.products', [
            'data' => $data
        ]);
    }
}
