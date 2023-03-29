@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Líneas de servicio</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Service::class)
                    <a class="btn btn-primary" href="{{ route('services.create') }}"> Crear</a>
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
                <th>Nombre</th>
                <th>Precio</th>
                <th>Precio a pagar</th>
                <th>Precio de insumo</th>
                <th>Porcentaje</th>
                <th>H. gasto</th>
                <th>Restringido</th>
                <th>Contrato</th>
                <th>Depilcare</th>
                <th>Type</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->name }}</td>
                <td>$ {{ number_format($service->price, 0) }}</td>
                <td>$ {{ number_format($service->price_pay, 0) }}</td>
                <td>$ {{ number_format($service->price_input, 0) }}</td>
                <td>{{ $service->percent }}</td>
                <td>{{ $service->xpenses_sheet }}</td>
                <td>{{ $service->restricted }}</td>
                <td>{{ $service->contract }}</td>
                <td>{{ $service->depilcare }}</td>
                <td>{{ ucfirst($service->type) }}</td>
                <td>{{ ucfirst($service->status) }} {!! ($service->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($service->created_at)) }}</td>
                <td>
                    <form id="form-{{ $service->id }}" action="{{ route('services.destroy',$service->id) }}" method="POST">
                        @can('update', \App\Models\Service::class)
                            <a class="" href="{{ route('services.edit',$service->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                        <!--
                        @can('delete', \App\Models\Service::class)
                            @csrf
                            @method('DELETE')
                            <a class="form-submit deleteService" id="{{ $service->id }}" data-id="form-{{ $service->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                        -->
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('script')
    <script>
        $('.deleteService').click(function () {
            var id = this.id;
            swal({
                title: "",
                text: "¿Seguro de eliminar este servicio?",
                type: "info",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonText: "Continuar",
                closeOnConfirm: false
            },
            function(isConfirm){
                if (isConfirm) {
                    location.href = '{{url('services/delete')}}'+'/'+id;
                } else {
                    return false;
                }
            });

        });
    </script>
@endsection
