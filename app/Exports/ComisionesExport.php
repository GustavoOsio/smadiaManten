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

use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
class ComisionesExport implements FromView, ShouldAutoSize
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





        $data = Income::select(['incomes.*','comisionesmedicas.*'])
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->where('idMedico', $idMedico)
        ->where('tipoComision', 'VENTA')
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();
        $suma=0;



        //return $metaArray
        $array_tc = " incomes. in (94,97,98,99,101,102,103,104,110,112,114)";
        $meta = Income::select(['incomes.*'])
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->whereIn('incomes.center_cost_id', [11,12,14,15,16,18,19,21,24,30])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();
        foreach($meta as $dat){

            $suma+=$dat->amount;

        }


$comisionesmedicas = comisionesmedicas::where('idMedico', $idMedico)->get();
$medico = User::where('id', $idMedico)->first();

 $nombreMedico=$medico->name." ".$medico->lastname;

   $comisionesmedicas = comisionesmedicas::where('tipoComision', 'PROCEDIMIENTO')
                      ->where('idMedico', $idMedico)
                      ->first();


         //return number_format($suma);
         if($comisionesmedicas!=""){
            $porcentajeMeta=($suma*100)/$comisionesmedicas->metaMensual;
         }


         $dataSuero=[];
         if($idMedico==7){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
            ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
            ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
            ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
            ->where('asyst','LIKE','%'.$nombreMedico.'%')
            ->where('services.id','!=', 5)
            ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
            ->groupBy('payment_assistance.id')
            ->get();



        if(sizeof($query)==0){

            $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
            ->join('services', 'services.name', '=', 'payment_assistance.serv')
          ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
          ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
          ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
          ->where('comisionesmedicas.porcentajeDesde','!=',0)
          ->where('comisionesmedicas.porcentajeHasta','!=',0)
          ->where('services.id','!=', 5)
          ->orWhere( function($comisiones2) use ($porcentajeMeta) {
              $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
                    ->whereNull('comisionesmedicas.porcentajeHasta');
          })
          ->where('asyst','LIKE','%'.$nombreMedico.'%')
          ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
          ->get();

        }

        $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->groupBy('id')
       ->get();

       $queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->groupBy('id')
       ->get();

    } elseif($idMedico==39){

         $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('services.id','!=', 5)
        ->whereNotIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)','Mad Laser 3 Zonas'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->groupBy('id')
        ->get();

        if(sizeof($query)==0){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
       ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

       }
     $queryMadCount = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','Mad Laser 3 Zonas'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->groupBy('id')
       ->get();

     $SumqueryMadCount = sizeof($queryMadCount);

        $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','Mad Laser 3 Zonas'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
       ->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
       ->groupBy('id')
       ->get();


       $queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
       ->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
       ->groupBy('id')
       ->get();

    } elseif($idMedico==9){


        $data = Income::select(['incomes.*','comisionesmedicas.*'])->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->where('idMedico', $idMedico)
        ->where('tipoComision', 'VENTA')
        ->whereNotIn('incomes.center_cost_id', [1,3])
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();

        $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('services.id','!=', 5)
        ->whereNotIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->groupBy('id')
        ->get();

        if(sizeof($query)==0){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
       ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereNotIn('services.id', [69,70,111,113,114,116,119,124])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

       }
/*empieza mad laser*/
         $queryMadCount = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->groupBy('id')
       ->get();

     $SumqueryMadCount = sizeof($queryMadCount);

         $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('services.id','!=', 5)
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
       ->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
       ->orWhere( function($comisiones2) use ($SumqueryMadCount,$idMedico) {
           $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
                 ->whereNull('comisionesmedicas.porcentajeHasta')
                 ->where('comisionesmedicas.idMedico',$idMedico);
       })
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->groupBy('id')
       ->get();
/*Termina madlaser*/


/* empieza lipoval */


 $queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
->join('services', 'services.name', '=', 'payment_assistance.serv')
->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
->where('services.id','!=', 5)
->where('comisionesmedicas.idMedico',$idMedico)
->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
->orWhere( function($comisiones2) use ($SumqueryMadCount,$idMedico) {
    $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
          ->whereNull('comisionesmedicas.porcentajeHasta')
          ->where('comisionesmedicas.idMedico',$idMedico);
})
->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
->where('asyst','LIKE','%'.$nombreMedico.'%')
->where('comisionesmedicas.idMedico',$idMedico)
->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
->groupBy('id')
->get();

/* termina lipoval */


    }
    elseif($idMedico==49){

        $data = Income::select(['incomes.*','comisionesmedicas.*'])->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->where('idMedico', $idMedico)
        ->where('tipoComision', 'VENTA')
        ->whereNotIn('incomes.center_cost_id', [1,3])
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();

        $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('services.id','!=', 5)
        ->whereNotIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)','Mad Laser 3 Zonas'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->groupBy('id')
        ->get();

        if(sizeof($query)==0){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
       ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereNotIn('services.id', [69,70,111,113,114,116,119,124])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

       }
      /*empieza mad laser*/
      $queryMadCount = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
      ->join('services', 'services.name', '=', 'payment_assistance.serv')
      ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
      ->where('asyst','LIKE','%'.$nombreMedico.'%')
      ->where('services.id','!=', 5)
      ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)','Mad Laser 3 Zonas'])
      ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
      ->where('comisionesmedicas.idMedico',$idMedico)
      ->groupBy('id')
      ->get();

        $SumqueryMadCount = sizeof($queryMadCount);

     $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('services.id','!=', 5)
        ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','Mad Laser 3 Zonas'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
        ->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
        ->orWhere( function($comisiones2) use ($SumqueryMadCount, $idMedico, $nombreMedico) {
            $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
                  ->whereNull('comisionesmedicas.porcentajeHasta')
                  ->where('comisionesmedicas.idMedico',$idMedico)
                  ->where('asyst','LIKE','%'.$nombreMedico.'%');
        })
        ->groupBy('id')
        ->get();
