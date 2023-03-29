@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'measurements','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('measurements.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Tabla de medidas</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>IMC Anterior:</strong>
                        <input type="text" class="form-control" value="{{$imc}}" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Peso Anterior:</strong>
                        <input type="text" class="form-control" value="{{$weight}}" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Altura:</strong>
                        <input type="text" class="form-control" value="{{$height}}" readonly>
                    </div>
                </div>
            </div>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>IMC actual:</strong>
                        <input type="text" name="imc" id="imc" class="form-control" value="0" readonly required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Peso actual:</strong>
                        <input type="text" name="weight" id="weight" value="0" class="form-control" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Busto:</strong>
                        <input type="text" name="bust" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Contorno:</strong>
                        <input type="text" name="contour" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Cintura:</strong>
                        <input type="text" name="waistline" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Umbilical:</strong>
                        <input type="text" name="umbilical" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>ABD Inferior:</strong>
                        <input type="text" name="abd_lower" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>ABD Superior:</strong>
                        <input type="text" name="abd_higher" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Cadera:</strong>
                        <input type="text" name="hip" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Piernas:</strong>
                        <input type="text" name="legs" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Muslo derecho:</strong>
                        <input type="text" name="right_thigh" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Muslo izquierdo:</strong>
                        <input type="text" name="left_thigh" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Brazo derecho:</strong>
                        <input type="text" name="right_arm" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Brazo izquierdo:</strong>
                        <input type="text" name="left_arm" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea name="observations" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
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
                        Ver Tabla de medidas anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Tabla de medidas anterior</h5>
                            <a href="{{url('measurements/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',4)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <h6>
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            IMC:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->imc}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Peso:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->weight}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Busto:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->bust}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Contorno:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->contour}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Cintura:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->waistline}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Umbilical:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->umbilical}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            ABD Inferior:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->abd_lower}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            ABD Superior:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->abd_higher}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Cadera:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->hip}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Piernas:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->legs}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Muslo derecho:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->right_thigh}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Muslo izquierdo:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->right_arm}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Brazo derecho:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->right_arm}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Brazo izquierdo:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->left_arm}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                    <div class="form-group">
                                        <h6>
                                            Observaciones:
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
    <script>
        var height = {{$height}};
        $(document).ready(function(){
            $("#weight").keypress(function(){
                calcularImc();
            });

            function calcularImc()
            {
                var weight = ($("#weight").val());
                var FirstValue = height * height;
                var total = weight / FirstValue;
                if(isNaN(total)){
                    total = 0;
                }
                if(total == 'Infinity'){
                    total = 0;
                }
                $("#imc").val(parseFloat(total).toFixed(1));
                /*
                setTimeout(function () {
                    calcularImc();
                },100)*/
            }
        });
    </script>
@endsection
