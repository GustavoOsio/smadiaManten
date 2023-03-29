@extends('layouts.app')

@section('content')
    <div class="modal fade" id="ModalReceipt" tabindex="-1" role="dialog" aria-labelledby="exampleModalReceiptTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalReceiptTitle">Buscar producto</h5>
                    <input type="hidden" id="destination">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="frmSearchProduct">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           id="search" name="search" onkeyup="productSearch(this.value)"
                                           placeholder="Busca aquí el producto">
                                </div>
                            </div>
                            <table class="table table-hover" id="tableSearchProduct">
                                <thead>
                                <th class="fl-ignore">Codigo</th>
                                <th class="fl-ignore">Producto</th>
                                <th class="fl-ignore">Presentación</th>
                                <th class="fl-ignore">Stock</th>
                                <th class="fl-ignore">Lote</th>
                                <th class="fl-ignore">Vence</th>
                                <th class="fl-ignore">Valor</th>
                                <th class="fl-ignore">Bodega</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalPhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalPhotoTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalPhotoTitle">Tomar foto</h5>
                    <input type="hidden" id="destination">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="capture">
                        <div class="capture__frame">
                            <div id="camera"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="take_snapshot()">Capturar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Venta</h2>
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

    @if ($message = Session::get('error'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif


    <form id="formSale" method="POST" action="{{ route("sales.store") }}">
        @csrf
        {{--<div class="separator"></div>--}}
        {{--<p class="title-form">Rellenar</p>--}}
        {{--<div class="line-form"></div>--}}
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
                        <td style="position: relative;">
                            <input type="hidden" name="patient_id" id="patient_id" required value="{{$patient->id}}">
                            <input type="text" class="form-control" name="identy" id="patient_identy"
                                   onkeypress="return soloNumeros(event);"
                                   onkeyup="searchPatient(this.value)" required autocomplete="off" readonly value="{{$patient->identy}}">
                            <div id="resultPatients"></div>
                        </td>
                        <td style="position: relative">
                            <input value="{{$patient->name}} {{$patient->lastname}}" type="text" class="form-control" id="patient_name" onkeyup="searchPatientName(this.value)" autocomplete="off" readonly>
                            <div id="resultPatients_2"></div>
                        </td>
                        @if($patient->city_id != '')
                            <td><input type="text" class="form-control" readonly id="patient_city" value="{{$patient->city->name}}"></td>
                        @else
                            <td><input type="text" class="form-control" readonly id="patient_city" value=""></td>
                        @endif
                        <td><input type="text" class="form-control" readonly id="patient_address" value="{{$patient->address}}"></td>
                        <td><input type="text" class="form-control" readonly id="patient_cellphone" value="{{$patient->cellphone}}"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-6 margin-tb">
                        <div class="title-crud" data-toggle="modal" data-target="#ModalReceipt">
                            <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar producto</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-sale">
                    <thead>
                    <th class="fl-ignore">Código</th>
                    <th class="fl-ignore">Producto</th>
                    <th class="fl-ignore">Presentación</th>
                    <th class="fl-ignore">Cant.</th>
                    <th class="fl-ignore">Lote</th>
                    <th class="fl-ignore">Cant Disponible</th>
                    <th class="fl-ignore">Vence</th>
                    <th class="fl-ignore">Valor</th>
                    <th class="fl-ignore">IVA</th>
                    <th class="fl-ignore">Total</th>
                    <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Sub Total</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="sub_amount" readonly class="form-control" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Total IVA</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="tax" readonly class="form-control" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Cant. productos</label>
                            <div class="form-group">
                                <input type="text" name="qty_products" id="qty_products" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Total venta</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="amount" readonly class="form-control" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento</label>
                            <div class="form-group">
                                <select id="getDiscount" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Tipo Descuento</label>
                            <div class="form-group">
                                <select id="type_discount" name="type_discount" class="form-control" disabled>
                                    <option value="percent">%</option>
                                    <option value="price">$</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento valor</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="discount" id="discount"
                                       onkeypress="return soloNumeros(event);"
                                       onkeyup="calculeDiscount(this)" maxlength="2"
                                       class="form-control" placeholder="0" required disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="c-primary font-weight-bold">Descuento total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" id="discount_total" name="discount_total" readonly
                                       class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12">
                            <label class="c-primary fw5">Comentarios</label>
                            <div class="form-group">
                                <textarea name="comments" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row" style="margin-bottom: 0px">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-6">
                            <label for="" class="c-primary font-weight-bold">Vendedor</label>
                            <div class="form-group">
                                <select name="seller_id" class="form-control" required>
                                    <option value="" selected>Seleccione</option>
                                    @foreach($sellers as $s)
                                        @if (\Illuminate\Support\Facades\Auth::id() === $s->id)
                                            <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                                        @else
                                            <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row" style="margin-bottom: 0px">
                                <div class="col-md-6">
                                    <label for="" class="c-primary font-weight-bold">Forma de pago</label>
                                    <div class="form-group">
                                        <select name="method_payment" class="form-control">
                                            <option value="efectivo">Efectivo</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="consignacion">Consignación</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 priceOne">
                                    <div class="form-group">
                                        <label class="c-primary font-weight-bold">Valor</label>
                                        <input type="text" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)" name="amount_one">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12 tarjeta">
                            <div class="form-group" style="line-height: 24px">
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Tipo de tarjeta</strong>
                                            <select name="type_of_card" id="type_of_card" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="debito">Debito Maestro</option>
                                                <option value="mastercard">Mastercard</option>
                                                <option value="visa">Visa</option>
                                                <option value="american express">American Express</option>
                                                <option value="dinners club">Dinners Club</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Aprobación de Tarjeta</strong>
                                            <input type="text" class="form-control" name="approved_of_card">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Entidad de Tarjeta</strong>
                                            <input type="text" class="form-control" name="card_entity">
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <strong>Recibo</strong>
                                            <input type="hidden" name="receipt">
                                            <div class="form-group cam-soft" data-destination="receipt" data-toggle="modal" data-target="#ModalPhoto">
                                                <div>Agregar foto</div>
                                                <div><span class="icon-file-02"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 consignacion">
                            <div class="form-group" style="line-height: 24px">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Numero de cuenta</strong>
                                            <input type="text" class="form-control" name="number_account">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Código de aprobación</strong>
                                            <input type="text" class="form-control" name="approval_number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12">
                            <div class="row" style="margin-bottom: 0px">
                                <div class="col-md-6">
                                    <label for="" class="c-primary font-weight-bold">Forma de pago 2</label>
                                    <div class="form-group">
                                        <select name="method_payment_2" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="consignacion">Consignación</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 priceTwo">
                                    <div class="form-group">
                                        <label class="c-primary font-weight-bold">Valor</label>
                                        <input type="text" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)" name="amount_two">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-md-12 tarjeta2">
                            <div class="form-group" style="line-height: 24px">
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Tipo de tarjeta</strong>
                                            <select name="type_of_card_2" id="type_of_card_2" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="debito">Debito Maestro</option>
                                                <option value="mastercard">Mastercard</option>
                                                <option value="visa">Visa</option>
                                                <option value="american express">American Express</option>
                                                <option value="dinners club">Dinners Club</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Aprobación de Tarjeta</strong>
                                            <input type="text" class="form-control" name="approved_of_card_2">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <strong>Entidad de Tarjeta</strong>
                                            <input type="text" class="form-control" name="card_entity_2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 consignacion2">
                            <div class="form-group" style="line-height: 24px">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Numero de cuenta</strong>
                                            <input type="text" class="form-control" name="number_account_2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Código de aprobación</strong>
                                            <input type="text" class="form-control" name="approval_number_2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-6 margin-tb">
                        <div class="button-new">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="results"></div>
        </div>


    </form>

