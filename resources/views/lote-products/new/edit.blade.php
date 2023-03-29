<!--
qwerty uiop======abcdeg ghijk
asdfgh jklñ======lmnño pqrs
zxc vbnm======tuv wzyz
-->
@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear recepcion de pedido / Compra OC-{{$orderForm->id}}</h2>
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


    <form id="formOrderReceipt" method="POST">
        @csrf
        <input type="hidden" id="count" value="{{ (count($orderForm->products) > 0) ? count($orderForm->products) : 1 }}">
        <input type="hidden" name="id_order_form" value="{{ $orderForm->id }}">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table">
                    <thead>
                    <th class="fl-ignore">Producto</th>
                    <th class="fl-ignore">Cant. Solic.</th>
                    <th class="fl-ignore">Can. Recib.</th>
                    <th class="fl-ignore">Lote</th>
                    <th class="fl-ignore">Fecha de vencimiento</th>
                    <th class="fl-ignore">Invima</th>
                    <th class="fl-ignore">Fecha invima</th>
                    <th class="fl-ignore">Renovacion invima</th>
                    <th class="fl-ignore">Empaque</th>
                    <th class="fl-ignore">Transporte</th>
                    <th class="fl-ignore">Inconfirmidad</th>
                    <th class="fl-ignore">Temperatura</th>
                    <th class="fl-ignore">Aceptado</th>
                    </thead>
                    <tbody id="tableToModify">
                    @php
                        $c = 0;
                    @endphp
                    @foreach($orderForm->new_fault as $key => $p)
                        @php $c++; @endphp
                        <tr id="rowToClone-{{ $c }}">
                            <td width="250">
                                <select name="products[]" id="product-{{ $c }}" class="form-control" data-id="{{ $c }}" required onchange="searchProduct(this.value, {{ $c }})">
                                    @foreach($products as $product)
                                        @if ($p->product->id === $product->id)
                                            <option selected value="{{ $p->id }}">{{ $product->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td width="85">
                                <div class="input-group">
                                    <input type="text"
                                           maxlength="4"
                                           id="qty-{{ $c }}"
                                           value="{{ number_format($p->qty, 0) }}"
                                           data-id="{{ $c }}"
                                           class="form-control"
                                           required readonly>
                                </div>
                            </td>
                            <td width="85">
                                <div class="input-group">
                                    <input
                                        type="number"
                                        name="qty[]"
                                        maxlength="4"
                                        min="0"
                                        max="{{$p->qty}}"
                                        id="qty-{{ $c }}"
                                        data-id="{{ $c }}"
                                        class="form-control"
                                        onkeypress="return soloNumeros(event);"
                                        required>
                                </div>
                            </td>
                            <td width="200">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        name="lote[]"
                                        class="form-control"
                                        required>
                                </div>
                            </td>
                            <td width="200">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        name="date[]"
                                        class="form-control datetimepicker"
                                        required>
                                </div>
                            </td>
                            <td width="200">
                                <div class="input-group">
                                    <input
                                        value="{{$p->product->invima}}"
                                        type="text"
                                        name="invima[]"
                                        class="form-control"
                                        readonly
                                        required>
                                </div>
                            </td>
                            <td width="200">
                                <div class="input-group">
                                    <input
                                        value="{{$p->product->date_invima}}"
                                        type="text"
                                        name="date_invima[]"
                                        class="form-control datetimepicker">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="renov_invima[]" class="form-control">
                                        <option value="">Seleccionar</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="packing[]" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="si" selected>SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="transport[]" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="si" selected>SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="inconfirmness[]" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="si">SI</option>
                                        <option value="no" selected>NO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="temperature[]" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="tamb" selected>TAMB</option>
                                        <option value="cfrio">CFRIO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="accepted[]" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="si" selected>SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <a data-toggle="tooltip" data-placement="top" title="Eliminar">
                                    <span class="icon-close closeRow" onclick="closeRow({{ $c }})"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5">
                <label class="c-primary font-weight-bold">Observaciones</label>
                <div class="form-group">
                    <textarea name="observations" rows="4" class="form-control" required></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-8 margin-tb">
                        <div class="button-new">
                            <button id="disable_button" type="submit" class="btn btn-primary">Crear recepcion</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection
@section('script')
    <style>
        .search-table-input{
            display: none;
        }
        .content-dash{
            width: 99% !important;
            padding: 1rem 1rem !important;
        }
        .table th, .table td{
            padding: 0% 2px !important;
        }
    </style>
    <script>
        function soloNumeros(e)
        {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;
            return /\d/.test(String.fromCharCode(keynum));
        }
        $('#formOrderReceipt').on('submit',(function (e) {
            e.preventDefault();
            const dataForm = $(this).serialize();
            $('#disable_button').attr('disabled', true);
            //return false;
            swal({
                title: 'AVISO',
                text: 'Espere un momento',
                showCancelButton: false,
                showConfirmButton: false,
            });
            $.ajax({
                async:true,
                type: 'POST',
                url:'/order-receipt/store',
                dataType: 'json',
                data: dataForm,
                statusCode: {
                    200: function(data) {
                        swal({
                                title: "Bien hecho",
                                text: "La recepcion de pedido ha sido creada con éxito",
                                type: "success",
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    location.href="/order-receipt/index/listar"
                                }
                            });
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }));
        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
            contenedor.removeChild(eliminar);
            $('.ui-tooltip').hide();
        }
    </script>
@endsection
