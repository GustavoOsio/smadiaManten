@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'surgery-expenses-sheet','patient_id'=>$patient_id])
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
    @if ($message = Session::get('error'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <div class="content-his mt-3">
        <form id="typesService" action="{{ route('surgery-expenses-sheet.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Hoja de Gastos de Cirugía</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Fecha de Cirugia:</strong>
                                <input type="text" name="date_of_surgery" class="form-control datetimepicker" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Sala:</strong>
                                <input type="text" name="room" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Peso:</strong>
                                <input type="text" name="weight" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Tipo de Paciente :</strong>
                                <select name="type_patient" id="type_patient" class="form-control" required>
                                    <option value="">seleccione</option>
                                    <option value="ambulatorio">Ambulatorio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Tipo de Anestesia:</strong>
                                <select name="type_anesthesia" id="type_anesthesia" class="form-control" required>
                                    <option value="">seleccione</option>
                                    <option value="eridural">Peridural</option>
                                    <option value="local">Local</option>
                                    <option value="raquidea">Raquídea</option>
                                    <option value="general">General</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Tipo de Cirugia :</strong>
                                <select name="type_surgery" id="type_surgery" class="form-control" required>
                                    <option value="">seleccione</option>
                                    <option value="unica">Única</option>
                                    <option value="bilateral">Bilateral</option>
                                    <option value="multiple">Multiple</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Cirugia:</strong>
                                <input type="text" name="surgery" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Código de Cirugia:</strong>
                                <input type="text" name="surgery_code" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Ingreso:</strong>
                                <input type="text" name="time_entry" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Inicio de Cirugia :</strong>
                                <input type="text" name="start_time_surgery" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Final de Cirugia:</strong>
                                <input type="text" name="end_time_surgery" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Cirujano:</strong>
                                <select name="surgeon" id="surgeon" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($surgery as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Ayudante:</strong>
                                <input type="text" name="assistant" class="form-control">
                                <!--
                                <select name="assistant" id="assistant" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($assistant as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Anestesiologo:</strong>
                                <input type="text" name="anesthesiologist" class="form-control">
                                <!--
                                <select name="anesthesiologist" id="anesthesiologist" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($anesthesiologist as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Rotadora:</strong>
                                <input type="text" name="rotary" class="form-control">
                                <!--
                                <select name="rotary" id="rotary" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($rotary as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Instrumentadora:</strong>
                                <input type="text" name="instrument" class="form-control">
                                <!--
                                <select name="instrument" id="instrument" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($instrument as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line-form"></div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong></strong>
                                <input type="hidden" name="numberList" id="numberList" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-md-3 margin-tb">
                        <div class="title-crud" style="border: 0; text-align: center; float: none">
                            <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Producto</h4>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <div class="expenses-add">
                <div class="form-expenses">
                    <div class="row">
                        @php
                            $validate = true;
                        @endphp
                        @forelse($inventory as $key => $i)
                            @if($i->cant > 0)
                                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                    <div class="row justify-content-md-center">
                                        <div class="col-lg-1 margin-tb">
                                            <div class="form-group">
                                                <strong>Codigo:</strong>
                                                <input value="{{$i->product->reference}}" type="text" name="code{{$key+1}}" id="code{{$key+1}}" class="form-control" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 margin-tb">
                                            <div class="form-group">
                                                <strong>Producto:</strong>
                                                <select name="product[]" id="product{{$key+1}}" class="form-control" required>
                                                    <option value="{{$i->product->id}}">
                                                        {{$i->product->name}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 margin-tb">
                                            <div class="form-group">
                                                <strong>Cant:</strong>
                                                <input onkeypress="return soloNumeros(event);" value="0" type="number" min="0" name="cant[]" id="cant{{$key+1}}" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 margin-tb">
                                            <div class="form-group">
                                                <strong>Cant. Disponible:</strong>
                                                <input value="{{number_format($i->cant,0)}}" type="number" name="cantD{{$key+1}}" id="cantD{{$key+1}}" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            @php
                                $validate = false;
                            @endphp
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="row justify-content-md-center">
                                    <h1 class="title-form">
                                        No hay productos en tu inventario personal
                                    </h1>
                                </div>
                            </div>
                        @endforelse
                        <!--
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-1 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Codigo:</strong>
                                        <input type="text" name="code1" id="code1" class="form-control" required readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Producto:</strong>
                                        <select name="product1" id="product1" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($products as $key => $pro)
                                                <option value="{{$pro->id}}" code="{{$pro->reference}}" lote="{{$pro->category->name}}" presentation="{{$pro->presentation->name}}" medid="{{$pro->unit->name}}">{{$pro->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Lote:</strong>
                                        <input type="text" name="lote1" id="lote1" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs col-sm-12 col-md-12 mt3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Presentación:</strong>
                                        <input type="text" name="presentation1" id="presentation1" class="form-control" required readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Unidad de Medida:</strong>
                                        <input type="text" name="medid1" id="medid1" class="form-control" required readonly>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Cant:</strong>
                                        <input type="number" name="cant1" id="cant1" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        --->
                    </div>
                </div>
            </div>

            @if($validate)
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                        <div class="row justify-content-md-center">
                            <div class="col-lg-2 col-md-3 margin-tb">
                                <button type="submit" class="btn btn-primary w-100">Crear</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </form>
    </div>

    @if(!empty($idBefore))
        <div class="mt-3" style="margin: 0 auto; width: 95%">
            <div class="row justify-content-md-center">
                <div class="col-md-12 margin-tb">
                    <button type="button" class="btn btn-primary w-100" idtarget="{{$idBefore->id}}" idtype="1" data-toggle="modal" data-target="#Modal">
                        Ver Hoja de Gastos de Cirugía anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Hoja de Gastos de Cirugía anterior</h5>
                            <!--
                            <a href="{{url('surgery-expenses-sheet/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                            -->
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',14)
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
                                            Fecha de Cirugia:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->date_of_surgery}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-1">
                                    <div class="form-group">
                                        <h6>
                                            Sala:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->room}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-1">
                                    <div class="form-group">
                                        <h6>
                                            Peso:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->weight}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Tipo de Paciente:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->type_patient}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Tipo de Anestesia:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->type_anesthesia}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Tipo de Cirugia :
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->type_surgery}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Cirugia::
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->surgery}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Código de Cirugia:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->surgery_code}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Hora de Ingreso:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->time_entry}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Hora de Inicio de Cirugia :
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->start_time_surgery}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Hora de Final de Cirugia:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->end_time_surgery}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Cirujano:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->surgeon}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Ayudante:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->assistant}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Anestesiologo:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->anesthesiologist}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Rotadora:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->rotary}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Instrumentadora:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->instrument}}">
                                    </div>
                                </div>
                            </div>
                            @foreach($relation as $rel)
                                <div class="line-form"></div>
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-2 margin-tb">
                                        <div class="form-group">
                                            <strong>Codigo:</strong>
                                            <input value="{{$rel->code}}" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 margin-tb">
                                        <div class="form-group">
                                            <strong>Producto:</strong>
                                            <input value="{{$rel->product}}" type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 margin-tb">
                                        <div class="form-group">
                                            <strong>Cant:</strong>
                                            <input value="{{$rel->cant}}" type="number" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                        <div class="form-group">
                                            <h6>
                                                Codigo
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->code}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>
                                                Producto
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->product}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <h6>
                                                Lote:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->lote}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>
                                                Presentación:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->presentation}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>
                                                Unidad de Medida:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->medid}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                        <div class="form-group">
                                            <h6>
                                                Cant:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->cant}}">
                                        </div>
                                    </div>
                                </div>
                                -->
                            @endforeach
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
    <style>
        .expenses-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>

    <script>
        var optionProduct = ''
    </script>
    @foreach($products as $key => $pro)
        <script>
            optionProduct = optionProduct + '<option value="{{$pro->id}}" code="{{$pro->reference}}" lote="{{$pro->category->name}}" presentation="{{$pro->presentation->name}}" medid="{{$pro->unit->name}}">{{$pro->name}}</option>'
        </script>
    @endforeach
    <script>
        $('select').change(function () {
            idSelect = this.id;
            idSelect = idSelect.replace('product','');
            $('#code'+idSelect).val($('#product'+idSelect+' option:selected').attr('code'));
            $('#lote'+idSelect).val($('#product'+idSelect+' option:selected').attr('lote'));
            $('#presentation'+idSelect).val($('#product'+idSelect+' option:selected').attr('presentation'));
            $('#medid'+idSelect).val($('#product'+idSelect+' option:selected').attr('medid'));
        });
        function changeVector(id)
        {
            idSelect = id;
            $('#code'+idSelect).val($('#product'+idSelect+' option:selected').attr('code'));
            $('#lote'+idSelect).val($('#product'+idSelect+' option:selected').attr('lote'));
            $('#presentation'+idSelect).val($('#product'+idSelect+' option:selected').attr('presentation'));
            $('#medid'+idSelect).val($('#product'+idSelect+' option:selected').attr('medid'));
        }

        var numberList = 1,idDelete= 1,arv=1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        scriptAr[1] = "si";
        arv = scriptAr.toString();
        $('#numberList').val(arv);
        function deleteNew(id){
            idDelete = id;
            $('.form-expenses'+idDelete).remove();
            //numberList = numberList - 1;
            scriptAr[id] = "no";
            arv = scriptAr.toString();
            $('#numberList').val(arv);
        }
        $( document ).ready(function() {
            $('.deleteNew').click(function () {
            });
            $('#add-new').click(function () {
                numberList = numberList + 1;
                scriptAr[numberList] = "si";
                arv = scriptAr.toString();
                $('#numberList').val(arv);
                $('.expenses-add').append('' +
                    '               <div class="form-expenses'+numberList+'">\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-4 col-md-3 margin-tb">\n' +
                    '                                    <div class="title-crud" style="border: 0; text-align: center; float: none">\n' +
                    '                                        <h4 class="deleteNew" onclick="deleteNew('+numberList+');" id="'+numberList+'"><i class="fas fa-trash-alt"></i> Eliminar</h4>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n'+
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-1 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Codigo:</strong>\n' +
                    '                                        <input type="text" name="code'+numberList+'"  id="code'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-4 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Producto:</strong>\n' +
                    '                                        <select onchange="changeVector('+numberList+');" name="product'+numberList+'" id="product'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProduct +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Lote:</strong>\n' +
                    '                                        <input type="text" name="lote'+numberList+'"  id="lote'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                        <div class="col-xs col-sm-12 col-md-12 mt3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Presentación:</strong>\n' +
                    '                                        <input type="text" name="presentation'+numberList+'"  id="presentation'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Unidad de Medida:</strong>\n' +
                    '                                        <input type="text" name="medid'+numberList+'" id="medid'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-1 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Cant:</strong>\n' +
                    '                                        <input type="number" name="cant'+numberList+'" id="cant'+numberList+'" class="form-control" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');
            });
        });
    </script>
@endsection
