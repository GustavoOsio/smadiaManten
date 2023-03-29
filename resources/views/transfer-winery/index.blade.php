@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Transferencia por Bodega</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Sale::class)
                    <a href="{{ route("transfer-winery.create") }}" class="btn btn-primary" > Crear</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Elaborado por</th>
            <th>Bodega</th>
            <th>Observaciones</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($transfer as $c)
            <tr>
                <td>TB-{{ $c->id }}</td>
                <td>{{ $c->user->name }} {{ $c->user->lastname }}</td>
                <td>
                    @if($c->cellar_id != '')
                        {{$c->cellar->name}}
                    @endif
                </td>
                <td>{{$c->observations}}</td>
                <td>{{ucfirst($c->status)}}</td>
                <td>{{ date("Y-m-d", strtotime($c->created_at)) }}</td>
                <td>
                    <a href="{{ route('transfer-winery.show',$c->id) }}"><span class="icon-eye"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Salidad por consumo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEditAjustInventory">
                        <div class="form-group">
                            <h6>
                                Producto:
                            </h6>
                            <input type="hidden" id="product_id" name="product_id" class="form-control" required/>
                            <input type="text" id="product_name" name="product_name" class="form-control" required readonly/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad:
                            </h6>
                            <input id="product_qty" name="product_qty"  type="text" class="form-control" onkeypress="return soloNumeros(this)"/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad Disponible:
                            </h6>
                            <input type="text" class="form-control" id="product_cant" name="product_cant" required readonly/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Observacion:
                            </h6>
                            <textarea class="form-control" name="observations" id="observations" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submitModalEdit">Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('.OpenModalEdit').click(function (e) {
            $('#product_cant').val(this.dataset.cant);
            $('#product_id').val(this.dataset.id);
            $('#product_name').val(this.dataset.name);
            $('#modalEdit').modal('show');
        });
        $('.submitModalEdit').click(function () {
            if($('#product_qty').val() < 1 || $('#product_qty').val() == ''){
                swal({
                    title: "Debe digitar una cantidad a ajustar mayor a 0",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            if($('#type_inventory').val() == ''){
                swal({
                    title: "Debe seleccionar un tipo de ajuste",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            if($('#observations').val() == ''){
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
            swal({
                    title: "¿Está seguro que desea actualizar este producto?",
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
                        $('#formEditAjustInventory').submit();
                    }
                });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#formEditAjustInventory').on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{url('/update_consumption_output')}}",
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
        function soloNumeros(e)
        {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;
            return /\d/.test(String.fromCharCode(keynum));
        }
    </script>
    <style>
        .OpenModalEdit:hover{
            cursor: pointer;
        }
        .reder{
            background: #8a0000 !important;
        }
        .reder td{
            color: #ffffff !important;
        }
        .reder .icon-icon-11:before{
            color: #ffffff !important;
        }
    </style>
@endsection
