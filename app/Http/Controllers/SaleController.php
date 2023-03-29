<?php

namespace App\Http\Controllers;

use App\Exports\ComisionSaleExport;
use App\Exports\SaleExport;
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
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function __construct(PDF $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }


    public function index()
    {
        $this->authorize('view', Sale::class);


        #local
        // $data = Sale::where('status', 'activo')->paginate(15);
        // $data_sum = Sale::select(DB::raw("SUM(amount) as total"))->where('status', 'activo')->first();
        // $data_subtotal = Sale::select(DB::raw("SUM(sub_amount) as sub_total"))->where('status', 'activo')->first();
        // $data_iva = Sale::select(DB::raw("SUM(tax) as iva"))->where('status', 'activo')->first();
        // $data_descuento = Sale::select(DB::raw("SUM(discount) as descuento"))->where('status', 'activo')->first();


        // return view('sales.index', [
        //     'sales' => $data,
        //     'total' => $data_sum,
        //     'sub_total' => $data_subtotal,
        //     'iva' => $data_iva,
        //     'descuento'=> $data_descuento
        // ]);


        #codigo html 
//         <div class="pagination">
//     {{ $sales->links() }}
// </div>

// <tr>
//             <th class="align-text"></th>
//             <th class="align-text"></th>
//             <th class="align-text"></th>
//             <th class="align-text">$ <span class="total">{{number_format($total->total,2, ',', '.')}}</span></th>
//             <th class="align-text"></th>
//             <th class="align-text">$ <span class="subtotal">{{number_format($sub_total->sub_total,2, ',', '.')}}</span></th>
//             <th class="align-text">$ <span class="iva">{{number_format($iva->iva,2, ',', '.')}}</span></th>
//             <th class="align-text">$ <span class="descuento">{{number_format($descuento->descuento,2, ',', '.')}}</span></th>
//             <th class="align-text"></th>
//             <th class="align-text"></th>
//             <th class="align-text"></th>
//             <th class="align-text"></th>
//         </tr>
        #prod
        $user = Auth::user();
         $data = Sale::where('status', 'activo')->get();
        return view('sales.index', [
            'sales' => $data,
            'user'=> $user
        ]);
    }

    public function anuladas()
    {
        $this->authorize('view', Sale::class);

        return view('sales.anuladas', [
            'sales' => Sale::where('status', 'anulada')->get()
        ]);
    }

    public function comisiones()
    {
        $this->authorize('view', Sale::class);

        return view('sales.comisiones', [
            'sales' => Sale::where('status', 'activo')
                ->where('created_at', '<=', '2021-05-31 23:59:59')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Sale::class);

        return view('sales.create', [
            'products' => Product::all(),
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
        ]);
    }

    public function patient($id)
    {
        $this->authorize('create', Sale::class);
        return view('sales.create', [
            'patient' => Patient::find($id),
            'products' => Product::all(),
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Sale::class);
        request()->validate([
            'amount' => 'required',
            'patient_id' => 'required|integer',
            'method_payment' => 'required',
            'products' => 'required|array',
            'qty_products' => 'required',
            'seller_id' => 'required|integer',
        ]);
        $amounTotal = str_replace(".", "", $request->amount);
        $amounTotal = str_replace(",", "", $amounTotal);

        $subAmount = str_replace(".", "", $request->sub_amount);
        $subAmount = str_replace(",", "", $subAmount);

        $tax = str_replace(".", "", $request->tax);
        $tax = str_replace(",", "", $tax);

        //$discount = str_replace(".", "", $request->discount);
        //$discount = str_replace(",", "", $discount);

        $discount_total = str_replace(".", "", $request->discount_total);
        $discount_total = str_replace(",", "", $discount_total);

        $products = $request->products;
        $purchase_product_id = $request->purchase_product_id;
        $qty = $request->qty;
        foreach ($products as $i => $p) {
            if ($p != "") {
                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                if ($qty[$i] > $purchaseP->qty_inventory) {
                    return redirect()->route('sales.create')
                        ->with('error', 'La cantidad a vender no esta disponible en el lote '
                            . $purchaseP->lote .
                            ' en el producto ' . $purchaseP->product->name .
                            ' la cantidad disponible es ' . $purchaseP->qty_inventory);
                }
            }
        }


        $amounTotal_1 = str_replace(".", "", $request->amount_one);
        $amounTotal_1 = str_replace(",", "", $amounTotal_1);
        $amounTotal_2 = str_replace(".", "", $request->amount_two);
        $amounTotal_2 = str_replace(",", "", $amounTotal_2);

        $sale = Sale::create([
            'patient_id' => $request->patient_id,
            'user_id' => Auth::id(),
            'seller_id' => $request->seller_id,
            'sub_amount' => $subAmount,
            'amount' => $amounTotal,
            'tax' => $tax,
            //'type_discount' => $request->type_discount,
            //'discount' => $discount,
            'discount_total' => $discount_total,
            'qty_products' => $request->qty_products,
            'method_payment' => $request->method_payment,
            'number_account' => $request->number_account,
            'approval_number' => $request->approval_number,
            'type_of_card' => $request->type_of_card,
            'approved_of_card' => $request->approved_of_card,
            'card_entity' => $request->card_entity,
            'method_payment_2' => $request->method_payment_2,
            'number_account_2' => $request->number_account_2,
            'approval_number_2' => $request->approval_number_2,
            'type_of_card_"' => $request->type_of_card_2,
            'approved_of_card_2' => $request->approved_of_card_2,
            'card_entity_2' => $request->card_entity_2,
            'total_1' => $amounTotal_1,
            'total_2' => $amounTotal_2,
            'comments' => $request->comments,
            'partner_discount' => $request->partner_discount,
            'ref_epayco' => $request->ref_epayco,
            'approved_epayco' => $request->approved_epayco,
            'ref_epayco_2' => $request->ref_epayco_2,
            'approved_epayco_2' => $request->approved_epayco_2,
        ]);

        $price = $request->price;
        $desc = $request->desc;
        $desc_cop = $request->desc_cop;
        $total = $request->total;
        $tax_p = $request->tax_p;

        foreach ($products as $i => $p) {
            if ($p != "") {
                $price_p = str_replace(".", "", $price[$i]);
                $price_p = str_replace(",", "", $price_p);

                $desc_p = str_replace(".", "", $desc[$i]);
                $desc_p = str_replace(",", "", $desc_p);

                $desc_cop_save = str_replace(".", "", $desc_cop[$i]);
                $desc_cop_save = str_replace(",", "", $desc_cop_save);

                $total_p = str_replace(".", "", $total[$i]);
                $total_p = str_replace(",", "", $total_p);

                $sale_product = SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $products[$i],
                    'purchase_product_id' => $purchase_product_id[$i],
                    'qty' => $qty[$i],
                    'price' => $price_p,
                    'discount' => $desc_p,
                    'discount_cop' => $desc_cop_save,
                    'tax' => $tax_p[$i]
                ]);

                $validate_commission = true;
                if ($desc_p == 100 || $desc_cop_save >= $price_p) {
                    $validate_commission = false;
                }
                if ($request->partner_discount == 'si') {
                    $validate_commission = false;
                }
                if ($validate_commission == true) {

                    if ($desc_p == 0) {
                        $discount_comision = $desc_cop_save;
                    } else {
                        $discount_comision = ($price_p * $desc_p) / 100;
                        $discount_comision = $discount_comision * $qty[$i];
                    }

                    if ($request->method_payment_2 == '') {
                        $form_pay = $request->method_payment;
                    } else {
                        $form_pay = $request->method_payment . '/' . $request->method_payment_2;
                    }
                    $commission = $qty[$i] * $sale_product->product->price_vent;
                    SalesComisiones::create([
                        'sale_id' => $sale->id,
                        'product_id' => $products[$i],
                        'sales_product_id' => $sale_product->id,
                        'patient_id' => $request->patient_id,
                        'seller_id' => $request->seller_id,
                        'amount' => $total_p,
                        'discount' => $discount_comision,
                        'form_pay' => $form_pay,
                        'commission' => $commission,
                        'status' => $sale->status,
                    ]);
                }

                $purchaseP = PurchaseProduct::find($purchase_product_id[$i]);
                $cant_final = $purchaseP->qty_inventory - $qty[$i];
                if (($purchaseP->qty_inventory - $qty[$i]) < 0) {
                    $cant_final = 0;
                }
                $purchaseP->qty_inventory = $cant_final;
                $purchaseP->save();
            }
        }
        if ($request->method_payment == 'efectivo') {
            $dateToday = date("Y-m-d");
            if ($request->method_payment_2 == '') {
                $monto = $amounTotal;
            } else {
                $monto = $amounTotal_1;
            }
            $balanceBox = BalanceBox::create([
                'user_id' => Auth::id(),
                'patient_id' => $request->patient_id,
                'con_id' => $sale->id,
                'type' => 'Venta',
                'monto' => $monto,
                'date' => $dateToday,
            ]);
        }
        if ($request->method_payment_2 == 'efectivo') {
            $dateToday = date("Y-m-d");
            $balanceBox = BalanceBox::create([
                'user_id' => Auth::id(),
                'patient_id' => $request->patient_id,
                'con_id' => $sale->id,
                'type' => 'Venta',
                'monto' => $amounTotal_2,
                'date' => $dateToday,
            ]);
        }

        /*
        if ($request->receipt != "" && $request->method_payment == "tarjeta") {
            $data = base64_decode($request->receipt);
            $path = 'receipt/' . $request->approved_of_card . '-V-' . $sale->id .'.jpeg';
            file_put_contents( $path, $data );
            $sale->update([
                'receipt' => $path
            ]);
        }
       */
        session(['menu_patient_show' => 8]);
        return redirect('sales/pdf/' . $sale->id);
        return $this->generateBill($sale);

        return response(json_encode($sale), 201)->header('Content-Type', 'text/json');
    }

    public function generateBill($data)
    {
        $pdf = $this->pdf->loadView('pdf.bill', ['data' => $data]);
        return $pdf->stream('Factura ' . $data->id . '.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Sale::class);
        $sale = Sale::find($id);
        $patient =  Patient::where('id', $sale->patient_id)->first();
        $products = SaleProduct::where('sale_id', $sale->id)->get();
        return view('sales.show', [
            'sale' => $sale,
            'patient' => $patient,
            'products' => $products,
            'sellers' => User::where('status', 'activo')->orderBy('name', 'lastname')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function anulate($id)
    {
        $sale = Sale::find($id);
        $sale->status = 'anulada';
        $sale->update();
        if ($sale->method_payment == 'efectivo') {
            $dateToday = date("Y-m-d");
            $balanceBox = BalanceBox::where('con_id', $id)->first();
            $balanceBox->date = $dateToday;
            $balanceBox->type = 'Venta Anulada';
            $balanceBox->update();
        }
        return redirect('sales/' . $id);
    }
    public function anulatePost(Request $request)
    {
        $sale = Sale::find($request->id);
        $sale->status = 'anulada';
        $sale->observations = $request->value;
        $sale->update();
        $dateToday = date("Y-m-d");
        if ($sale->method_payment == 'efectivo') {
            $balanceBox = BalanceBox::where('con_id', $request->id)->where('type', 'Venta')->first();
            $balanceBox->date = $dateToday;
            $balanceBox->type = 'Venta Anulada';
            $balanceBox->update();
        }
        if ($sale->method_payment_2 == 'efectivo') {
            $balanceCount = BalanceBox::where('con_id', $request->id)->where('type', 'Venta')->get();
            if ($balanceCount->count() == 1) {
                $balanceBox = BalanceBox::find($balanceCount[0]->id);
                $balanceBox->date = $dateToday;
                $balanceBox->type = 'Venta Anulada';
                $balanceBox->update();
            } else {
                $balanceBox = BalanceBox::find($balanceCount[1]->id);
                $balanceBox->date = $dateToday;
                $balanceBox->type = 'Venta Anulada';
                $balanceBox->update();
            }
        }
        $productsSale = SaleProduct::where('sale_id', $request->id)->get();
        foreach ($productsSale as $ps) {
            $purchase = PurchaseProduct::find($ps->purchase_product_id);
            $purchase->qty_inventory = $purchase->qty_inventory + $ps->qty;
            $purchase->update();
        }
        return response(json_encode(["message" => "Saved."]), 201)->header('Content-Type', 'text/json');
    }



    public function exportComision(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "filter_user" => $request->query("filter_user")
        ];
        return Excel::download(new ComisionSaleExport($data), 'Comisiones.xlsx');
    }
    public function exportSale(Request $request)
    {
        $data = [
            "filter" => $request->query("filter"),
            "date_start" => $request->query("date_start"),
            "date_end" => $request->query("date_end"),
            "filter_user" => $request->query("filter_user")
        ];
        return Excel::download(new SaleExport($data), 'ventas.xlsx');
    }

    public function generatePDF($id)
    {
        $sale = Sale::find($id);
        return $this->generateBill($sale);
    }

    public function searhinfo(Request $request){
        $this->authorize('view', Sale::class);
        #local
        return $data = Sale::where('status', 'activo')->paginate(1);
        return view('sales.index', [
            'sales' => $data,
            
        ]);
        // return response(json_encode(["message" => "Hola mundo."]), 200)->header('Content-Type', 'text/json');
    }
}
