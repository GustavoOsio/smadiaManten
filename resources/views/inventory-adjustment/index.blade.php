@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Ajuste de Inventario</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\InventoryAdjustment::class)
                    <a class="btn btn-primary" style="color: #ffffff" href="{{Route('inventory-adjustment.create')}}">Crear</a>
                @endcan
            </div>
            <div class="button-new">
                @can('create', \App\Models\InventoryAdjustment::class)
                    <a class="btn btn-primary OpenModalAdd" style="color: #ffffff">Agregar</a>
                @endcan
            </div>
            <div class="button-new">
                @can('create', \App\Models\InventoryAdjustment::class)
                    <a class="btn btn-primary" href="{{url('/inventory-adjustment/index/historial')}}" style="color: #ffffff">Historial</a>
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
            <th>Observaciones</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($inventory as $i)
                <tr>
                    <td>AI-{{$i->id}}</td>
                    <td>{{$i->user->name}} {{$i->user->lastname}}</td>
                    <td>{{$i->observations}}</td>
                    <td>{{$i->type=='rest'?'Quitar':'Agregar'}}</td>
                    <td>{{ucfirst($i->status)}}</td>
                    <td>{{ date("Y-m-d", strtotime($i->created_at)) }}</td>
                    <td>
                        <a href="{{ route('inventory-adjustment.show',$i->id) }}"><span class="icon-eye"></span></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar Inventario</h5>
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
                                Tipo de ajuste:
                            </h6>
                            <select required name="type_inventory" id="type_inventory" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="add">AGREGAR</option>
                                <option value="rest">QUITAR</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad a ajustar:
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
                            <select name="product_id" id="product_id_2"  class="form-control">
                                <option value="">seleccionar</option>
                                @foreach($productList as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad:
                            </h6>
                            <input id="product_qty_2" name="product_qty"  type="text" class="form-control" onkeypress="return soloNumeros(this)"/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Lote:
                            </h6>
                            <input id="lote" name="lote"  type="text" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Fecha de vecimiento:
                            </h6>
                            <input id="date" name="date"  type="text" class="form-control datetimepicker"/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Observacion:
                            </h6>
                            <textarea class="form-control" name="observations" id="observations_2" rows="5"></textarea>
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
                url: "{{url('/update_inventory_adjustment')}}",
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
    <script>
        $('.OpenModalAdd').click(function () {
            $('#modalAdd').modal('show');
        });
        $('.submitModalAdd').click(function () {
            if($('#product_qty_2').val() < 1 || $('#product_qty_2').val() == ''){
                swal({
                    title: "Debe digitar una cantidad mayor a 0",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            if($('#lote').val() == ''){
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
            if($('#date').val() == ''){
                swal({
                    title: "Debe seleccionar una fecha",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
                return false;
            }
            if($('#observations_2').val() == ''){
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
                        $('#formAddInventory').submit();
                    }
                });
        });
        $('#formAddInventory').on('submit',function (e) {
            e.preventDefault();
            swal({
                title: 'AVISO',
                text: 'Espere un momento',
                showCancelButton: false,
                showConfirmButton: false,
            });
            $.ajax({
                url: "{{url('/add_inventory_adjustment')}}",
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
    </script>
@endsection
