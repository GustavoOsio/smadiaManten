@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="title-crud">
            <h2>Crear Metas por medicos</h2>
        </div>
        <div class="button-new">
            <a class="btn btn-primary" href="{{ route('comisionesMedicas.index') }}"> Atrás</a>
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

<form>
    @csrf
    <div class="separator"></div>
    <p class="title-form">Rellenar</p>
    <div class="line-form"></div>
    <div class="container justify-content-md-right">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Escoger medico:</strong>
                    <select type="text" name="medico" id="medico" class="form-control" required>
                        <option value="" selected>Seleccione medico</option>
                        @foreach ($medicos as $medicos)
                        <option value="{{$medicos->id}}">{{$medicos->title}} {{$medicos->name}} {{$medicos->lastname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Meta mensual:</strong>
                    <input value="" type="number" value="0" name="metaMensual" id="metaMensual" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Escoger mes:</strong>
                    <select type="text" name="mes" id="mes" class="form-control" required>
                        <option value="" selected>Seleccione mes</option>
                        @foreach ($meses as $mes)
                        <option value="{{$mes->mes}}">{{$mes->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Estado :</strong>
                    <select class="form-control" name="status" id="status">
                        <option value="">Seleccione</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-right">
                    <div class="col-lg-7 col-md-9 margin-tb">
                        <div class="form-group">
                            <strong></strong>
                            <input type="hidden" name="numberList" id="numberList" class="form-control" readonly required>
                            <input type="hidden" name="numberList1" id="numberList1" class="form-control" readonly required>
                            <button type="button" id="guardar-meta" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="expenses-add1">
        <div class="form-expensesProd">
            <div class="row">

                <p class="title-form">Tabla de metas</p>
                <div class="line-form"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Medico</th>
                                    <th style="text-align: center;">Meta</th>
                                    <th style="text-align: center;">Mes</th>
                                    <th style="text-align: center;">Accion</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($metas as $meta)

                                <tr>
                                    <td style="text-align: center;">{{$meta->medico_meta[0]->title}} {{$meta->medico_meta[0]->name}} {{$meta->medico_meta[0]->lastname}}</td>
                                    <td style="text-align: center;">{{number_format($meta->meta_mes, 0, ',', '.')}}</td>
                                    <td style="text-align: center;">{{$meta->mes_meta[0]->nombre}}</td>
                                    <td style="text-align: center;"><a href="#" id="edt_meta" data-toggle="modal" data-target="#modal_edt_meta" data-id="{{$meta->id_tbl_metaMedico}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg></a></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="modal_edt_meta" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="id_meta" name="id_meta" class="form-control">
                        <select type="text" name="edt_medico" id="edt_medico" class="form-control" required>
                            <option value="" selected>Seleccione medico</option>
                            @foreach($med as $med)
                            <option value="{{$med->id}}">{{$med->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="edt_metaMensual" name="edt_metaMensual" placeholder="Valor de la meta">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <select name="edt_mes" id="edt_mes" class="form-control">
                            <option value="" selected>Seleccione mes</option>
                            @foreach ($meses as $mes)
                            <option value="{{$mes->mes}}">{{$mes->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="edt_estado" id="edt_estado" class="form-control">
                            <option value="" selected>Seleccione estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="guardarModificacionMeta">Modificar</button>
            </div>
        </div>

    </div>
</div>

</div>

@endsection