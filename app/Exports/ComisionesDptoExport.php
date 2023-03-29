<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Cellar;
use App\Models\comisionesmedicas;
use App\Models\Service;
use App\Models\CenterCost;
use App\User;
use App\Models\PaymentAssistance;
use App\Models\procedimientosmeta;
use App\Models\SaleProduct;

use App\Models\comisionesdepartamentos;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
class ComisionesDptoExport implements FromView, ShouldAutoSize
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
        $date_end = new \Carbon\Carbon($date_end);
        $date_end = $date_end->addDays(1);
        $idMedico = $this->data["idMedico"];

 
    }
}
