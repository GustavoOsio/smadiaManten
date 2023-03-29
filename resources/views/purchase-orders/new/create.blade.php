@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Orden de Compra</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            <div class="button-new" style="width: 25%">
                <select name="provider_id_selected" id="provider_id_selected" class="form-control">
                    <option value="">Buscar precios por este provedor</option>
                    @foreach($providers as $p)
                        <option value="{{ $p->id }}" {{$provider_id == $p->id?'selected':''}}>{{ $p->company }}</option>
                    @endforeach
                </select>
            </div>
            <div class="button-new">
                <input value="{{$date}}" id="date_filter" type="text" class="form-control datetimepicker" placeholder="Fecha orden de pedido">
            </div>
            <div class="button-new">
                <a class="btn btn-primary aplicateDate" style="color: #ffffff">Aplicar fecha</a>
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
        @php
            $count_totaly = 0;
        @endphp
        @foreach($orderP as $key => $p)
            @if($p->totaly > 0)
                @php
                    $count_totaly++
                @endphp
            @endif
        @endforeach
        <input type="hidden" id="count" value="{{ ($count_totaly > 0) ? $count_totaly : 0 }}">
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
                        @foreach($orderP as $key => $p)
                            @if($p->totaly > 0)
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
                                        <input type="text" name="qty[]" maxlength="4" id="qty-{{ $c }}" value="{{ number_format($p->totaly, 0) }}" data-id="{{ $c }}" class="form-control" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, 'qty')" required>
                                    </div>
                                </td>
                                <td width="250">
                                    <div class="input-group">
                                        <input type="text" name="unity[]" id="unity-{{ $c }}" value="{{ $p->product->unit->name }}" class="form-control" readonly>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        @php
                                            if($provider_id == 0){
                                                $cost = 0;
                                            }else{
                                                $providerHistorial = \App\Models\ProviderHistorial::where('provider_id',$provider_id)
                                                    ->where('product_id',$p->product->id)
                                                    ->get();
                                                    if(count($providerHistorial)>0){
                                                        $cost = $providerHistorial[0]->cost;
                                                    }else{
                                                        $cost = 0;
                                                    }
                                            }
                                        @endphp
                                        <input type="text" name="price[]" id="price-{{ $c }}" value="{{ number_format($cost, 0, ',', '.') }}" data-id="{{ $c }}" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, 'price')" class="form-control" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="tax[]" id="tax-{{ $c }}" value="{{ number_format($p->tax, 0) }}" data-id="{{ $c }}" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, 'tax')" class="form-control">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="total[]" id="total-{{ $c }}" class="form-control" value="{{ number_format($cost * $p->totaly, 0, ',', '.') }}" readonly>
                                    </div>
                                </td>
                                @php
                                    $amount = $amount + ($cost * $p->qty);
                                @endphp
                                <td>
                                    @can('create', \App\Models\PersonalInventory::class)
                                        <a class="openHistorialOrder" id="{{$p->product->id}}" data-toggle="tooltip" data-placement="top" title="Enviar a inventario personal">
                                            <span class="icon-eye"></span>
                                        </a>
                                    @endif
                                    <a data-toggle="tooltip" data-placement="top" title="Eliminar">
                                        <span class="icon-close closeRow" onclick="closeRow({{ $c }})"></span>
                                    </a>
                                </td>
                            </tr>
                            @endif
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
                            @if (\Illuminate\Support\Facades\Auth::id() === $s->id)
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
                            <option value="{{ $p->id }}" {{$provider_id == $p->id?'selected':''}}>{{ $p->company }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <label class="c-primary fw5">Factura N°</label>
                <div class="form-group">
                    <input type="text" name="bill" class="form-control" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="" class="c-primary font-weight-bold">Centro de compra</label>
                <div class="form-group">
                    <select name="center_cost_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($centers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
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
                                <input type="text" class="form-control" name="delivery" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Bodega</strong>
                                <select name="cellar_id" class="form-control" required>
                                    <option value="" disabled>Seleccione</option>
                                    @foreach($cellars as $c)
                                        @if($c->id == 8)
                                            <option selected value="{{ $c->id }}">{{ $c->name }}</option>
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
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="pago online">Pago Online</option>
                                    <option value="consignacion">Consignación</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Forma de pago</strong>
                                <select name="way_of_pay" id="way_of_pay" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <option value="contado">Contado</option>
                                    <option value="credito">Credito</option>
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
                                    <input value="{{number_format($amount,0,',','.')}}" type="text" name="amount" readonly onkeypress="return soloNumeros(event);" class="form-control" placeholder="0" id="validationTooltip" required>
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
                                <input type="number" class="form-control" name="days" id="days" onkeypress="return soloNumeros(event);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Vencimiento</strong>
                                <input type="text" readonly class="form-control" name="expiration" id="expiration">
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
                                        <option value="{{ $a->id }}">{{ $a->account }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Banco destino</strong>
                                <input type="text" class="form-control" name="bank">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong class="c-primary font-weight-bold">Cuenta destino</strong>
                                <input type="text" class="form-control" name="account">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5">
                <label class="c-primary font-weight-bold">Observaciones</label>
                <div class="form-group">
                    <textarea name="comment" rows="4" class="form-control" required></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-8 margin-tb">
                        <div class="button-new">
                            <button id="disable_button" type="submit" class="btn btn-primary">Guardar orden de compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

    <div class="modal fade" id="modal_historial_order_purchase" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:inherit !important;justify-content: center;width: 90% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Orden de Pedidos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row div">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregar Inventario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddInventory">
                        <div class="form-group">
                            <h6>
                                Producto:
                            </h6>
                            <input type="hidden" name="id_order_product" class="form-control" required/>
                            <input type="hidden" name="product_id" class="form-control" required/>
                            <input type="text" name="product_name" class="form-control" required readonly/>
                        </div>
                        <div class="form-group">
                            <h6>Personal</h6>
                            <select name="user_id" class="form-control" required>
                                @foreach($sellers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <h6>Lote</h6>
                            <select style="width: 100%" name="lote_id" id="lote_id" class="form-control filter-schedule" required>
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad: Solicitada( <span class="product_qty">0</span> )
                            </h6>
                            <input name="product_qty" id="product_qty" min="1" type="number" class="form-control" onkeypress="return soloNumeros(this)"/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Observacion:
                            </h6>
                            <textarea class="form-control" name="observations" id="observations_edit_inventory" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submitModalAdd">Guardar</button>
                </div>
            </div>
        </div>
    </div>

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
        .credito_purchase{
            display: none;
        }
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
        @foreach($orderP as $p)
            @if($p->totaly > 0)
                posCant++;
                total[posCant] = parseInt({{0 * $p->qty}});
            @endif
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
            $('.ui-tooltip').hide();
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

            $("#tax-" + pos).val(formatNumber(tax[pos]));
            $("#price-" + pos).val(formatNumber(price[pos]));
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
                data:{
                    id:id,
                    provider_id:parseInt({{$provider_id}})
                },
                success:function(datos){
                    console.log(datos);
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
            //alert(total.length);
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
                url:'/purchase-orders',
                dataType: 'json',
                data: dataForm,
                statusCode: {
                    200: function(data) {
                        //console.log(data);
                        swal({
                                title: "Bien hecho",
                                text: "La orden de compra ha sido creada con éxito",
                                type: "success",
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    location.href="/purchase-orders"
                                }
                            });
                    },
                    500: function (data) {
                        console.log(data);
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });

        $('.openHistorialOrder').click(function () {
            $.ajax({
                url: "/purchase-orders/searchHistorialOrder",
                method: "POST",
                data: {
                    id:$(this).attr('id')
                },
                success: function (data) {
                    $('#modal_historial_order_purchase .div').html();
                    $('#modal_historial_order_purchase .div').html(data);
                    $('#modal_historial_order_purchase').modal('show');
                }
            });
        });

        $('.submitModalAdd').click(function () {
            if($('#modalAdd #product_qty').val() < 1 || $('#modalAdd #product_qty').val() == ''){
                swal({
                    title: "Debe digitar una cantidad a agregar mayor a 0",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            if($('#modalAdd #observations_edit_inventory').val() == ''){
                swal({
                    title: "Debe agregar una observacion",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            if($('#modalAdd #lote_id').val() == ''){
                swal({
                    title: "Debe seleccionar un lote",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            swal({
                    title: "¿Está seguro que desea actualizar esto?",
                    //text: "¡No podrás recuperar esta información al hacerlo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $('#formAddInventory').submit();
                    }
                });
        });

        $('#formAddInventory').on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{url('/purchase-orders/inventory')}}",
                method: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    if(data == '1'){
                        location.reload();
                    }else{
                        swal({
                            title: "Opppss!!!",
                            text: "" + data,
                            type: "warning",
                            closeOnConfirm: false
                        });
                    }
                }
            });
        });

        $('#provider_id_selected').change(function () {
            location.href = '{{url('purchase-orders/create')}}/'+$('#provider_id_selected').val()+'/'+$('#date_filter').val();
        });

        $('.aplicateDate').click(function () {
            var provider_id = 0;
            if($('#provider_id_selected').val() == ''){
                provider_id = 0;
            }else{
                provider_id = $('#provider_id_selected').val();
            }
            location.href = '{{url('purchase-orders/create')}}/'+provider_id+'/'+$('#date_filter').val();
        });
    </script>
@endsection