/*Termina madlaser*/


/* empieza lipoval */


$queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
->join('services', 'services.name', '=', 'payment_assistance.serv')
->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
->where('services.id','!=', 5)
->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
->where('asyst','LIKE','%'.$nombreMedico.'%')
->where('comisionesmedicas.idMedico',$idMedico)
->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
->orWhere( function($comisiones2) use ($SumqueryMadCount, $idMedico, $nombreMedico) {
    $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
          ->whereNull('comisionesmedicas.porcentajeHasta')
          ->where('comisionesmedicas.idMedico',$idMedico)
          ->where('asyst','LIKE','%'.$nombreMedico.'%');
})
->groupBy('id')
->get();
/* termina lipoval */


    }

    elseif($idMedico==41){

        $data = Income::select(['incomes.*','comisionesmedicas.*'])->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->where('idMedico', $idMedico)
        ->where('tipoComision', 'VENTA')
        ->whereNotIn('incomes.center_cost_id', [1,3])
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();

        $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('services.id','!=', 5)
        ->whereNotIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->groupBy('id')
        ->get();

        if(sizeof($query)==0){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
       ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereNotIn('services.id', [69,70,111,113,114,116,119,124])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

       }
      /*empieza mad laser*/
      $queryMadCount = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
      ->join('services', 'services.name', '=', 'payment_assistance.serv')
      ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
      ->where('asyst','LIKE','%'.$nombreMedico.'%')
      ->where('services.id','!=', 5)
      ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
      ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
      ->where('comisionesmedicas.idMedico',$idMedico)
      ->groupBy('id')
      ->get();

        $SumqueryMadCount = sizeof($queryMadCount);

        $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
      ->join('services', 'services.name', '=', 'payment_assistance.serv')
      ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
      ->where('services.id','!=', 5)
      ->where('comisionesmedicas.idMedico',$idMedico)
      ->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
      ->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
      ->orWhere( function($comisiones2) use ($SumqueryMadCount,$idMedico) {
          $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
                ->whereNull('comisionesmedicas.porcentajeHasta')
                ->where('comisionesmedicas.idMedico',$idMedico);
      })
      ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
      ->where('asyst','LIKE','%'.$nombreMedico.'%')
      ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
      ->groupBy('id')
      ->get();
/*Termina madlaser*/


/* empieza lipoval */


$queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
->join('services', 'services.name', '=', 'payment_assistance.serv')
->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
->where('services.id','!=', 5)
->where('comisionesmedicas.idMedico',$idMedico)
->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
->orWhere( function($comisiones2) use ($SumqueryMadCount,$idMedico) {
   $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
         ->whereNull('comisionesmedicas.porcentajeHasta')
         ->where('comisionesmedicas.idMedico',$idMedico);
})
->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
->where('asyst','LIKE','%'.$nombreMedico.'%')
->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
->groupBy('id')
->get();

/* termina lipoval */


    }elseif($idMedico==53){

        $data = Income::select(['incomes.*','comisionesmedicas.*'])->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->where('idMedico', $idMedico)
        ->where('tipoComision', 'VENTA')
        ->whereNotIn('incomes.center_cost_id', [1,3])
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();

        $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('services.id','!=', 5)
        ->whereNotIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->groupBy('id')
        ->get();

        if(sizeof($query)==0){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
       ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereNotIn('services.id', [69,70,111,113,114,116,119,124])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

       }
      /*empieza mad laser*/
      $queryMadCount = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
      ->join('services', 'services.name', '=', 'payment_assistance.serv')
      ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
      ->where('asyst','LIKE','%'.$nombreMedico.'%')
      ->where('services.id','!=', 5)
      ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
      ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
      ->where('comisionesmedicas.idMedico',$idMedico)
      ->groupBy('id')
      ->get();

        $SumqueryMadCount = sizeof($queryMadCount);

        $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('services.id','!=', 5)
        ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
        ->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
        ->orWhere( function($comisiones2) use ($SumqueryMadCount, $idMedico, $nombreMedico) {
            $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
                  ->whereNull('comisionesmedicas.porcentajeHasta')
                  ->where('comisionesmedicas.idMedico',$idMedico)
                  ->where('asyst','LIKE','%'.$nombreMedico.'%');
        })
        ->groupBy('id')
        ->get();
/*Termina madlaser*/


/* empieza lipoval */


$queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
->join('services', 'services.name', '=', 'payment_assistance.serv')
->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
->where('services.id','!=', 5)
->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
->where('asyst','LIKE','%'.$nombreMedico.'%')
->where('comisionesmedicas.idMedico',$idMedico)
->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
->orWhere( function($comisiones2) use ($SumqueryMadCount, $idMedico, $nombreMedico) {
    $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
          ->whereNull('comisionesmedicas.porcentajeHasta')
          ->where('comisionesmedicas.idMedico',$idMedico)
          ->where('asyst','LIKE','%'.$nombreMedico.'%');
})
->groupBy('id')
->get();
/* termina lipoval */



    }


    elseif($idMedico==11){


         $data = Income::select(['incomes.*','comisionesmedicas.*'])
         ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
        ->whereBetween("incomes.created_at", [$date_start, $date_end])
        ->where('seller_id', $idMedico)
        ->where('idMedico', $idMedico)
        ->where('tipoComision', 'VENTA')
        ->whereNotIn('incomes.center_cost_id', [1,3])
        ->whereNotIn('method_of_pay', ['unificacion','software'])
        ->whereNotIn('status', ['anulado'])
        ->where('amount','>',0)
        ->groupBy('incomes.id')
        ->get();

        $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
        ->join('services', 'services.name', '=', 'payment_assistance.serv')
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
        ->where('asyst','LIKE','%'.$nombreMedico.'%')
        ->where('services.id','!=', 5)
        ->whereNotIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
        ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
        ->where('comisionesmedicas.idMedico',$idMedico)
        ->groupBy('id')
        ->get();

        if(sizeof($query)==0){
            $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
       ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereNotIn('services.id', [69,70,111,113,114,116,119,124])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

       }
/*empieza mad laser*/
         $queryMadCount = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->where('services.id','!=', 5)
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad','LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->groupBy('id')
       ->get();

     $SumqueryMadCount = sizeof($queryMadCount);

         $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
       ->join('services', 'services.name', '=', 'payment_assistance.serv')
       ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
       ->where('services.id','!=', 5)
       ->where('comisionesmedicas.idMedico',$idMedico)
       ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
       ->where('asyst','LIKE','%'.$nombreMedico.'%')
       ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
       ->groupBy('id')
       ->get();
/*Termina madlaser*/


/* empieza lipoval */


 $queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
->join('services', 'services.name', '=', 'payment_assistance.serv')
->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
->where('services.id','!=', 5)
->where('comisionesmedicas.idMedico',$idMedico)
->where('comisionesmedicas.porcentajeDesde','<=',$SumqueryMadCount)
->where('comisionesmedicas.porcentajeHasta','>=',$SumqueryMadCount)
->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
->where('asyst','LIKE','%'.$nombreMedico.'%')
->where('comisionesmedicas.idMedico',$idMedico)
->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
->groupBy('id')
->get();

/* termina lipoval */


    }

    elseif($idMedico==8){


        $data = Income::select(['incomes.*','comisionesmedicas.*'])
        ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
       ->whereBetween("incomes.created_at", [$date_start, $date_end])
       ->where('seller_id', $idMedico)
       ->where('idMedico', $idMedico)
       ->where('tipoComision', 'VENTA')
       ->whereNotIn('incomes.center_cost_id', [2])
       ->whereNotIn('method_of_pay', ['unificacion','software'])
       ->whereNotIn('status', ['anulado'])
       ->where('amount','>',0)
       ->groupBy('incomes.id')
       ->get();

       $dataSueroSum = Income::select([DB::raw('SUM(incomes.amount) AS sum_of_1')])
      ->whereBetween("incomes.created_at", [$date_start, $date_end])
      ->where('seller_id', $idMedico)
      ->whereIn('incomes.center_cost_id', [2])
      ->whereNotIn('method_of_pay', ['unificacion','software'])
      ->whereNotIn('status', ['anulado'])
      ->where('amount','>',0)
     ->groupBy('incomes.id')
      ->first();



       $comisionesmedicas = comisionesmedicas::where('tipoComision', 'VENTA')
      ->where('idMedico', $idMedico)
      ->first();

       $porceMeta=($dataSueroSum->sum_of_1/$comisionesmedicas->metaMensual)*100;


       $dataSuero = Income::select(['incomes.*','comisionesmedicas.*'])
      ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'incomes.center_cost_id')
     ->whereBetween("incomes.created_at", [$date_start, $date_end])
     ->where('seller_id', $idMedico)
     ->where('idMedico', $idMedico)
     ->where('tipoComision', 'VENTA')
     ->where('comisionesmedicas.porcentajeDesde','<=',$porceMeta)
     ->where('comisionesmedicas.porcentajeHasta','>=',$porceMeta)
     ->whereIn('incomes.center_cost_id', [2])
     ->whereNotIn('method_of_pay', ['unificacion','software'])
     ->whereNotIn('status', ['anulado'])
     ->where('amount','>',0)
     ->groupBy('incomes.id')
     ->get();
     $query="";
     $queryMad=[];
     $queryLipo=[];

   }
   if($idMedico==67){

    $query = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
    ->join('services', 'services.name', '=', 'payment_assistance.serv')
  ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
  ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
  ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
  ->where('comisionesmedicas.porcentajeDesde','!=',0)
  ->where('comisionesmedicas.porcentajeHasta','!=',0)
  ->where('services.id','!=', 5)
  ->orWhere( function($comisiones2) use ($porcentajeMeta) {
      $comisiones2->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
            ->whereNull('comisionesmedicas.porcentajeHasta');
  })
  ->where('asyst','LIKE','%'.$nombreMedico.'%')
  ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();



  if(sizeof($query)==0){
       $query = PaymentAssistance::join('services', 'services.name', '=', 'payment_assistance.serv')
  ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
  ->where('comisionesmedicas.porcentajeDesde','<=',$porcentajeMeta)
  ->where('comisionesmedicas.porcentajeHasta','>=',$porcentajeMeta)
  ->where('asyst','LIKE','%'.$nombreMedico.'%')
  ->where('services.id','!=', 5)
  ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])->get();

  }

  $queryMad = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
 ->join('services', 'services.name', '=', 'payment_assistance.serv')
 ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
 ->where('asyst','LIKE','%'.$nombreMedico.'%')
 ->where('services.id','!=', 5)
 ->whereIn('payment_assistance.serv', ['Mad Laser', 'Otros Mad'])
 ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
 ->where('comisionesmedicas.idMedico',$idMedico)
 ->groupBy('id')
 ->get();

 $queryLipo = PaymentAssistance::select(['payment_assistance.*','comisionesmedicas.*'])
 ->join('services', 'services.name', '=', 'payment_assistance.serv')
 ->join('comisionesmedicas', 'comisionesmedicas.idProcedimiento', '=', 'services.id')
 ->where('asyst','LIKE','%'.$nombreMedico.'%')
 ->where('services.id','!=', 5)
 ->whereIn('payment_assistance.serv', ['LipoVal 4 zonas', 'Lipoval Otros', 'LipoVal (Vaser)'])
 ->whereBetween("payment_assistance.created_at", [$date_start, $date_end])
 ->where('comisionesmedicas.idMedico',$idMedico)
 ->groupBy('id')
 ->get();

}

 $comisionesProductos = SaleProduct::select(['products.name','products.price_vent', DB::raw('SUM(sales_products.qty) AS sum_of_1')])
                                 ->join('products', 'products.id', '=', 'sales_products.product_id')
                                 ->join('sales', 'sales.id', '=', 'sales_products.sale_id')
                                 ->where('sales.seller_id', $idMedico)
                                 ->where('sales.status', '!=', 'anulada')
                                 ->whereBetween("sales_products.created_at", [$date_start, $date_end])
                                 ->groupBy('products.id')
                                 ->get();


return view('exports.comisionesMedicas', [
    'data' => $data,
    'comisiones' => $comisionesmedicas,
    'asistenciales'=> $query,
    'productos' => $comisionesProductos,
    'madLaser' => $queryMad,
    'lipoVal' => $queryLipo,
    'dataSuero' => $dataSuero
]);


    }
}
