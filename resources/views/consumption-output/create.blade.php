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
                <h2>Salidad por consumo</h2>
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


    <form id="formSale" method="POST" action="{{ route("consumption-output.store") }}">
        @csrf
        <div class="row">
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
                    <th class="fl-ignore">Cant. Dispo.</th>
                    <th class="fl-ignore">Lote</th>
                    <th class="fl-ignore">Vence</th>
                    <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="c-primary font-weight-bold">Bodega (opcional)</label>
                            <select name="cellar_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach($cellars as $c)
                                    @if($c->id != 8)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="c-primary font-weight-bold">Observaciones</label>
                        <div class="form-group">
                            <textarea name="observations" rows="4" class="form-control" required></textarea>
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
        .table-sale td{
            padding: 0.5rem 0.1rem !important;
        }
        .content-dash{
            width: 98%;
            padding: 1rem 1rem;
        }
    </style>
    <script>
        var countS = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
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


        function cloneRowSale(obj) {
            var row = JSON.parse($(obj).attr('data-json'));
            countS++;
            var e = new Date();
            e.setMonth(e.getMonth() + 3);
            var fecha_validar = e.getFullYear() +"-"+ (e.getMonth()) +"-"+ e.getDate();
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
                '<td width="35px"><input type="text" maxlength="4" id="qty-' + countS +
                '" name="qty[]" onkeypress="return soloNumeros(event);" onkeyup="calcule('+ countS +')" data-id="' +
                countS + '" class="form-control" value="1" required></td>' +
                '<td><input type="text" class="form-control" value="'+ row.cant +'" required readonly></td>' +
                '<td><input type="text" id="lote-' + countS +
                '" name="lote[]" value="'+ row.lote + '" data-id="' + countS + '" class="form-control" readonly required></td>' +
                '<td width="110px"><div class="input-group"><input type="text" id="expiration-' + countS +
                '" name="date_expiration[]" value="'+ row.expiration +'" data-id="' + countS +
                '" class="form-control expiration" required readonly></div></td>' +
                '<td><span class="icon-close closeRow" onclick="closeRow(' + countS +
                ')"></span></td>' +
                '</tr>');
            //cerrarModal
            $('#ModalReceipt').modal('hide');
        }
    </script>
@endsection
