@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset("css/bootstrap-colorpicker.css") }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Egreso</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('expenses.index') }}"> Atrás</a>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('providers.create') }}"> Agregar Provedor</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('alert'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form id="posts" action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Escoger el provedor</p>
        <div class="line-form"></div>
        <div class="row justify-content-center">
            <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                <table id="table-soft-providers" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>NIT/C.C</th>
                        <th width="100px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($providers as $prov)
                        <tr>
                            <td>{{ $prov->company }}</td>
                            <td>{{ $prov->nit }}</td>
                            <td class="selectProvider" onclick="selectProvider({{$prov->id}},'{{$prov->company}}','{{$prov->address}}','{{$prov->city->name}}','{{$prov->phone}}')">
                                <a><span class="icon-eye mr-2"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-6 col-sm-4 col-md- col-lg-5">
                <input type="hidden" name="provider_id" id="provider_id" class="form-control" required>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-6">
                        <div class="form-group">
                            <strong>Nombres: <span>*</span></strong>
                            <input type="text" name="nameProvider" id="nameProvider" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-6">
                        <div class="form-group">
                            <strong>Dirreccion: <span>*</span></strong>
                            <input type="text" name="addresProvider" id="addresProvider" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-6">
                        <div class="form-group">
                            <strong>Ciudad: <span>*</span></strong>
                            <input type="text" name="cityProvider" id="cityProvider" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-6">
                        <div class="form-group">
                            <strong>Teléfono: <span>*</span></strong>
                            <input type="text" name="phoneProvider" id="phoneProvider" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line-form"></div>
        <div class="row justify-content-center">
            <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                <div class="form-group">
                    <strong>Observaciones: <span>*</span></strong>
                    <textarea class="form-control" name="observations" required></textarea>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Valor Egreso: <span>*</span></strong>
                            <input type="number" name="value" id="value" class="form-control OnlyNumber" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Total Descuento: </strong>
                            <input type="text" name="desc_total" id="desc_total" value="0" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>IVA Valor: </strong>
                            <input type="text" name="iva" id="iva" value="0" class="form-control" readonly required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line-form"></div>
        <div class="row justify-content-center">
            <div class="col-xs-6 col-sm-4 col-md- col-lg-6">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Porcentaje de IVA:</strong>
                            <input min="0" max="100" value="0" type="number" name="porcent_iva" id="porcent_iva" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Aplica Factura:</strong>
                            <select name="apli_fact" id="apli_fact" class="form-control">
                                <option value="no" selected>No</option>
                                <option value="si">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-5">
                        <div class="form-group">
                            <strong>Factura:</strong>
                            <select name="purchase_orders_id" id="purchase_order_id" class="form-control" disabled>
                                <option value="">Seleccione Factura</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                        <div class="form-group">
                            <strong>Saldo Pendiente :</strong>
                            <input type="number" value="0" id="sal_pend" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Forma de Pago:</strong>
                            <select name="form_pay" id="form_pay" class="form-control">
                                <option value="efectivo" selected>Efectivo</option>
                                <option value="consignacion">Consignación</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                        <div class="form-group">
                            <strong>Desc. por Pronto Pago:</strong>
                            <select name="desc_pront_pay" id="desc_pront_pay" class="form-control">
                                <option value="no" selected>No</option>
                                <option value="si">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Tipo de Desc.</strong>
                            <select name="desc_type" id="desc_type" class="form-control" disabled>
                                <option value="%" selected>%</option>
                                <option value="$">$</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                        <div class="form-group">
                            <strong>Valor de Desc.</strong>
                            <input type="number" min="0" name="desc_value" id="desc_value" value="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line-form"></div>
        <div class="row justify-content-center">
            <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Rte. Aplica</strong>
                            <select name="rte_aplica" id="rte_aplica" class="form-control">
                                <option value="no" selected>No</option>
                                <option value="si">Si</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-10">
                        <div class="form-group">
                            <strong>Retencion</strong>
                            <select name="retention_id" id="retention_id" class="form-control" disabled>
                                <option value="" selected>(seleccionar)</option>
                                @foreach($retentions as $ret)
                                    <option value="{{$ret->id}}" porcent="{{$ret->value}}">{{$ret->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Rte. Iva</strong>
                            <select name="rte_iva" id="rte_iva" class="form-control">
                                <option value="no" selected>No</option>
                                <option value="si">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Rte. Iva Porcentaje</strong>
                            <input min="0" max="100" value="0" type="number" name="rte_iva_porcent" id="rte_iva_porcent" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Rte. Ica</strong>
                            <select name="rte_ica" id="rte_ica" class="form-control">
                                <option value="no" selected>No</option>
                                <option value="si">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Rte. Ica Porcentaje</strong>
                            <input min="0" max="100" value="0" type="number" name="rte_ica_porcent" id="rte_ica_porcent" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                        <div class="form-group">
                            <strong>Rte. Cree</strong>
                            <select name="rte_cree" id="rte_cree" class="form-control">
                                <option value="no" selected>No</option>
                                <option value="si">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Rte. Cree Porcentaje</strong>
                            <input min="0" max="100" value="0" type="number" name="rte_cree_porcent" id="rte_cree_porcent" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>A Retener</strong>
                            <input type="text" name="rte_value" id="rte_value" value="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                        <div class="form-group">
                            <strong>Rte. Base</strong>
                            <input type="text" name="rte_base" id="rte_base" value="0" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                        <div class="form-group">
                            <strong>Rte. Porcentaje</strong>
                            <input type="text" name="rte_porcent" id="rte_porcent" value="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Rte. Iva Valor</strong>
                            <input type="number" value="0" name="rte_iva_value" id="rte_iva_value" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Rte. Ica Valor</strong>
                            <input type="number" value="0" name="rte_ica_value" id="rte_ica_value" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Rte. Cree Valor</strong>
                            <input type="number" value="0" name="rte_cree_value" id="rte_cree_value" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line-form"></div>

        <div class="row justify-content-center">
            <div class="col-xs-6 col-sm-4 col-md- col-lg-4">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-12">
                        <div class="form-group">
                            <strong>Centro de Costo</strong>
                            <select name="center_costs_id" class="form-control" required>
                                <option value="">seleccionar</option>
                                @foreach($centerCost as $cc)
                                    <option value="{{$cc->id}}">{{$cc->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xs-6 col-sm-4 col-md- col-lg-7">
                        <div class="form-group">
                            <strong>Total de Egreso</strong>
                            <input value="0" type="number" name="total_expense" id="total_expense" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="date" value="{{$date}}">
        <div class="separator"></div>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </form>
    <style>
        .row-soft
        {
            display: none;
        }
        .search-soft{
            width: 100%;
        }
        .search-soft input{
            max-width: 100%;
            min-width: 100%;
            width: 100%;
        }
        .search-soft label{
            width: 100%;
        }
        .selectProvider:hover{
            cursor: pointer;
        }
        textarea{
            height: 150px !important;
        }
    </style>
@endsection
@section('script')
    <script>
        $('#table-soft-providers').DataTable({
            "dom":' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar Provedor",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='https://test.smadiasoft.com/img/page-03.png' >",
                    "previous": "<img src='https://test.smadiasoft.com/img/page-02.png' >",
                },
            },
        });
        function selectProvider(idProvider,name,address,city,phone)
        {
            $('#provider_id').val(idProvider);
            $('#nameProvider').val(name);
            $('#addresProvider').val(address);
            $('#cityProvider').val(city);
            $('#phoneProvider').val(phone);
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{url('expenses/getPurchaseOrders')}}",
                type: "POST",
                dataType: "json",
                data:{
                    '_token':token,
                    id:idProvider,
                    action:'getPurchaseOrders'
                },
                success:function(datos){
                    $('#purchase_order_id .opctions').remove();
                    $.each(datos, function(index, d) {
                        $('#purchase_order_id').append('<option class="opctions" value="'+d.id+'" price="'+d.bill+'">'+d.comment+'</option> ');
                    });
                }
            });
        }

        $("#porcent_iva").on("keyup", function()
        {
            var value = $('#value').val();
            var porcent_iva = $('#porcent_iva').val();
            if(porcent_iva > 100){
                porcent_iva = 100
                $('#porcent_iva').val(100)
            }
            var iva = (value * porcent_iva) / 100;
            if(isNaN(iva)){
                iva = 0;
            }
            $('#iva').val(iva);
            total_expense();
        });

        $('#apli_fact').change(function () {
            if($("#apli_fact").val() == 'si'){
                $('#purchase_order_id').removeAttr('disabled');
            }else{
                $('#purchase_order_id').prop('disabled',true);
                $('#sal_pend').val(0);
            }
            total_expense();
        });

        $('#purchase_order_id').change(function () {
            $('#sal_pend').val($('#purchase_order_id option:selected').attr('price'));
            $('#value').val($('#purchase_order_id option:selected').attr('price'));
            validateAll();
            total_expense();
        });


        $('#desc_pront_pay').change(function () {
            if($('#desc_pront_pay').val() == 'si'){
                $('#desc_type').removeAttr('disabled');
                $('#desc_value').removeAttr('readonly');
            }else{
                $('#desc_type').prop('disabled',true);
                $('#desc_value').prop('readonly',true);
                $('#desc_value').val(0);
                $('#desc_total').val(0);
            }
            total_expense();
        });

        $('#desc_type').change(function () {
            desc_type();
        });

        $("#desc_value").on("keyup", function()
        {
            desc_type();
        });

        function desc_type()
        {
            if($('#desc_type').val() == '%'){
                var desc_value = $('#desc_value').val();
                if(desc_value>100){
                    desc_value = 100
                    $('#desc_value').val(100)
                }
                $('#desc_total').val(( $('#value').val()* desc_value)/100);
            }else{
                var desc_value = $('#desc_value').val();
                if(parseInt(desc_value) > parseInt($('#value').val())){
                    desc_value = $('#value').val();
                    $('#desc_value').val($('#value').val());
                }
                $('#desc_total').val(desc_value);
            }
            total_expense();
        }

        $('#value').on("keyup", function(){
            validateFactValue();
            validateAll();
            total_expense();
        });

        function validateFactValue()
        {
            if($('#apli_fact').val() == 'si')
            {
                var purchasevalue = $('#purchase_order_id option:selected').attr('price');
                if(parseInt(purchasevalue)<parseInt( $('#value').val())){
                    swal('','No puede realizar un egreso mayor al saldo de la factura','error');
                    $('#value').val(purchasevalue);
                }
            }
        }

        function validateAll()
        {
            var value = $('#value').val();
            var porcent_iva = $('#porcent_iva').val();
            if(porcent_iva > 100){
                porcent_iva = 100
                $('#porcent_iva').val(100)
            }
            var iva = (value * porcent_iva) / 100;
            if(isNaN(iva)){
                iva = 0;
            }
            $('#iva').val(iva);
            if($('#desc_pront_pay').val() == 'si'){
                if($('#desc_type').val() == '%'){
                    var desc_value = $('#desc_value').val();
                    if(desc_value>100){
                        desc_value = 100
                        $('#desc_value').val(100)
                    }
                    $('#desc_total').val(( $('#value').val()* desc_value)/100);
                }else{
                    var desc_value = $('#desc_value').val();
                    if(parseInt(desc_value) > parseInt($('#value').val())){
                        desc_value = $('#value').val();
                        $('#desc_value').val($('#value').val());
                    }
                    $('#desc_total').val(desc_value);
                }
            }
            if($('#rte_aplica').val() == 'si'){
                var retention = $('#retention_id option:selected').attr('porcent');
                retention = retention.replace(",", ".");
                $('#rte_base').val(retention);
                $('#rte_porcent').val(retention);
                var rte_value = ($('#value').val()*retention)/100;
                $('#rte_value').val(rte_value);
            }else{
                $('#retention_id').val("");
                $('#retention_id').prop('disabled',true);
                $('#rte_value').val(0);
                $('#rte_base').val(0);
                $('#rte_porcent').val(0);
            }
            if($('#rte_iva').val() == 'si'){
                if(validateNan($('#rte_iva_porcent').val()) > 0){
                    retentions('iva');
                }
            }
            if($('#rte_ica').val() == 'si'){
                if(validateNan($('#rte_ica_porcent').val()) > 0){
                    retentions('ica');
                }
            }
            if($('#rte_cree').val() == 'si'){
                if(validateNan($('#rte_cree_porcent').val()) > 0){
                    retentions('cree');
                }
            }
        }

        $('#rte_aplica').change(function () {
            if($("#rte_aplica").val() == 'si'){
                $('#retention_id').removeAttr('disabled');
            }else{
                $('#retention_id').val("");
                $('#retention_id').prop('disabled',true);
                $('#rte_value').val(0);
                $('#rte_base').val(0);
                $('#rte_porcent').val(0);
            }
            total_expense();
        });

        $('#retention_id').change(function () {
            var retention = $('#retention_id option:selected').attr('porcent');
            retention = retention.replace(",", ".");
            $('#rte_base').val(retention);
            $('#rte_porcent').val(retention);
            var rte_value = ($('#value').val()*retention)/100;
            $('#rte_value').val(rte_value);
            total_expense();
        });

        $('#rte_iva').change(function () {
            retentionsSelect('iva');
            total_expense();
        });

        $('#rte_iva_porcent').on("keyup", function(){
            retentions('iva');
            total_expense();
        });

        $('#rte_ica').change(function () {
            retentionsSelect('ica');
            total_expense();
        });

        $('#rte_ica_porcent').on("keyup", function(){
            retentions('ica');
            total_expense();
        });

        $('#rte_cree').change(function () {
            retentionsSelect('cree');
            total_expense();
        });

        $('#rte_cree_porcent').on("keyup", function(){
            retentions('cree');
            total_expense();
        });

        function retentionsSelect(name) {
            if($("#rte_"+name).val() == 'si'){
                $('#rte_'+name+'_porcent').removeAttr('readonly');
            }else{
                $('#rte_'+name+'_porcent').prop('readonly',true);
                $('#rte_'+name+'_porcent').val(0);
                $('#rte_'+name+'_value').val(0);
            }
        }

        function retentions(name) {
            var rte_porcent = $('#rte_'+name+'_porcent').val();
            if(rte_porcent > 100){
                rte_porcent = 100;
                $('#rte_'+name+'_porcent').val(100);
            }
            var rte_value = ( $('#value').val()*rte_porcent)/100;
            $('#rte_'+name+'_value').val(rte_value);
        }

        function total_expense()
        {
            var total_expense;
            var value = parseInt($('#value').val().replace('.',''));
            var desc_total = parseInt($('#desc_total').val().replace('.',''));
            var iva = parseInt($('#iva').val().replace('.',''));
            var rte_value = parseInt($('#rte_value').val().replace('.',''));
            var rte_iva_value = parseInt($('#rte_iva_value').val().replace('.',''));
            var rte_ica_value = parseInt($('#rte_ica_value').val().replace('.',''));
            var rte_cree_value = parseInt($('#rte_cree_value').val().replace('.',''));
            value = validateNan(value);
            desc_total = validateNan(desc_total);
            iva = validateNan(iva);
            rte_value = validateNan(rte_value);
            rte_iva_value = validateNan(rte_iva_value);
            rte_ica_value = validateNan(rte_ica_value);
            rte_cree_value = validateNan(rte_cree_value);
            total_expense = (((value - desc_total) +iva)-rte_value);
            total_expense = (((total_expense - rte_iva_value)-rte_ica_value)-rte_cree_value);
            if(total_expense < 0){
                total_expense = 0;
            }
            $('#total_expense').val(total_expense);
        }

        function validateNan(v){
            if(isNaN(v)){
                v = 0;
            }
            return v;
        }
    </script>
@endsection
