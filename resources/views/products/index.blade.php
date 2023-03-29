@extends('layouts.app')

@section('content')
@component("components.export_products", [
"url"=>url("exports/product"),
'type'=>$type
])
@endcomponent
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="title-crud mb-3">
            <h2>Productos</h2>
        </div>
        <div class="button-new">
            @can('create', \App\Models\Product::class)
            <a class="btn btn-primary" href="{{ route('products.create') }}"> Crear</a>
            @endcan
        </div>
        <div class="button-new">
            @can('view', \App\Models\Product::class)
            @if($user->id != 26)
            <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
            @else
            @endif
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
            <th>Nombre</th>
            <th>Referencia</th>
            <th>Precio</th>
            <th>IVA %</th>
            <!--
                <th>Proveedor</th>
                -->
            <th>Tipo</th>
            <th>Formulación</th>
            <th>Farmacia</th>
            <th>Inventario Personal</th>
            <th>Quirofano</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Fecha Invima</th>
            <th>Fecha creación</th>
            <th width="100px">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
        $type = \App\Models\Type::where('type','inventory')
        ->where('status','activo')
        ->get();
        $qty_0 = 0;
        $qty_1 = 0;
        $qty_2 = 0;
        $pCount = 0;
        $qty = 0;
        $qty_inventary = 0;
        @endphp
        @foreach ($products as $product)
        @php
        $qty = 0;
        $qty_inventary = 0;
        $pCount = 0;
        $pCount_2 = 0;
        $purchase = \App\Models\PurchaseProduct::where('product_id',$product->id)
        ->where('inventory','si')
        ->get();
        $personalInventory = \App\Models\PersonalInventory::where('product_id',$product->id)
        ->get();
        foreach($personalInventory as $p_2){
        $pCount = $pCount + $p_2->qty;
        }
        $transferObs = \App\Models\TransferWineryObservations::where('product_id',$product->id)
        ->get();
        foreach($transferObs as $p_3){
        $pCount_2 = $pCount_2 + $p_3->qty;
        }
        foreach($purchase as $p){
        if($product->inventory->name == 'Productos'){
        $qty_0 = $qty_0 + intval($p->qty_inventory);
        $qty_0 = $qty_0 + $pCount + $pCount_2;
        }
        if($product->inventory->name == 'Insumos'){
        $qty_1 = $qty_1 + intval($p->qty_inventory);
        $qty_1 = $qty_1 + $pCount + $pCount_2;
        }
        if($product->inventory->name == 'Consumibles'){
        $qty_2 = $qty_2 + intval($p->qty_inventory);
        $qty_2 = $qty_2 + $pCount + $pCount_2;
        }
        $qty_inventary = $qty_inventary + intval($p->qty_inventory);
        $qty = $qty_inventary + intval($pCount) + intval($pCount_2);
        }
        @endphp
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->reference }}</td>
            <td>{{ number_format($product->price, 0) }}</td>
            <td>{{ $product->tax }}</td>
            <td>{{ $product->inventory->name }}</td>
            <td>{{ $product->form }}</td>
            <td>
                {{$qty_inventary}}
            </td>
            <td>
                {{$pCount}}
            </td>
            <td>
                {{$pCount_2}}
            </td>
            <td>
                {{$qty}}
            </td>
            <td>{{ ucfirst($product->status) }} {!! ($product->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
            @if($product->date_invima != '')
            <td>{{ date("Y-m-d", strtotime($product->date_invima)) }}</td>
            @else
            <td></td>
            @endif
            <td>{{ date("Y-m-d", strtotime($product->created_at)) }}</td>
            <td>
                <form id="form-{{ $product->id }}" action="{{ route('products.destroy',$product->id) }}" method="POST">
                    <a class="openHistorialProducts" id="{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Visualizar historial">
                        <span class="icon-eye"></span>
                    </a>
                    @can('update', \App\Models\Product::class)
                    <a class="" href="{{ route('products.edit',$product->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    <!--
                            @can('delete', \App\Models\Product::class)
                                @csrf
                                @method('DELETE')
                                <a class="deleteProducts" data-id="form-{{ $product->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                        -->
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            @foreach($type as $t)
            <th>
                {{$t->name}}
                Cantidad:
                <span>
                    @if($t->name == 'Productos')
                    {{$qty_0}}
                    @endif
                    @if($t->name == 'Insumos')
                    {{$qty_1}}
                    @endif
                    @if($t->name == 'Consumibles')
                    {{$qty_2}}
                    @endif
                </span>
            </th>
            @endforeach
        </tr>
    </tfoot>
</table>

<div class="modal fade" id="modal_historial_products" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:inherit !important;justify-content: center;width: 90% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Historial de productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row div">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<style>
    .deleteProducts:hover {
        cursor: pointer;
    }
</style>
<script>
    $(".deleteProducts").click(function() {
        var obj = "#" + $(this).attr("data-id");
        swal({
                title: "¿Está seguro que desea eliminar este registro?",
                text: "¡No podrás recuperar esta información al hacerlo!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $(obj).submit();
                }
            });
    });

    $('.openHistorialProducts').click(function() {
        $.ajax({
            url: "/products/searchHistorial",
            method: "POST",
            data: {
                id: $(this).attr('id')
            },
            success: function(data) {
                $('#modal_historial_products .div').html();
                $('#modal_historial_products .div').html(data);
                $('#modal_historial_products').modal('show');
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
@endsection
