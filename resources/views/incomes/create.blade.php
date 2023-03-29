@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Contrato</h2>
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


    <form id="formContract" method="POST">
        @csrf
        {{--<div class="separator"></div>--}}
        {{--<p class="title-form">Rellenar</p>--}}
        {{--<div class="line-form"></div>--}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table">
                    <thead>
                        <th>Servicio</th>
                        <th>Cantidad</th>
                        <th>Valor unitario</th>
                        <th>Descuento %</th>
                        <th>Valor del descuento</th>
                        <th>Valor a cancelar</th>
                        <th></th>
                    </thead>
                    <tbody id="tableToModify">
                        <tr id="rowToClone-1">
                            <td>
                                <select name="services[]" id="service-1" class="form-control" data-id="1" onchange="serviceCon(this)">
                                    <option value="">Seleccione servicio</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="name[]" id="name-1">
                            </td>
                            <td>
                                <input type="text" data-id="1" id="qty-1" name="qty[]" placeholder="0" class="form-control"
                                       onkeyup="calcule(this, 'qty')" onkeypress="return soloNumeros(event);">
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" name="price[]" id="price-1" placeholder="0" class="form-control" readonly>
                                </div>
                            </td>
                            <td>
                                <input type="text" maxlength="2" data-id="1" id="percent-1" name="percent[]" placeholder="0" class="form-control"
                                       onkeyup="calcule(this, 'percent')" onkeypress="return soloNumeros(event);">
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" id="price-d-1" data-id="1" placeholder="0" class="form-control"
                                       onkeyup="calcule(this, 'discount')" onkeypress="return soloNumeros(event);">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" id="price-p-1" data-id="1" placeholder="0" class="form-control">
                                </div>
                            </td>
                            <td><span class="icon-close closeRow" onclick="closeRow(1)"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="validationTooltip" class="c-primary font-weight-bold">Total</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" name="amount" readonly onkeypress="return soloNumeros(event);" class="form-control" placeholder="0" id="validationTooltip" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="validationTooltip" class="c-primary font-weight-bold">Vendedor</label>
                <div class="form-group">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <select name="seller_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($sellers as $s)
                            <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <label class="c-primary fw5">Observaciones</label>
                <div class="form-group">
                    <textarea name="comment" rows="4" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-6 margin-tb">
                        <div class="title-crud" id="cloneRow">
                            <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar servicio</h4>
                        </div>
                        <div class="button-new">
                            <button type="submit" class="btn btn-primary">Guardar contrato</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        var priceA = [];
        var price = [];
        var priced = [];
        var pricep = [];
        var qty = [];
        var percent = [];
        var amount = 0;
        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
            price[pos] = 0;
            priced[pos] = 0;
            pricep[pos] = 0;
            qty[pos] = 0;
            percent[pos] = 0;
            priceA[pos] = 0;
            contenedor.removeChild(eliminar);
            amountT();
        }
        function serviceCon(obj) {
             var pos = $(obj).attr('data-id');
            $.ajax({
                async:true,
                type: 'POST',
                url: '/service',
                dataType: 'json',
                data: 'id=' + $(obj).val(),
                statusCode: {
                    200: function(data) {
                        price[pos] = data.price;
                        priceA[pos] = data.price;
                        priced[pos] = 0;
                        qty[pos] = 1;
                        percent[pos] = 0;
                        pricep[pos] = data.price;
                        $("#qty-" + pos).val(1);
                        $("#price-" + pos).val(formatNumber(data.price));
                        $("#percent-" + pos).val(0);
                        $("#price-d-" + pos).val(0);
                        $("#name-" + pos).val(data.name);
                        $("#price-p-" + pos).val(formatNumber(data.price));
                        amountT();
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
        function soloNumeros(e)
        {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;
            return /\d/.test(String.fromCharCode(keynum));
        }
        function calcule(obj, key) {
            var pos = $(obj).attr('data-id');
            if (key === 'percent') {
                price[pos] = priceA[pos] * qty[pos];
                percent[pos] = $(obj).val();
                priced[pos] = price[pos] * parseFloat(percent[pos]) / 100;
                pricep[pos] = price[pos] - priced[pos];
            }
            if (key === 'qty') {
                qty[pos] = $(obj).val();
                price[pos] = priceA[pos] * qty[pos];
                priced[pos] = price[pos] * parseFloat(percent[pos] / 100);
                pricep[pos] = price[pos] - priced[pos];
            }
            if (key === 'discount') {
                priced[pos] = $(obj).val();
                pricep[pos] = price[pos] - priced[pos];
                percent[pos] = priced[pos] / price[pos] * 100;
            }

            amountT();

            $("#percent-" + pos).val(percent[pos]);
            $("#price-d-" + pos).val(priced[pos]);
            $("#price-" + pos).val(formatNumber(priceA[pos]));
            $("#price-p-" + pos).val(formatNumber(pricep[pos]));


        }

        function amountT() {
            amount = 0;
            for (var i = 1; i < pricep.length; i++) {
                amount += parseInt(pricep[i]);
            }
            $("[name=amount]").val(formatNumber(amount));
        }
    </script>
@endsection