@extends('layouts.show')

@section('content')
    @component('components.history_2',['patient_id'=>$patient_id])
    @endcomponent


    @if ($errors->any())
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <div class="content-his mt-3">
        <form id="typesService" action="{{ route('infirmary-notes.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Nota de Enfermería</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Fecha de Nota:</strong>
                                <input type="text" name="date" class="form-control datetimepicker" autocomplete="off" required value="{{$value->date}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Nota:</strong>
                                <input type="text" name="hour" class="form-control clockpicker" required value="{{$value->hour}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-12 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Nota:</strong>
                                <textarea class="form-control" name="note" required rows="12">{{$value->note}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Observaciones:</strong>
                                <textarea class="form-control" name="observations" rows="12">{{$value->observations}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.min.js"></script>
    <script>
        $('.clockpicker').clockpicker({
            autoclose: false,
            donetext: 'Guardar',
        });
    </script>
@endsection
