@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Tarea Asignada</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ Route('tasks.index') }}"> Atrás</a>
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


    <form id="typesService" action="{{ route('tasks.update',$task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Titulo:</strong>
                    <input value="{{$task->title}}" type="text" name="title" class="form-control" placeholder="" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Observacion:</strong>
                    <textarea name="comment" id="comment" class="form-control" required>{{$task->comment}}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Fecha:</strong>
                    <input value="{{$task->date}}" type="text" name="date" class="form-control datetimepicker" placeholder="" required>
                </div>
            </div>
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Estado:</strong>
                    <select name="status" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="activa" {{$task->status=='activa'?'selected':''}}>Activa</option>
                        <option value="gestionada" {{$task->status=='gestionada'?'selected':''}}>Gestionada</option>
                        <option value="vencida" {{$task->status=='vencida'?'selected':''}}>Vencida</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>


    </form>

@endsection

@section('script')
    <script>
        $('.datetimepicker').datetimepicker({
            locale: 'es',
            defaultDate: false,
            format: 'YYYY-MM-DD',
        })
    </script>
@endsection
