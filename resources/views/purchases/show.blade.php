@extends('layouts.app')

@section('content')
    <div class="modal fade" id="ModalReceipt" tabindex="-1" role="dialog" aria-labelledby="exampleModalReceiptTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalReceiptTitle">Pagar / Abonar cuenta</h5>
                    <input type="hidden" id="destination">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmPaymentPurchase">
                    <div class="modal-body">
                            @csrf
                            <input type="hidden" name="purchase_id" value="{{ $purchase->id }}" required>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Saldo (actual)</strong>
                                        <input type="text" class="form-control" id="balance-current" readonly value="$ {{ number_format($purchase->balance, 0, ',', '.') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Valor a pagar</strong>
                                        <input type="text" class="form-control" name="amount" id="amount" onkeypress="return soloNumeros(event);" onkeyup="calcule(this)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Resta por pagar</strong>
                                        <input type="text" class="form-control" id="balance" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Comentarios</strong>
                                        <textarea name="comment" class="form-control" rows="3" required minlength="3"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form id="">
        @csrf
        <input type="hidden" name="id" value="{{ $purchase->id }}">
        <div class="row mb-4">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud">
                    <h2>Compra CP-{{ $purchase->id }} | {{ ucwords($purchase->status) }} | Orden de compra OC-{{$purchase->order_form_id}}</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
                </div>
                <div class="float-right">
                    <!--
                    @if ($purchase->status=="incompleta")
                        <a target="_blank" href="{{ url("/purchase/pdf-inComplet/" . $purchase->id) }}">
                            <div class="btn btn-primary" style="background: #FB8E8E;">
                                <span class="icon-print-02"></span> Imprimir incompletos
                            </div>
                        </a>
                    @endif
                    -->
                    <!--
                    <a target="_blank" href="{{ url("/purchase/pdf-in/" . $purchase->id) }}">
                        <div class="btn btn-primary" style="background: #FB8E8E;">
                            <span class="icon-print-02"></span> Imprimir
                        </div>
                    </a>
                    -->
                    @if($purchase->balance > 0 and $purchase->payment_method == "credito")
                        <a href="#" data-toggle="modal" data-target="#ModalReceipt">
                            <div class="btn btn-primary btn-payment"
                                 style="background: #00E28A">
                                <span class="icon-icon-06"></span> Pagar/Abonar
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <p class="title-form">Proveedor</p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">NIT</th>
                <th class="fl-ignore">Razón social</th>
                <th class="fl-ignore">Dirección</th>
                <th class="fl-ignore">Ciudad</th>
                <th class="fl-ignore">Teléfono</th>
                <th class="fl-ignore">Celular</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $purchase->provider->nit }}</td>
                <td>{{ $purchase->provider->company }}</td>
                <td>{{ $purchase->provider->address }}</td>
                <td>{{ $purchase->provider->city->name }}</td>
                <td>{{ $purchase->provider->phone }}</td>
                <td>{{ $purchase->provider->cellphone }}</td>
            </tr>
            </tbody>
        </table>
        <div class="line-form"></div>
        <p class="title-form">Productos</p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="fl-ignore">Código</th>
                    <th class="fl-ignore">Producto</th>
                    <th class="fl-ignore">Presentación</th>
                    <th class="fl-ignore">Cantidad</th>
                    <th class="fl-ignore">Inve.</th>
                    <!--
                    <th class="fl-ignore">Cant. Solicitada</th>
                    <th class="fl-ignore">Cant. Faltante</th>
                    -->
                    <th class="fl-ignore">Unidad</th>
                    <th class="fl-ignore">Lote</th>
                    <th class="fl-ignore">Vence</th>
                    <th class="fl-ignore">Valor</th>
                    <th class="fl-ignore">Iva</th>
                    <th class="fl-ignore">Total</th>
                    <th class="fl-ignore">Inventariado</th>
                    <!--
                    <th class="fl-ignore">Bodega</th>
                    -->
                </tr>
            </thead>
            <tbody>
                @php
                    $countIn = 0;
                @endphp
                @foreach($purchase->products as $key => $p)
                    @php
                        if($p->inventory == 'no'){
                            $countIn = $countIn+1;
                        }
                        $product = \App\Models\Product::find($p->product_id);
                    @endphp
                    @if($p->product_id != 103)
                    <tr class="{{$p->missing==0?"":"purchase_missing"}}">
                        <td>{{ $product->reference }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->presentation->name }}</td>
                        <td>{{ number_format($p->qty,'.00') }}</td>
                        <td>{{ number_format($p->qty_inventory,'.00') }}</td>
                        <!--
                        <td>{{ number_format($p->full_amount=='0'||$p->full_amount==''?$p->qty:$p->full_amount,'.00') }}</td>
                        <td>
                            {{$p->missing}}
                            @if ($purchase->status!="inventariada")
                            <a class="edit-purchase-products js-update-p-p"
                               data-action="quanty" data-val="{{$p->missing}}" data-id="{{$p->id}}">
                                <span class="icon-icon-11"></span>
                            </a>
                            @endif
                        </td>
                        -->
                        <td>{{ $product->unit->name }}</td>
                        <td>
                            {{$p->lote}}
                            <a  class="edit-purchase-products js-update-p-p"
                                data-action="lote"
                                data-val="{{$p->lote}}"
                                data-id="{{$p->id}}">
                                <span class="icon-icon-11"></span>
                            </a>
                        </td>
                        <td>
                            @php
                                    $expiration = '';
                                    if($p->expiration != '0000-00-00'){
                                        $expiration = date("Y-m-d", strtotime($p->expiration));
                                    }
                            @endphp
                            {{$expiration}}
                            <a class="edit-purchase-products js-update-p-p"
                               data-action="date"
                               data-val="{{$expiration}}"
                               data-id="{{$p->id}}">
                                <span class="icon-icon-11"></span>
                            </a>
                        </td>
                        <td>
                            ${{ number_format($p->price, 0, ',', '.') }}
                            <a class="edit-purchase-products js-update-p-p"
                               data-action="price"
                               data-val="{{$p->price}}"
                               data-id="{{$p->id}}">
                                <span class="icon-icon-11"></span>
                            </a>
                        </td>
                        <td>
                            {{ number_format($p->tax,0,',','.') }}
                            <a class="edit-purchase-products js-update-p-p"
                               data-action="tax"
                               data-val="{{$p->tax}}"
                               data-id="{{$p->id}}">
                                <span class="icon-icon-11"></span>
                            </a>
                        </td>
                        <td>${{ number_format(($p->price+$p->tax) * $p->qty, 0, ',', '.') }}</td>
                        <td>{{$p->inventory}}</td>
                        <!--
                        <td>
                            {{$p->cellar->name}}
                            <a class="edit-purchase-products js-update-p-p"
                               data-action="cellar"
                               data-val="{{$p->cellar_id}}"
                               data-id="{{$p->id}}">
                                <span class="icon-icon-11"></span>
                            </a>
                        </td>
                        -->
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @if ($countIn > 0)
            <div class="btn btn-primary"
                 id="inventoryPurchase"
                 data-id="{{ $purchase->id }}">
                SUBIR AL INVENTARIO
            </div>
        @endif
        <div class="line-form"></div>
        <p class="title-form">Datos</p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="fl-ignore">ID</th>
                    <th class="fl-ignore">Bodega</th>
                    <th class="fl-ignore">Fecha</th>
                    <th class="fl-ignore">Elaborado por</th>
                    <th class="fl-ignore">Medio de pago</th>
                    <th class="fl-ignore">Forma de pago</th>
                    <th class="fl-ignore">Centro de compra</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>CP-{{ $purchase->id }}</td>
                    <td>{{ $purchase->cellar->name }} </td>
                    <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
                    <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname, "UTF-8")) }}</td>
                    <td>{{ ucwords(mb_strtolower($purchase->payment_method)) }}</td>
                    <td>{{ ucwords(mb_strtolower($purchase->way_of_pay)) }}</td>
                    <td>{{ $purchase->center_cost->name }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Observaciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $purchase->comment }}</td>
            </tr>
            </tbody>
        </table>


    </form>


      <!-- Modal -->
      <div class="modal fade" id="modalPurchaseEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Editar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            </div>
              <select name="" id="" class="form-control" style="width: 60%;margin: 3% 0% 3% 5%">
                  @foreach($cellars as $c)
                      <option value="{{$c->id}}">{{$c->name}}</option>
                  @endforeach
              </select>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary js-btn">Guardar</button>
            </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        function calcule(obj) {
            formatNumberWrite(obj);
            $(obj).val("$ " + $(obj).val());
            var valor = $(obj).val().replace("$ ", "");
            valor = valor.replace(".", "");
            valor = valor.replace(".", "");
            valor = valor.replace(",", "");
            valor = valor.replace(",", "");

            var balance = $("#balance-current").val().replace("$ ", "");
            balance = balance.replace(".", "");
            balance = balance.replace(".", "");
            balance = balance.replace(",", "");
            balance = balance.replace(",", "");

            var total = parseInt(balance) - parseInt(valor);
            if (total < 0) {
                swal({
                        title: "",
                        text: "El valor a pagar no puede ser mayor al saldo actual",
                        type: "info"
                    });
                var back = $(obj).val().replace("$ ", "");
                back = back.replace(".", "");
                back = back.replace(".", "");
                back = back.replace(",", "");
                back = back.replace(",", "");
                $(obj).val("$ " + formatNumber(back.substring(0,back.length-1)));
            } else {
                $("#balance").val("$ " + formatNumber(total));
            }




        }
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
        function formatNumberWrite (obj) {
            var n = $(obj).val()
            n = String(n).replace(/\D/g, "");
            $(obj).val(n === '' ? n : Number(n).toLocaleString());
        }
        function soloNumeros(e)
        {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;
            return /\d/.test(String.fromCharCode(keynum));
        }
    </script>
@endsection
