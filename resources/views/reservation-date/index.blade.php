@extends('layouts.app')

@section('content')
    @component("components.export", [
        "url"=>url("exports/loteproduct")
    ])
    @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Bloqueo de citas</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\ReservationDate::class)
                    <a class="btn btn-primary" href="{{ route('reservation-date.create') }}"> Crear</a>
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
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Hora inicio</th>
                <th>Hora fin</th>
                <th>Fecha de inicio</th>
                <th>Motivo</th>
                <th>Observacion</th>
                <th>Creado por</th>
                <th>Fecha de creacion</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{$d->id}}</td>
                <td>{{ $d->responsable->name }} {{ $d->responsable->lastname }}</td>
                <td>{{ $d->option}}</td>
                <td>{{ date("h:i a", strtotime($d->hour_start)) }}</td>
                <td>{{ date("h:i a", strtotime($d->hour_end)) }}</td>
                <td>{{ date("Y-m-d", strtotime($d->date_start)) }}</td>
                <td>{{ $d->motiv }}</td>
                <td>{{ $d->observation }}</td>
                <td>{{ $d->user->name }} {{$d->user->lastname}}</td>
                <td>{{ date("Y-m-d", strtotime($d->created_at)) }}</td>
                <td>
                    @can('update', \App\Models\ReservationDate::class)
                        <a class="" href="{{ route('reservation-date.edit',$d->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\ReservationDate::class)
                        @csrf
                        @method('DELETE')
                        <a class="deleteArea" id="{{ $d->id }}"><span class="icon-icon-12"></span></a>
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
                        location.href = '{{url('reservation-date/delete')}}/'+id;
                    }
                });
        });
    </script>
@endsection