@endsection
@section('script')
    <style>
        #tableSearchProduct td:hover{
            cursor: pointer !important;
        }
        .class_expiration{
            background: red;
        }
        .class_expiration .icon-close:before{
            color: #ffffff;
        }
    </style>
    <script>
        var countS = 0;
        var price = [];
        var total = [];
        var qty = [];
        var tax = [];
        var amount = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                if ($("#destination").val() == "receipt") {
                    $("[name=receipt]").val(data_uri.replace(/^data\:image\/\w+\;base64\,/, ''));
                    document.getElementById('results').innerHTML =
                        '<img src="'+data_uri+'"/>';
                } else {
                    $("[name=receipt_2]").val(data_uri.replace(/^data\:image\/\w+\;base64\,/, ''));
                    document.getElementById('results').innerHTML =
                        '<img src="'+data_uri+'"/>';
                }

            } );
        }

        $("#getDiscount").change(function (e) {
            if ($(this).val() == 1) {
                $("#type_discount").removeAttr("disabled");
                $("#discount").removeAttr("disabled");
            } else {
                $("#type_discount").attr("disabled", true);
                $("#discount").attr("disabled", true);
            }
            amountT();
        });

        $("#type_discount").change(function (e) {
            if ($(this).val() == "price") {
                $("#discount").attr("maxlength", "19");
            } else {
                $("#discount").attr("maxlength", "2");
            }
            calculeDiscount($("#discount"));
        });


        function searchPatient(search) {
            if (search.length > 2) {
                $.ajax({
                    async:true,
                    type: 'POST',
                    url: '/patients/search',
                    dataType: 'json',
                    data: 'patient=' + search,
                    statusCode: {
                        200: function(data) {
                            $("#resultPatients").show();
                            $("#resultPatients > div").remove();
                            data.forEach(function (p) {
                                $("#resultPatients").append(
                                    "<div data-json='"+ JSON.stringify(p).toString() +"' onclick='selectPatient(this)'>" +
                                    p.identy + " - " + p.name + " " + p.lastname +
                                    "</div>"
                                );
                            });

                        },
                        500: function () {
                            swal('¡Ups!', 'Error interno del servidor', 'error')
                        }
                    }
                });
            }
        }

        function searchPatientName(search) {
            if (search.length > 2) {
                $.ajax({
                    async:true,
                    type: 'POST',
                    url: '/patients/search_2',
                    dataType: 'json',
                    data: 'patient=' + search,
                    statusCode: {
                        200: function(data) {
                            $("#resultPatients_2").show();
                            $("#resultPatients_2 > div").remove();
                            data.forEach(function (p) {
                                $("#resultPatients_2").append(
                                    "<div data-json='"+ JSON.stringify(p).toString() +"' onclick='selectPatient(this)'>" +
                                    p.identy + " - " + p.name + " " + p.lastname +
                                    "</div>"
                                );
                            });

                        },
                        500: function () {
                            swal('¡Ups!', 'Error interno del servidor', 'error')
                        }
                    }
                });
            }
        }

        function selectPatient(obj) {
            $("#resultPatients").hide();
            $("#resultPatients_2").hide();
            $("#resultPatients > div").remove();
            var row = JSON.parse($(obj).attr('data-json'));
            $("#patient_id").val(row.id);
            $("#patient_identy").val(row.identy);
            $("#patient_name").val(row.name + " " + row.lastname);
            $("#patient_city").val(row.city.name);
            $("#patient_address").val(row.address);
            $("#patient_cellphone").val(row.cellphone);
        }

        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
            price[pos] = 0;
            qty[pos] = 0;
            total[pos] = 0;
            //contenedor.removeChild(eliminar);
            $("#rowToClone-" + pos).remove();
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
        function calcule(pos) {
            var valor = $("#qty-" + pos).val().replace(".", "");
            valor = valor.replace(".", "");
            valor = valor.replace(",", "");
            valor = valor.replace(",", "");

            tax[pos] = $("#tax-" + pos).val();
            qty[pos] = valor;
            price[pos] = $("#price-" + pos).val().replace(".", "");
            price[pos] = price[pos].replace(".", "");
            price[pos] = price[pos].replace(",", "");
            price[pos] = price[pos].replace(",", "");
            total[pos] = price[pos] * qty[pos];

            amountT();

            $("#price-" + pos).val(formatNumber(price[pos]));
            $("#total-" + pos).val(formatNumber(total[pos]));

            qtyProudcts();

            calculeTax();


        }
        function calculeDiscount(obj) {
            amountOrder();
            if ($(obj).val() != "") {
                formatNumberWrite(obj);
                var str_discount = $(obj).val();
                var discount = $(obj).val().replace(".", "");
                discount = discount.replace(".", "");
                discount = discount.replace(",", "");
                discount = discount.replace(",", "");

                if ($("#type_discount").val() == "price") {
                    $("#discount_total").val(str_discount);
                    $("[name=amount]").val(formatNumber(parseFloat(amount) - parseFloat(discount)));
                } else if ($("#type_discount").val() == "percent") {
                    var total_discount = parseFloat(amount) * parseFloat(discount) / 100
                    $("#discount_total").val(formatNumber(total_discount));
                    $("[name=amount]").val(formatNumber(parseFloat(amount) - parseFloat(total_discount)));
                }
            } else {
                $("#discount_total").val(0);
            }

        }
        function productSearch(obj) {
            if (obj.length > 2) {
                $("#frmSearchProduct").submit();
            }
        }

        function qtyProudcts() {
            var qty_total = 0;
            qty.forEach(function (q) {
                qty_total += parseInt(q);
            });
            $("#qty_products").val(qty_total);
        }

        function calculeTax() {
            var tax_total = 0;
            var i = 1;
            tax.forEach(function (t) {
                if (t > 0)
                    tax_total += (parseInt(price[i]) * parseInt(qty[i])) * parseInt(t) / 100;
                i++;
            });
            $("[name=tax]").val(tax_total);
            $("[name=sub_amount]").val(formatNumber(amount - tax_total));
        }

        function amountT() {
            amount = 0;
            for (var i = 1; i < total.length; i++) {
                amount += parseInt(total[i]);
            }
            $("[name=sub_amount]").val(formatNumber(amount));
            $("[name=amount]").val(formatNumber(amount));
            if($('#getDiscount').val() == 1){
                calculeDiscount($("#discount"));
            }
        }
        function amountOrder() {
            amount = 0;
            for (var i = 1; i < total.length; i++) {
                amount += parseInt(total[i]);
            }
            $("[name=amount]").val(formatNumber(amount));
        }

        function cloneRowSale(obj) {
            var row = JSON.parse($(obj).attr('data-json'));
            countS++;
            var e = new Date();
            e.setMonth(e.getMonth() + 3);
            var fecha_validar = e.getFullYear() +"-"+ (e.getMonth()+1) +"-"+ e.getDate();
            var class_expiration = '';

            var f1 = new Date(e.getFullYear(), e.getMonth(), e.getDate());
            var date_validate = row.expiration.split("-");
            var f2 = new Date(date_validate[0], date_validate[1], date_validate[2]);
            if(f2 <= f1){
                class_expiration = 'class_expiration';
            }

            $("#tableToModify").append('<tr id="rowToClone-' + countS +
                '" class="'+class_expiration+'">' +
                '<td width="50px">' +
                '<input type="text" class="form-control" name="reference[]" id="reference-' + countS +
                '" value="'+ row.product.reference +'" readonly data-id="' + countS + '">' +
                '</td>' +
                '<td width="240px">' +
                '<input type="hidden" name="purchase_product_id[]" id="purchase_product-' + countS +
                '" value="'+ row.id +'" data-id="' + countS + '">' +
                '<select name="products[]" class="form-control" required data-id="' + countS + '" id="product-' +
                countS +
                '"><option value="'+ row.product.id +'">'+ row.product.name +'</option>' +
                '</select>' +
                '</td>' +
                '<td width="160px"><input type="text" id="presentation-' + countS +
                '" name="presentation[]" data-id="' + countS + '" class="form-control" value="'+
                row.product.presentation.name +'" readonly></td>' +
                '<td width="35px"><input type="text" maxlength="3" id="qty-' + countS +
                '" name="qty[]" onkeypress="return soloNumeros(event);" onkeyup="calcule('+ countS +')" data-id="' +
                countS + '" class="form-control" value="1" required></td>' +
                '<td><input type="text" id="lote-' + countS +
                '" name="lote[]" value="'+ row.lote +'" data-id="' + countS + '" class="form-control" readonly required></td>' +
                '<td><input type="text" class="form-control" value="'+ row.cant +'" required readonly></td>' +
                '<td width="110px"><div class="input-group"><input type="text" id="expiration-' + countS +
                '" name="date_expiration[]" value="'+ row.expiration +'" data-id="' + countS +
                '" class="form-control expiration" readonly required></div></td>' +
                '<td><input type="text" value="'+ formatNumber(parseInt(row.product.price)) +'" id="price-' + countS +
                '" name="price[]" readonly data-id="' + countS + '" class="form-control" required></td>' +
                '<td width="55px"><input type="text" value="'+ parseInt(row.product.tax) +'" maxlength="2" id="tax-' + countS +
                '" name="tax[]" readonly data-id="' + countS + '" class="form-control"></td>' +
                '<td><input type="text" id="total-' + countS +
                '" name="total[]" onkeypress="return soloNumeros(event);" data-id="' + countS +
                '" class="form-control" value="'+ formatNumber(parseInt(row.product.price)) +'" readonly></td>' +
                '<td><span class="icon-close closeRow" onclick="closeRow(' + countS +
                ')"></span></td>' +
                '</tr>');
            calcule(countS);
            //cerrarModal
            $('#ModalReceipt').modal('hide');
        }
    </script>
    <script src="{{ asset("js/webcam.min.js") }}"></script>
    <script>
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach( '#camera' );
    </script>
@endsection
