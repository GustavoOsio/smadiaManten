@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="title-crud">
            <h2>Crear Comisiones</h2>
        </div>
        <div class="button-new">
            <a class="btn btn-primary" href="{{url ('/MetaLineaServicio') }}"> Atrás</a>
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


<div class="separator"></div>
<p class="title-form">Rellenar</p>
<div class="line-form"></div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
        <div class="form-group">
            <strong>Escoger linea de servicio:</strong>
            <select type="text" name="servicio" id="servicio" class="form-control" required>
                <option value="" selected>Seleccione linea de servicio</option>
                @foreach ($serviciosDisponibles as $serviciosDisponibles)
                <option value="{{$serviciosDisponibles->id}}">{{$serviciosDisponibles->name}}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
        <div class="form-group">
            <strong>Meta mensual:</strong>
            <input value="" type="number" value="0" name="meta-service" id="meta-service" class="form-control" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
        <div class="form-group">
            <strong>Estado:</strong>
            <select name="estado-service" class="form-control" id="estado-service">
                <option value="">Seleccione estado</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
        <div class="form-group">
            <strong>Escoger mes:</strong>
            <select type="text" name="mes-servicio" id="mes-servicio" class="form-control" required>
                <option value="" selected>Seleccione mes</option>
                @foreach ($meses as $mes)
                <option value="{{$mes->mes}}">{{$mes->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
        <div class="form-group">
            <button style="margin-top: 15px;" id="btn_save_meta_service" class="btn btn-outline-success">Guardar</button>
        </div>
    </div>

</div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align: center;">Linea de Servicio</th>
                        <th style="text-align: center;">Meta</th>
                        <th style="text-align: center;">Mes</th>
                        <th style="text-align: center;">Acion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($MetasCreadas as $MetasCreadas)
                    <tr>

                        <td style="text-align: center;">{{$MetasCreadas->servicio_meta[0]->name}}</td>
                        <td style="text-align: center;">{{$MetasCreadas->meta}}</td>
                        <td style="text-align: center;">{{$MetasCreadas->mes_meta[0]->nombre}}</td>

                        <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#modalEditarmetaLinea" id="editar-meta-linea" data-id="{{$MetasCreadas->id}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
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
<!-- Modal -->
<div class="modal fade" id="modalEditarmetaLinea" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar meta linea de servicio</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="id_meta">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <strong>Escoger linea de servicio:</strong>
                            <select type="text" name="editar-servicio" id="editar-servicio" class="form-control" required>
                                <option value="" selected>Seleccione linea de servicio</option>
                                @foreach ($selectService as $serviciosDisponibles)
                                <option value="{{$serviciosDisponibles->id}}">{{$serviciosDisponibles->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <strong>Meta mensual:</strong>
                            <input value="" type="number" value="0" name="editar-meta-service" id="editar-meta-service" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <strong>Escoger mes:</strong>
                            <select type="text" name="editar-mes-servicio" id="editar-mes-servicio" class="form-control" required>
                                <option value="" selected>Seleccione mes</option>
                                @foreach ($meseselect as $mes)
                                <option value="{{$mes->mes}}">{{$mes->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <strong>Estado:</strong>
                            <select name="editar-estado-service" class="form-control" id="editar-estado-service">
                                <option value="">Seleccione estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="guardar-Edit-meta-linea">Modificar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection