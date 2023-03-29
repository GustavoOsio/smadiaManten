@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Ver Venta V-{{$sale->id}}
                @if($sale->status != "activo")
                    <span style="color: red">ANULADA </span>
                @endif
                </h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @can('delete', \App\Models\Sale::class)
                <div class="float-right">
                    @if($sale->status == "activo")
                        <a>
                            <div class="btn btn-primary btn-cancel"
                                id="anulateVenta"
                                data-id="{{ $sale->id }}">
                                <span class="icon-close1"></span> Anular
                            </div>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <form id="" method="POST" action="">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-sale">
                    <thead>
                    <th width="250px" class="fl-ignore">C.C - Cliente</th>
                    <th class="fl-ignore">Nombre</th>
                    <th class="fl-ignore">Ciudad</th>
                    <th class="fl-ignore">Dirección</th>
                    <th class="fl-ignore">Celular</th>
                    <th class="fl-ignore"></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="identy" id="patient_identy" readonly autocomplete="off" value="{{$patient->identy}}">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="patient_name" readonly value="{{$patient->name}} {{$patient->lastname}}" autocomplete="off">
                            </td>
                            <td><input type="text" class="form-control" readonly id="patient_city" value="{{($patient->city !='')?$patient->city->name:''}}"></td>
                            <td><input type="text" class="form-control" readonly id="patient_address" value="{{$patient->address}}"></td>
                            <td><input type="text" class="form-control" readonly id="patient_cellphone" value="{{$patient->cellphone}}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-sale">
                    <thead>
                        <th class="fl-ignore">Código</th>
                        <th class="fl-ignore">Producto</th>
                        <th class="fl-ignore">Presentación</th>
                        <th class="fl-ignore">Cant.</th>
                        <th class="fl-ignore">Lote</th>
                        <th class="fl-ignore">Vence</th>
                        <th class="fl-ignore">Valor</th>
                        <th class="fl-ignore">IVA</th>
                        <th class="fl-ignore">Desc. %</th>
                        <th class="fl-ignore">Desc. $</th>
                        <th class="fl-ignore">Total</th>
                        <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                        @foreach($products as $key => $p)
                        <tr id="rowToClone-{{$key+1}}">
                            <td width="50px">
                                <input type="text" class="form-control" name="reference[]" id="reference-{{$key+1}}" value="{{$p->product->reference}}" readonly="" data-id="1">
                            </td>
                            <td width="240px">
                                <input type="text" class="form-control" value="{{$p->product->name}}" readonly="">
                            </td>
                            <td width="160px">
                                <input type="text" class="form-control" value="{{$p->product->presentation->name}}" readonly="">
                            </td>
                            <td width="35px">
                                <input type="text" class="form-control" value="{{round($p->qty)}}" readonly="">
                            </td>
                            <td>
                                <input type="text" value="{{$p->purchase->lote}}" class="form-control" readonly="">
                            </td>
                            <td width="110px">
                                <input type="text" value="{{$p->purchase->expiration}}" class="form-control" readonly="">
                            </td>
                            <td>
                                <input type="text" value="{{ number_format(($p->price), 0, ',', '.') }}" class="form-control" readonly="">
                            </td>
                            <td width="55px">
                                <input type="text" value="{{ number_format($p->tax,0, ',', '.')}}" class="form-control" readonly="">
                            </td>
                            <td width="100px">
                                <input type="text" value="{{ number_format(($p->discount), 0, ',', '.') }}" class="form-control" readonly="">
                            </td>
                            <td width="100px">
                                <input type="text" value="{{ number_format(($p->discount_cop), 0, ',', '.') }}" class="form-control" readonly="">
                            </td>
                            @php
                                if($p->discount == 0){
                                    $desc = $p->price * $p->qty;
                                    $desc = $desc - $p->discount_cop;
                                }else{
                                    $desc = $p->price - ( ( $p->price * $p->discount) / 100);
                                    $desc = $desc * $p->qty;
                                }
                            @endphp
                            <td>
                                <input type="text" class="form-control" value="{{ number_format(($desc), 0, ',', '.') }}" readonly="">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Sub Total</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="sub_amount" readonly class="form-control" placeholder="0" required value="{{ number_format(($sale->sub_amount), 0, ',', '.') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Total IVA</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="tax" readonly class="form-control" value="{{ number_format(($sale->tax), 0, ',', '.') }}" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Cant. productos</label>
                            <div class="form-group">
                                <input type="text" name="qty_products" id="qty_products" readonly class="form-control" value="{{$sale->qty_products}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" id="discount_total" name="discount_total" readonly="" class="form-control" placeholder="{{number_format($sale->discount_total, 0, ',', '.')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Total venta</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="amount" readonly class="form-control" placeholder="0" readonly="" value="{{ number_format(($sale->amount), 0, ',', '.') }}">
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento</label>
                            <div class="form-group">
                                <select id="getDiscount" class="form-control" readonly="" disabled>
                                    <option value="0" {{($sale->discount == 0)?'selected':''}}>No</option>
                                    <option value="1" {{($sale->discount != 0)?'selected':''}}>Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Tipo Descuento</label>
                            <div class="form-group">
                                <select id="type_discount" name="type_discount" class="form-control" disabled>
                                    <option value="percent" {{($sale->type_discount == 'percent')?'selected':''}}>%</option>
                                    <option value="price" {{($sale->type_discount == 'price')?'selected':''}}>$</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento valor</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="discount" id="discount" class="form-control" placeholder="0" readonly="" value="{{round($sale->discount)}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" id="discount_total" name="discount_total" readonly="" class="form-control" placeholder="{{round($sale->discount_total)}}">
                            </div>
                        </div>
                    </div>
                    -->
                    <!--
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Comentarios</strong>
                                <textarea class="form-control" readonly rows="6">{{$sale->comments}}</textarea>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="row" style="margin-bottom: 0px">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-6">
                            <label for="" class="c-primary font-weight-bold">Descuento de colaborador</label>
                            <div class="form-group">
                                <select name="partner_discount" class="form-control" required readonly="" disabled>
                                    <option value="" selected>Seleccione</option>
                                    <option value="no" {{($sale->partner_discount == 'no')?'selected':''}} >NO</option>
                                    <option value="si" {{($sale->partner_discount == 'si')?'selected':''}}>SI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="c-primary font-weight-bold">Vendedor</label>
                            <div class="form-group">
                                <select name="seller_id" class="form-control" required readonly="" disabled>
                                    <option value="">Seleccione</option>
                                    @foreach($sellers as $s)
                                        <option value="{{ $s->id }}" {{($sale->seller->id == $s->id)?'selected':''}}>{{ $s->name . " " . $s->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row" style="margin-bottom: 0px">
                                <div class="col-md-6">
                                    <label for="" class="c-primary font-weight-bold">Forma de pago</label>
                                    <div class="form-group">
                                        <input type="text" readonly="" class="form-control" value="{{$sale->method_payment}}">
                                        <select name="method_payment_show_venta" class="form-control" style="visibility: hidden">
                                            <option value="efectivo" {{($sale->method_payment == 'efectivo')?'selected':''}}>Efectivo</option>
                                            <option value="tarjeta" {{($sale->method_payment == 'tarjeta')?'selected':''}}>Tarjeta</option>
                                            <option value="consignacion" {{($sale->method_payment == 'consignacion')?'selected':''}}>Consignación</option>
                                            <option value="transferencia" {{($sale->method_payment == 'transferencia')?'selected':''}}>Transferencia</option>
                                            <option value="online" {{($sale->method_payment == 'online')?'selected':''}}>Online</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 priceOne">
                                    @if($sale->method_payment_2 != '')
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Valor</label>
                                            <input type="text" class="form-control"
                                                   name="amount_one"
                                                   readonly
                                                   value="{{number_format($sale->total_1,0,',','.')}}"
                                            >
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12 tarjeta">
                            <div class="form-group" style="line-height: 24px;margin-bottom: 0px">
                                <div class="row" style="margin-bottom: 0px;margin-top: 0px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Tipo de tarjeta</strong>
                                            <select name="type_of_card" id="type_of_card" class="form-control" disabled readonly>
                                                <option value="">Seleccione</option>
                                                <option value="debito" {{($sale->type_of_card == 'debito')?'selected':''}}>Debito Maestro</option>
                                                <option value="mastercard" {{($sale->type_of_card == 'mastercard')?'selected':''}}>Mastercard</option>
                                                <option value="visa" {{($sale->type_of_card == '')?'visa':''}}>Visa</option>
                                                <option value="american express" {{($sale->type_of_card == 'american express')?'selected':''}}>American Express</option>
                                                <option value="dinners club" {{($sale->type_of_card == 'dinners club')?'selected':''}}>Dinners Club</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Aprobación de Tarjeta</strong>
                                            <input type="text" class="form-control" name="approved_of_card" value="{{$sale->approved_of_card}}" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Entidad de Tarjeta</strong>
                                            <input type="text" class="form-control" name="card_entity" value="{{$sale->card_entity}}" readonly="">
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <strong>Recibo</strong>
                                            <a href="{{asset($sale->receipt)}}" target="_blank">
                                                <img style="width: 100%" src="{{asset($sale->receipt)}}" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 online">
                            <div class="form-group" style="line-height: 24px;margin-bottom: 0px">
                                <div class="row" style="margin-bottom: 0px;margin-top: 0px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Referencia Epayco</label>
                                            <input type="text" class="form-control" name="ref_epayco" value="{{$sale->ref_epayco}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Numero de aprobacion</label>
                                            <input type="text" class="form-control" name="approved_epayco" value="{{$sale->approved_epayco}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 consignacion">
                            <div class="form-group" style="line-height: 24px;margin-bottom: 0px">
                                <div class="row" style="margin-bottom: 0px;margin-top: 0px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Numero de cuenta</label>
                                            <input type="text" class="form-control" name="number_account" value="{{$sale->number_account}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Código de aprobación</label>
                                            <input type="text" class="form-control" name="approval_number" value="{{$sale->approval_number}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        @if($sale->status != "activo")
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong style="color: red">Observacion al anular</strong>
                                    <textarea class="form-control" readonly>{{$sale->observations}}</textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12">
                            <div class="row" style="margin-bottom: 0px">
                                @if($sale->method_payment_2 != '')
                                    <div class="col-md-6">
                                            <label for="" class="c-primary font-weight-bold">Forma de pago 2</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="method_payment_2" value="{{$sale->method_payment_2}}" readonly>
                                            </div>
                                    </div>
                                    <div class="col-md-6 priceTwo">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Valor</label>
                                            <input type="text" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)" name="amount_two" readonly value="{{number_format($sale->total_2,0,',','.')}}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12 tarjeta2">
                            <div class="form-group" style="line-height: 24px">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Tipo de tarjeta</strong>
                                            <select name="type_of_card_2" id="type_of_card_2" class="form-control" readonly>
                                                <option value="">Seleccione</option>
                                                <option value="debito" {{($sale->type_of_card_2 == 'debito')?'selected':''}}>Debito Maestro</option>
                                                <option value="mastercard" {{($sale->type_of_card_2 == 'mastercard')?'selected':''}}>Mastercard</option>
                                                <option value="visa" {{($sale->type_of_card_2 == '')?'visa':''}}>Visa</option>
                                                <option value="american express" {{($sale->type_of_card_2 == 'american express')?'selected':''}}>American Express</option>
                                                <option value="dinners club" {{($sale->type_of_card_2 == 'dinners club')?'selected':''}}>Dinners Club</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Aprobación de Tarjeta</strong>
                                            <input type="text" class="form-control" name="approved_of_card_2" value="{{$sale->approved_of_card_2}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Entidad de Tarjeta</strong>
                                            <input type="text" class="form-control" name="card_entity_2" value="{{$sale->card_entity_2}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 online2">
                            <div class="form-group" style="line-height: 24px;margin-bottom: 0px">
                                <div class="row" style="margin-bottom: 0px;margin-top: 0px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Referencia Epayco</label>
                                            <input type="text" class="form-control" name="ref_epayco_2" value="{{$sale->ref_epayco_2}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="c-primary font-weight-bold">Numero de aprobacion</label>
                                            <input type="text" class="form-control" name="approved_epayco_2" value="{{$sale->approved_epayco_2}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 consignacion2">
                            <div class="form-group" style="line-height: 24px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Numero de cuenta</strong>
                                            <input type="text" class="form-control" name="number_account_2" value="{{$sale->number_account_2}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Código de aprobación</strong>
                                            <input type="text" class="form-control" name="approval_number_2" value="{{$sale->approval_number_2}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="results"></div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="col-md-12">
                    <label class="c-primary fw5">Comentarios</label>
                    <div class="form-group">
                        <textarea name="comments" rows="4" class="form-control" readonly>{{$sale->comments}}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <div class="modal fade" id="ModalExport" tabindex="-1" role="dialog" aria-labelledby="exampleModalExportTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalReceiptTitle">Anular venta</h5>
                    <input type="hidden" id="destination">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAnulateSale">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="observacionModal" id="observacionModal" cols="30" rows="10" placeholder="Observacion" required class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="anulateVentaGo" data-id="{{ $sale->id }}">Anular</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <style>
        .search-table-input{
            display: none;
        }
    </style>
    <script>
        setTimeout(function(){
            changeShowVenta($("select[name=method_payment_show_venta]").val());
            var valor_2 = $('input[name=method_payment_2]').val();
            changeShowVenta2(valor_2);
        },100);
        $("select[name=method_payment_show_venta]").change( function (even) {
            changeShowVenta($(this).val());
        });
        function changeShowVenta(value){
            if (value == "tarjeta") {
                $(".tarjeta").show();
                $(".account").show();
                $(".consignacion").hide();
                $(".online").hide();
            } else if (value == "consignacion") {
                $(".tarjeta").hide();
                $(".account").show();
                $(".consignacion").show();
                $(".online").hide();
                $(".credito").hide();
            } else if (value == "online") {
                $(".tarjeta").hide();
                $(".account").hide();
                $(".consignacion").hide();
                $(".online").show();
            } else if (value == "credito") {
                $(".tarjeta").hide();
                $(".account").hide();
                $(".consignacion").hide();
                $(".credito").show();
            } else if (value == "transferencia") {
                $(".tarjeta").hide();
                $(".account").show();
                $(".consignacion").show();
                $(".online").hide();
                $(".credito").hide();
            } else {
                $(".tarjeta").hide();
                $(".account").hide();
                $(".consignacion").hide();
                $(".online").hide();
                $(".credito").hide();
            }
            $("select[name=method_payment_show_venta]").css('display','none');
        }

        function changeShowVenta2(value){
            if (value != "") {
                $('.priceTwo').show();
                $('.priceOne').show();
            }
            if (value == "tarjeta") {
                $(".tarjeta2").show();
                $(".account2").show();
                $(".consignacion2").hide();
                $(".online2").hide();
            } else if (value == "consignacion") {
                $(".tarjeta2").hide();
                $(".account2").show();
                $(".consignacion2").show();
                $(".online2").hide();
                $(".credito2").hide();
            } else if (value == "online") {
                $(".tarjeta2").hide();
                $(".account2").hide();
                $(".consignacion2").hide();
                $(".online2").show();
            } else if (value == "credito") {
                $(".tarjeta2").hide();
                $(".account2").hide();
                $(".consignacion2").hide();
                $(".credito2").show();
            } else if (value == "transferencia") {
                $(".tarjeta2").hide();
                $(".account2").show();
                $(".consignacion2").show();
                $(".online2").hide();
                $(".credito2").hide();
            } else {
                $(".tarjeta2").hide();
                $(".account2").hide();
                $(".consignacion2").hide();
                $(".online2").hide();
                $(".credito2").hide();
            }
        }

        $("#anulateVenta").click(function (e) {
            var id = $(this).attr('data-id');
            swal({
                title: "¿Seguro desea anular esta venta?",
                text: "Después de hacerlo no podrá realizar ninguna acción.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "¡Si, así lo deseo!",
                closeOnConfirm: false,
                content: "input",
            },
            function(isConfirm){
                if (isConfirm) {
                    swal.close();
                    $('#ModalExport').modal('show');
                    //location.href = "/sales/anulate/"+id
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#anulateVentaGo").click(function (e) {
            if($('#observacionModal').val() == ''){
                swal({
                    title: "¡Opppssss!",
                    text: "Debe digitar una observación.",
                    type: "warning",
                    closeOnConfirm: false
                });
                return false;
            }
            var id = $(this).attr('data-id');
            $.ajax({
                async:true,
                type: 'POST',
                url: '/sales/anulate',
                dataType: 'json',
                data: {
                    id:id,
                    value:$('#observacionModal').val(),
                },
                statusCode: {
                    201: function(data) {
                        swal({
                                title: "¡Anulado!",
                                text: "La anulación de la venta se ha realizado con éxito.",
                                type: "success",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload()
                                }
                            });
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });
    </script>
@endsection
