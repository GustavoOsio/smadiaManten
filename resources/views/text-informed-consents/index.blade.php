@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Textos de concentimientos</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\TextInformedConsents::class)
                    <a class="btn btn-primary" href="{{ route('text-informed-consents.create') }}"> Crear</a>
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
            <th>Servicio</th>
            <th>Fecha creación</th>
            <th width="100px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($text as $t)
            <tr>
                <td>{{ $t->service->name }}</td>
                <td>{{ date("Y-m-d", strtotime($t->created_at)) }}</td>
                <td>
                    @can('update', \App\Models\TextInformedConsents::class)
                        <a class="" href="{{ route('text-informed-consents.edit',$t->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\TextInformedConsents::class)
                    @csrf
                    @method('DELETE')
                        <a class="deleteService" id="{{ $t->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
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
                    text: "¿Seguro de eliminar este Texto de consentimiento?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        location.href = '{{url('text-informed-consents/delete')}}'+'/'+id;
                    } else {
                        return false;
                    }
                });

        });
    </script>
@endsection
