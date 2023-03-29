@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'medical-evolutions','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('medical-evolutions.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Evolución médica</p>
            <div class="line-form"></div>
            <!-- Modal -->
            <!--
            <div class="modal fade" id="measurementTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tabla de medidas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Peso</td>
                                    <td>{{$weight}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Busto</td>
                                    <td>{{$bust}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Contorno</td>
                                    <td>{{$contour}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Cintura</td>
                                    <td>{{$waistline}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Umbilical</td>
                                    <td>{{$umbilical}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>ABD Inferior</td>
                                    <td>{{$abd_lower}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>ABD Superior</td>
                                    <td>{{$abd_higher}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">8</th>
                                    <td>Cadera</td>
                                    <td>{{$hip}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">9</th>
                                    <td>Piernas</td>
                                    <td>{{$legs}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">10</th>
                                    <td>Muslo Derecho	</td>
                                    <td>{{$right_thigh}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">11</th>
                                    <td>Muslo Izquierdo</td>
                                    <td>{{$left_thigh}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">12</th>
                                    <td>Brazo Derecho</td>
                                    <td>{{$right_arm}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">13</th>
                                    <td>Brazo Izquierdo</td>
                                    <td>{{$left_arm}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <!--
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>IMC:</strong>
                                <input type="text" name="name" value="{{$imc}}" class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 margin-tb mt-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#measurementTable">Tabla de medidas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-10">
                            <div class="form-group">
                                <strong>Evolución Medica:</strong>
                                <textarea name="observations" class="form-control" rows="15" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-6 margin-tb">
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
                        Ver evolución médica anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                Evolución médica anterior
                            </h5>
                            <a href="{{url('medical-evolutions/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',9)
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
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                    <div class="form-group">
                                        <h6>
                                            Evolución Medica:
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

    <style>
        table tr{
            line-height: 0.6 !important;
        }
    </style>
@endsection
