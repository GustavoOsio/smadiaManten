@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'infirmary-notes','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('infirmary-notes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Notas de Enfermería</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        @php
                            date_default_timezone_set('America/Bogota');
                            $dateToday = date("Y-m-d");
                            $hora = date('G:i')
                        @endphp
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Fecha de Nota:</strong>
                                <input value="{{$dateToday}}" type="text" name="date" class="form-control datetimepicker" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Nota:</strong>
                                <input value="{{$hora}}" type="text" name="hour" class="form-control clockpicker" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-12 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Nota:</strong>
                                <textarea class="form-control" name="note" required rows="12"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Observaciones:</strong>
                                <textarea class="form-control" name="observations" rows="12"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <button type="submit" class="btn btn-primary w-100">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if(!empty($idBefore))
        <div class="mt-3" style="margin: 0 auto; width: 95%">
            <div class="row justify-content-md-center">
                <div class="col-md-12 margin-tb">
                    <button type="button" class="btn btn-primary w-100" idtarget="{{$idBefore->id}}" idtype="1" data-toggle="modal" data-target="#Modal">
                        Ver Notas de Enfermería anterior
                    </button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <form id="frmMonitoring" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Notas de Enfermería anterior</h5>
                            <a href="{{url('infirmary-notes/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',15)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <h6>
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Fecha de Nota:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->date}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Hora de Nota:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->hour}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                                    <div class="form-group">
                                        <h6>
                                            Nota
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->note}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                                    <div class="form-group">
                                        <h6>
                                            Observaciones
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <style>
        .modal form{
            width: 100%;
        }
        .modal .modal-lg{
            /*width: 1000px;*/
            max-width: 1000px;
        }
    </style>
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
