@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>{{ucwords(ucfirst($user->name.' '.$user->lastname))}} - {{ucwords(ucfirst($user->role->name))}}</h2>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <p class="title-form" style="text-align: left">INVENTARIO</p>
    <div class="line-form"></div>
    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($listP as $lp)
            @if($lp->qty > 0)
                <tr>
                    <td>{{ $lp->product->name }}</td>
                    <td>{{ $lp->qty }}</td>
                    <td>
                        @can('update', \App\Models\PersonalInventory::class)
                            <a class="OpenModalEdit"
                               data-id="{{$lp->id}}"
                               data-product="{{$lp->product->id}}"
                               data-name="{{ $lp->product->name }}"
                               data-cant="{{ $lp->qty }}"
                            >
                                <span class="icon-icon-11"></span>
                            </a>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    <div class="separator"></div>
    <p class="title-form" style="text-align: left">HISTORIAL</p>
    <div class="line-form"></div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">ID</th>
            <th class="fl-ignore">Producto</th>
            <th class="fl-ignore">Cantidad</th>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Observaciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $l)
            <tr>
                <td>H-ID-{{ $l->id }}</td>
                <td>{{ $l->productPurchase->product->name }}</td>
                <td>{{ $l->qty }}</td>
                <td>{{ $l->date }}</td>
                <td>{{ $l->observations }}</td>
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
                    <form action="" id="formEditAjustInventoryPersonal">
                        <div class="form-group">
                            <h6>
                                Producto:
                            </h6>
                            <input type="hidden" id="id" name="id" class="form-control" required/>
                            <input type="hidden" id="product_id" name="product_id" class="form-control" required/>
                            <input type="text" id="product_name" name="product_name" class="form-control" required readonly/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Lote: (opcional - al seleccionar uno no se puede deshacer)
                            </h6>
                            <select style="width: 100%" required name="lote_id" id="lote_id" class="form-control filter-schedule">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad a regresar:
                            </h6>
                            <input id="product_qty" name="product_qty"  type="text" class="form-control" onkeypress="return soloNumeros(this)"/>
                        </div>
                        <div class="form-group">
                            <h6>
                                Cantidad Disponible:
                            </h6>
                            <input type="text" class="form-control" id="product_cant" name="product_cant" required readonly/>
                        </div>
                        <!--
                        <div class="form-group">
                            <h6>
                                Observacion:
                            </h6>
                            <textarea class="form-control" name="observations" id="observations" rows="5"></textarea>
                        </div>
                        -->
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
        $('#id').val(this.dataset.id);
        $('#product_id').val(this.dataset.product);
        $('#product_name').val(this.dataset.name);
        $('#modalEdit').modal('show');
        $("#lote_id").val('');
        $("#lote_id").select2({
            ajax: {
                dataType: "json",
                url: "/purchase-orders/lotes/get",
                data: {id: this.dataset.name  },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
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
                    $('#formEditAjustInventoryPersonal').submit();
                }
            });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#formEditAjustInventoryPersonal').on('submit',function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{url('/personal-inventory/update')}}",
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
@endsection
