@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Areas</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Areas::class)
                    <a class="btn btn-primary" href="{{ route('areas.create') }}"> Crear</a>
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
            <th>Bodega</th>
            <th>Estado</th>
            <th>Fecha creación</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($areas as $a)
            <tr>
                <td>A-{{ $a->id }}</td>
                <td>{{ ucfirst($a->name) }}</td>
                @if($a->cellar_id <> 0)
                    <td>{{ $a->cellar->name }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ $a->status }}</td>
                <td>{{ date("Y-m-d", strtotime($a->created_at)) }}</td>
                <td>
                    @can('update', \App\Models\Areas::class)
                        <a class="" href="{{ route('areas.edit',$a->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Areas::class)
                        <a class="deleteArea" id="{{$a->id}}"><span class="icon-icon-12"></span></a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
    <style>
        .deleteArea:hover{
            cursor: pointer;
        }
    </style>
    <script>
        $('.deleteArea').click(function () {
            var id = this.id;
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
                        location.href = '{{url('areas/delete')}}/'+id;
                    }
                });
        });
    </script>
@endsection
