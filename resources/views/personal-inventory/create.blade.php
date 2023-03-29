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
                <form id="frmSearchProductPersonal">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           id="search" name="search" onkeyup="productSearchPersonal(this.value)"
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


    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Inventario Personal</h2>
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


    <form id="formSale" method="POST" action="{{ route("personal-inventory.store") }}">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <label for="" class="c-primary font-weight-bold">Personal</label>
                <div class="form-group">
                    <select name="user_id" required class="form-control filter-schedule">
                        @foreach($users as $u)
                            @if($u->id != 1)
                                <option value="{{$u->id}}">{{$u->name}} {{$u->lastname}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-6 margin-tb">
                        <div class="title-crud" data-toggle="modal" data-target="#ModalReceipt">
                            <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                                Agregar Productos a Inventario Personal
                            </h4>
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
                    <th class="fl-ignore">Cant Disponible</th>
                    <th class="fl-ignore">Lote</th>
                    <th class="fl-ignore">Vence</th>
                    <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            <textarea class="form-control" name="observations" required rows="6"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-5 col-md-6 margin-tb">
                        <div class="button-new">
                            <button type="submit" class="btn btn-primary btn-personal-inventory">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
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
        function productSearchPersonal(obj) {
            if (obj.length > 2) {
                $("#frmSearchProductPersonal").submit();
            }
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

        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
            price[pos] = 0;
            qty[pos] = 0;
            total[pos] = 0;
            $("#rowToClone-" + pos).remove();
            amountT();
        }

        function cloneRowPersonal(obj) {
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
                '" name="qty[]" onkeypress="return soloNumeros(event);" data-id="' +
                countS + '" class="form-control" value="1" required></td>' +
                '<td width="100px"><input type="text" class="form-control" value="'+ row.cant +'" required readonly></td>' +
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
