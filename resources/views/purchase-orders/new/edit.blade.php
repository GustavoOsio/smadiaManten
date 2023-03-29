@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Orden de Compra OC-{{$orderForm->id}}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form id="formOrderForm" method="POST">
        @csrf
        <input type="hidden" id="count" value="{{ (count($orderForm->products) > 0) ? count($orderForm->products) : 0 }}">
        <input type="hidden" name="id_order_form" value="{{ $orderForm->id }}">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table">
                    <thead>
                    <th class="fl-ignore">Producto</th>
                    <th class="fl-ignore">Presentación</th>
                    <th class="fl-ignore">Cant</th>
                    <th class="fl-ignore">Unidad de medida</th>
                    <th class="fl-ignore">Valor</th>
                    <th class="fl-ignore">Iva</th>
                    <th class="fl-ignore">Total</th>
                    <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                    @php
                        $amount = 0;
                        $c = 0;
                    @endphp
                    @foreach($orderForm->products as $key => $p)
                        @php $c++; @endphp
                        <tr id="rowToClone-{{ $c }}">
                            <td width="180">
                                <select name="products[]" id="product-{{ $c }}" class="form-control" data-id="{{ $c }}" required onchange="searchProduct(this.value, {{ $c }})">
                                    @foreach($products as $product)
                                        @if ($p->product->id === $product->id)
                                            <option selected value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td width="250">
                                <div class="input-group">
                                    <input type="text" name="presentation[]" id="presentation-{{ $c }}" value="{{ $p->product->presentation->name }}" class="form-control" readonly>
                                </div>
                            </td>
                            <td width="85">
                                <div class="input-group">
                                    <input type="text" name="qty[]" maxlength="4" id="qty-{{ $c }}" value="{{ number_format($p->qty, 0) }}" data-id="{{ $c }}" class="form-control" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, 'qty')" required>
                                </div>
                            </td>
                            <td width="250">
                                <div class="input-group">
                                    <input type="text" name="unity[]" id="unity-{{ $c }}" value="{{ $p->product->unit->name }}" class="form-control" readonly>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="price[]" id="price-{{ $c }}" value="{{ number_format($p->price, 0, ',', '.') }}" data-id="{{ $c }}" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, 'price')" class="form-control" required>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="tax[]" id="tax-{{ $c }}" value="{{ number_format($p->tax, 0,',','.') }}" data-id="{{ $c }}" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, 'tax')" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="total[]" id="total-{{ $c }}" class="form-control" value="{{ number_format(($p->price+$p->tax) * $p->qty, 0, ',', '.') }}" readonly>
                                </div>
                            </td>
                            @php
                                $amount = $amount + ($p->price * $p->qty);
                            @endphp
                            <td><span class="icon-close closeRow" onclick="closeRow({{ $c }})"></span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-8 margin-tb">
                        <div class="title-crud" id="cloneRowPurchase">
                            <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar producto</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="validationTooltip" class="c-primary font-weight-bold">Quien recibe</label>
                <div class="form-group">
                    <select name="receive_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($sellers as $s)
                            @if ($orderForm->user_id === $s->id)
                                <option selected value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                            @else
                                <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="validationTooltip" class="c-primary font-weight-bold">Proveedor</label>
                <div class="form-group">
                    <select name="provider_id" id="provider_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($providers as $p)
                            <option value="{{ $p->id }}" {{$orderForm->provider_id == $p->id?'selected':''}}>{{ $p->company }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <label class="c-primary fw5">Factura N°</label>
                <div class="form-group">
                    <input type="text" name="bill" class="form-control" required value="{{$orderForm->bill}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="" class="c-primary font-weight-bold">Centro de compra</label>
                <div class="form-group">
                    <select name="center_cost_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($centers as $c)
                            <option value="{{ $c->id }}" {{$orderForm->center_cost_id == $c->id?'selected':''}}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group" style="line-height: 24px">
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Lugar de entrega</strong>
                                <input type="text" class="form-control" name="delivery" required value="{{$orderForm->delivery}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Bodega</strong>
                                <select name="cellar_id" class="form-control" required>
                                    <option value="" disabled>Seleccione</option>
                                    @foreach($cellars as $c)
                                        @if($c->id == 8)
                                            <option {{$c->id==$orderForm->celler_id?'selected':''}} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Medio de pago</strong>
                                <select name="method_of_pay" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="efectivo" {{$orderForm->payment_method == 'efectivo'?'selected':''}}>Efectivo</option>
                                    <option value="tarjeta" {{$orderForm->payment_method == 'tarjeta'?'selected':''}}>Tarjeta</option>
                                    <option value="transferencia" {{$orderForm->payment_method == 'transferencia'?'selected':''}}>Transferencia</option>
                                    <option value="cheque" {{$orderForm->payment_method == 'cheque'?'selected':''}}>Cheque</option>
                                    <option value="pago online" {{$orderForm->payment_method == 'pago online'?'selected':''}}>Pago Online</option>
                                    <option value="consignacion" {{$orderForm->payment_method == 'consignacion'?'selected':''}}>Consignación</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Forma de pago</strong>
                                <select name="way_of_pay" id="way_of_pay" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="contado" {{$orderForm->way_of_pay == 'contado'?'selected':''}}>Contado</option>
                                    <option value="credito" {{$orderForm->way_of_pay == 'credito'?'selected':''}}>Credito</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Total compra</strong>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input value="{{number_format($orderForm->total,0,',','.')}}" type="text" name="amount" readonly onkeypress="return soloNumeros(event);" class="form-control" placeholder="0" id="validationTooltip" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 credito_purchase">
                <div class="form-group" style="line-height: 24px">
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Días</strong>
                                <input value="{{$orderForm->days}}" type="number" class="form-control" name="days" id="days" onkeypress="return soloNumeros(event);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Vencimiento</strong>
                                <input value="{{$orderForm->expiration}}" type="text" readonly class="form-control" name="expiration" id="expiration">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 consignacion">
                <div class="form-group" style="line-height: 24px">
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Cuenta origen</strong>
                                <select name="account_id" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach($accounts as $a)
                                        <option value="{{ $a->id }}" {{$orderForm->account_id == $a->id?'selected':''}}>{{ $a->account }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Banco destino</strong>
                                <input type="text" class="form-control" name="bank" value="{{$orderForm->bank}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Cuenta destino</strong>
                                <input type="text" class="form-control" name="account" value="{{$orderForm->account}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5">
                <label class="c-primary font-weight-bold">Observaciones</label>
                <div class="form-group">
                    <textarea name="comment" rows="4" class="form-control" required>{{$orderForm->comment}}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-8 margin-tb">
                        <div class="button-new">
                            <button id="disable_button" type="submit" class="btn btn-primary">Actualizar orden de compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection
@section('script')
    <script>
        $('#days').keypress(function () {
            setTimeout(function () {
                var dias = 0;
                if($('#days').val() == ''){
                    dias = 0
                }else{
                    dias = parseInt($('#days').val())
                }
                var d = new Date();
                d = sumarDias(d,dias);
                d = d.getFullYear()+'-'+(d.getMonth() + 1)+'-'+d.getDate();
                $('#expiration').val(d);
            },200);
        });
        $('#days').keydown(function () {
            setTimeout(function () {
                var dias = 0;
                if($('#days').val() == ''){
                    dias = 0
                }else{
                    dias = parseInt($('#days').val())
                }
                var d = new Date();
                d = sumarDias(d,dias);
                d = d.getFullYear()+'-'+(d.getMonth() + 1)+'-'+d.getDate();
                $('#expiration').val(d);
            },200);
        });
        function sumarDias(fecha, dias){
            fecha.setDate(fecha.getDate() + dias);
            return fecha;
        }
    </script>
    <style>
        @if($orderForm->payment_method == 'consignacion' || $orderForm->payment_method == 'transferencia' || $orderForm->payment_method == 'efectivo')
            .consignacion{
                display: none;
            }
        @endif
        @if($orderForm->way_of_pay != 'credito')
            .credito_purchase{
                display: none;
            }
        @endif
    </style>
    <script>
        var optionProductPurchaseOrder = '';
        @foreach($products as $key => $pro)
            optionProductPurchaseOrder = optionProductPurchaseOrder + '<option value="{{$pro->id}}">{{$pro->name}}</option>'
        @endforeach
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        var price = [];
        var total = [];
        var qty = [];
        var tax = [];
        var amount = 0;
    </script>
    <script>
        posCant = 0;
        @foreach($orderForm->products as $p)
            posCant++;
            total[posCant] = parseInt({{($p->price+$p->tax) * $p->qty}});
        @endforeach
    </script>
    <script>
        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
            price[pos] = 0;
            qty[pos] = 0;
            tax[pos] = 0;
            total[pos] = 0;
            contenedor.removeChild(eliminar);
            amountT();
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
        function calcule(obj, key) {
            formatNumberWrite(obj);
            var pos = $(obj).attr('data-id');
            var valor = $(obj).val().replace(".", "");
            valor = valor.replace(".", "");
            valor = valor.replace(",", "");
            valor = valor.replace(",", "");

            if (key == 'qty') {
                qty[pos] = valor;
                price[pos] = $("#price-" + pos).val().replace(".", "");
                price[pos] = price[pos].replace(".", "");
                price[pos] = price[pos].replace(",", "");
                price[pos] = price[pos].replace(",", "");
                tax[pos] = $("#tax-" + pos).val().replace(".", "");
                tax[pos] = tax[pos].replace(".", "");
                tax[pos] = tax[pos].replace(",", "");
                tax[pos] = tax[pos].replace(",", "");
                total[pos] = (parseInt(price[pos]) + parseInt(tax[pos])) * qty[pos];
            }
            if (key == 'price') {
                price[pos] = valor;
                qty[pos] = $("#qty-" + pos).val().replace(".", "");
                qty[pos] = qty[pos].replace(".", "");
                qty[pos] = qty[pos].replace(",", "");
                qty[pos] = qty[pos].replace(",", "");
                tax[pos] = $("#tax-" + pos).val().replace(".", "");
                tax[pos] = tax[pos].replace(".", "");
                tax[pos] = tax[pos].replace(",", "");
                tax[pos] = tax[pos].replace(",", "");
                total[pos] = (parseInt(valor) + parseInt(tax[pos])) * qty[pos];
            }
            if (key == 'tax') {
                tax[pos] = valor;
                qty[pos] = $("#qty-" + pos).val().replace(".", "");
                qty[pos] = qty[pos].replace(".", "");
                qty[pos] = qty[pos].replace(",", "");
                qty[pos] = qty[pos].replace(",", "");
                price[pos] = $("#price-" + pos).val().replace(".", "");
                price[pos] = price[pos].replace(".", "");
                price[pos] = price[pos].replace(",", "");
                price[pos] = price[pos].replace(",", "");
                total[pos] = (parseInt(valor) + parseInt(price[pos])) * qty[pos];
            }

            amountT();

            $("#price-" + pos).val(formatNumber(price[pos]));
            $("#tax-" + pos).val(formatNumber(tax[pos]));
            $("#total-" + pos).val(formatNumber(total[pos]));


        }
        function expirationP(obj) {
            $(obj).datetimepicker({
                locale: 'es',
                defaultDate: false,
                format: 'YYYY-MM-DD',
            }).focus();
        }
        function searchProduct(id, pos) {
            $.ajax({
                async:true,
                type: "POST",
                dataType: "json",
                url:"/product",
                data:{id:id,validate:parseInt('{{$orderForm->id}}') },
                success:function(datos){
                    $("#presentation-" + pos).val(datos.first.presentation.name);
                    $("#unity-" + pos).val(datos.first.unit.name);
                    $("#qty-" + pos).val(datos.second);
                    $("#price-" + pos).val(datos.third.replace(".00", "").replace(",00", ""));
                    $("#total-" + pos).val(datos.second * datos.third.replace(".00", "").replace(",00", ""));
                    price[pos] = datos.third.replace(".00", "").replace(",00", "");
                    qty[pos] = datos.second;
                    tax[pos] = 0;
                    total[pos] = datos.second * datos.third.replace(".00", "").replace(",00", "");
                    //amountT();
                }
            });
        }

        function amountT() {
            amount = 0;
            for (var i = 1; i < total.length; i++) {
                amount += parseInt(total[i]);
            }
            $("[name=amount]").removeAttr('readonly');
            $("[name=amount]").val(formatNumber(amount));
            $("[name=amount]").attr('readonly',true);
        }

        $('#way_of_pay').change(function () {
            if($('#way_of_pay').val()=='credito'){
                $('.credito_purchase').css('display','block');
            }else{
                $('.credito_purchase').css('display','none');
            }
        });
    </script>
    <script>
        $('#formOrderForm').on('submit', function(e){
            e.preventDefault();
            const dataForm=$(this).serialize();
            $('#disable_button').attr('disabled',true);
            swal({
                title: 'AVISO',
                text: 'Espere un momento',
                showCancelButton: false,
                showConfirmButton: false,
            });
            $.ajax({
                async:true,
                type: 'POST',
                url:'/purchase-orders/update',
                dataType: 'json',
                data: dataForm,
                statusCode: {
                    200: function(data) {
                        swal({
                                title: "Bien hecho",
                                text: "La orden de compra ha sido actualizada con éxito",
                                type: "success",
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    location.href="/purchase-orders"
                                }
                            });
                    },
                    400: function (data) {
                        swal('¡Ups!', data, 'error')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });
    </script>
@endsection
