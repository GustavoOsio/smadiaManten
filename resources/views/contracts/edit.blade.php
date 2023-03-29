@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Contrato</h2>
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


    <form id="formContractUpdate" method="POST">
        @csrf
        <input type="hidden" value="{{ $contract->id }}" id="contract_id">
        {{--<div class="separator"></div>--}}
        {{--<p class="title-form">Rellenar</p>--}}
        {{--<div class="line-form"></div>--}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table">
                    <thead>
                    <th class="fl-ignore">Servicio</th>
                    <th class="fl-ignore">Cantidad</th>
                    <th class="fl-ignore">Valor unitario</th>
                    <th class="fl-ignore">Descuento %</th>
                    <th class="fl-ignore">Valor del descuento</th>
                    <th class="fl-ignore">Valor a cancelar</th>
                    <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                    @foreach($contract->items as $i => $item)
                    <tr id="rowToClone-{{ $i + 1 }}">
                        <td>
                            <select name="services[]" id="service-{{ $i + 1 }}" class="form-control" data-id="{{ $i + 1 }}" onchange="serviceCon(this)">
                                <option value="">Seleccione servicio</option>
                                @foreach($services as $service)
                                    @if ($service->id == $item->service_id)
                                        <option selected value="{{ $service->id }}">{{ $service->name }}</option>
                                    @else
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="name[]" value="{{ $item->service->name }}" id="name-{{ $i + 1 }}">
                        </td>
                        <td>
                            <input type="text" value="{{ $item->qty }}" data-id="{{ $i + 1 }}" id="qty-{{ $i + 1 }}" name="qty[]" placeholder="0" class="form-control"
                                   onkeyup="calcule(this, 'qty')" onkeypress="return soloNumeros(event);">
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" value="{{ number_format($item->price, 0, ',', '.') }}" name="price[]" id="price-{{ $i + 1 }}" placeholder="0" class="form-control" readonly>
                            </div>
                        </td>
                        <td>
                            <input type="text" value="{{ number_format($item->percent, 0) }}" maxlength="2" data-id="{{ $i + 1 }}" id="percent-{{ $i + 1 }}" name="percent[]" placeholder="0" class="form-control"
                                   onkeyup="calcule(this, 'percent')" onkeypress="return soloNumeros(event);">
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input readonly name="discount[]" type="text" value="{{ number_format($item->discount_value, 0, ',', '.') }}" id="price-d-{{ $i + 1 }}" data-id="{{ $i + 1 }}" placeholder="0" class="form-control"
                                       onkeyup="calcule(this, 'discount')" onkeypress="return soloNumeros(event);">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input name="total[]" type="text" value="{{ number_format($item->total, 0, ',', '.') }}"
                                       id="price-p-{{ $i + 1 }}" data-id="{{ $i + 1 }}" class="form-control" onkeyup="calcule(this, 'price')">
                            </div>
                        </td>
                        <td><span class="icon-close closeRow" onclick="closeRow({{ $i + 1 }})"></span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="validationTooltip" class="c-primary font-weight-bold">Total</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" name="amount" readonly onkeypress="return soloNumeros(event);" class="form-control" value="{{ number_format($contract->amount, 0, ',', '.') }}" id="validationTooltip" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="validationTooltip" class="c-primary font-weight-bold">Vendedor</label>
                <div class="form-group">
                    <select name="seller_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($sellers as $s)
                            @if ($contract->seller_id === $s->id)
                                <option selected value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                            @else
                                <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <label class="c-primary fw5">Observaciones</label>
                <div class="form-group">
                    <textarea name="comment" rows="4" class="form-control" required>{{ $contract->comment }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-6 margin-tb">
                        <div class="title-crud" id="cloneRow" data-id="{{ count($contract->items) }}">
                            <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar servicio</h4>
                        </div>
                        <div class="button-new">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
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

        for (var i = 1; i <= $(["name=services"]).length; i++) {
            price[i] = $("#price-" + i).val().replace('.', '').replace('.', '');
            priced[i] = $("#price-d-" + i).val().replace('.', '').replace('.', '');
            pricep[i] = $("#price-p-" + i).val().replace('.', '').replace('.', '');
            qty[i] = $("#qty-" + i).val();
            percent[i] = $("#percent-" + i).val();
            priceA[i] = $("#price-" + i).val().replace('.', '').replace('.', '');
        }

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
            if (key === 'percent') {
                price[pos] = priceA[pos] * qty[pos];
                percent[pos] = valor;
                priced[pos] = price[pos] * parseFloat(percent[pos]) / 100;
                pricep[pos] = price[pos] - priced[pos];
            }
            if (key === 'qty') {
                qty[pos] = valor;
                price[pos] = priceA[pos] * qty[pos];
                priced[pos] = price[pos] * parseFloat(percent[pos] / 100);
                pricep[pos] = price[pos] - priced[pos];
            }
            if (key === 'discount') {
                priced[pos] = valor;
                pricep[pos] = price[pos] - priced[pos];
                percent[pos] = priced[pos] / price[pos] * 100;
            }
            if (key === 'price') {
                pricep[pos] = valor;
                priced[pos] = price[pos] - pricep[pos];
                percent[pos] = priced[pos] / price[pos] * 100;
            }

            amountT();

            $("#percent-" + pos).val(percent[pos]);
            $("#price-d-" + pos).val(formatNumber(priced[pos]));
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
