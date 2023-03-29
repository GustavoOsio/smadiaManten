@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="title-crud mb-3">
            <h2>Presupuesto de ventas</h2>
        </div>
        <div class="button-new">
            <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Crear</button>

        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif


<table class="table table-striped">
    <thead>
        <tr>
            <th>Año</th>
            <th>Mes</th>
            <th>meta global</th>
            <th>meta Mad</th>
            <th>meta Lipoval</th>
            <th>meta Post</th>
            <th>meta Cabinas</th>
            <th>meta Suero</th>
            <th>meta valoraciones</th>
            <th>meta depilación</th>
            <th>meta Otros</th>
            <th>accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $productos)

        @php
        if($productos->mes == "01"){
        $mes="Enero";
        } elseif($productos->mes == "02"){
        $mes="Febrero";
        }elseif($productos->mes == "03"){
        $mes="Marzo";
        }elseif($productos->mes == "04"){
        $mes="Abril";
        }elseif($productos->mes == "05"){
        $mes="Mayo";
        }elseif($productos->mes == "06"){
        $mes="Junio";
        }elseif($productos->mes == "07"){
        $mes="Julio";
        }elseif($productos->mes == "08"){
        $mes="Agosto";
        }elseif($productos->mes == "09"){
        $mes="Septiembre";
        }elseif($productos->mes == "10"){
        $mes="Octubre";
        }elseif($productos->mes == "11"){
        $mes="Noviembre";
        }elseif($productos->mes == "12"){
        $mes="Diciembre";
        }
        @endphp
        <tr>
            <td>2022</td>
            <td>{{ $mes}}</td>
            <td>{{ number_format($productos->metaTotal) }}</td>
            <td>{{ number_format($productos->metaMad) }}</td>
            <td>{{ number_format($productos->metaLipoval) }}</td>
            <td>{{ number_format($productos->metaPost) }}</td>
            <td>{{ number_format($productos->metaCabinas) }}</td>
            <td>{{ number_format($productos->metaSuero) }}</td>
            <td>{{ number_format($productos->metaValoraciones) }}</td>
            <td>{{ number_format($productos->metaDepilacion) }}</td>
            <td>{{ number_format($productos->metaOtros) }}</td>
            <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#modalEditarpre" id="editar-presupuesto" data-id="{{$productos->idPresupuesto}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- inicio de modal que crea el presupuesto de venta  -->
<div class="modal fade" id="ModalExport" tabindex="-1" role="dialog" aria-labelledby="exampleModalExportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalReceiptTitle">Guardar presupuesto de venta </h5>
                <input type="hidden" id="destination">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmExport">
                <div class="modal-body">
                    <input type="hidden" name="url" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Escoger mes:</strong>
                                <select name="mesfiltro" id="mesfiltro" class="form-control">
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta global:</strong>
                                <input type="text" class="form-control" id="metaGlobal" name="metaGlobal" placeholder="meta global">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Mad:</strong>
                                <input type="text" class="form-control" name="metaMad" id="metaMad" placeholder="Mad laser">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Lipoval:</strong>
                                <input type="text" class="form-control" name="Lipoval" id="Lipoval" placeholder="Lipoval">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Post:</strong>
                                <input type="text" class="form-control" name="Post" id="Post" placeholder="Post">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Cabinas:</strong>
                                <input type="text" class="form-control" name="cabinas" id="cabinas" placeholder="Cabinas">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Suero:</strong>
                                <input type="text" class="form-control" name="suero" id="suero" placeholder="Suero">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta valoraciones:</strong>
                                <input type="text" class="form-control" name="valoracion" id="valoracion" placeholder="valoraciones">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta depilación:</strong>
                                <input type="text" class="form-control" name="depilacion" id="depilacion" placeholder="depilación">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Otros:</strong>
                                <input type="text" class="form-control" name="otros" id="otros" placeholder="Otros">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Cantidad dias habiles del mes:</strong>
                                <input type="text" class="form-control" name="d_habiles" id="d_habiles" placeholder="Digite dias habiles">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cerrar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarComision">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin de modal que crea los presupuestos de ventas  -->
<!-- inicio de modal que edita el presupuesto -->
<div class="modal fade" id="modalEditarpre" tabindex="-1" role="dialog" aria-labelledby="exampleModalExportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalReceiptTitle">Editar presupuesto de venta </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmExport">
                <div class="modal-body">
                    <input type="hidden" name="url" value="">
                    <div class="row">
                        <input type="hidden" id="edt_idPresupuesto">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Escoger mes:</strong>
                                <select name="edt_mesfiltro" id="edt_mesfiltro" class="form-control">
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta global:</strong>
                                <input type="text" class="form-control" id="edt_metaGlobal" name="edt_metaGlobal" placeholder="meta global">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Mad:</strong>
                                <input type="text" class="form-control" name="edt_metaMad" id="edt_metaMad" placeholder="Mad laser">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Lipoval:</strong>
                                <input type="text" class="form-control" name="edt_Lipoval" id="edt_Lipoval" placeholder="Lipoval">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Post:</strong>
                                <input type="text" class="form-control" name="edt_Post" id="edt_Post" placeholder="Post">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Cabinas:</strong>
                                <input type="text" class="form-control" name="edt_cabinas" id="edt_cabinas" placeholder="Cabinas">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Suero:</strong>
                                <input type="text" class="form-control" name="edt_suero" id="edt_suero" placeholder="Suero">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta valoraciones:</strong>
                                <input type="text" class="form-control" name="edt_valoracion" id="edt_valoracion" placeholder="valoraciones">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta depilación:</strong>
                                <input type="text" class="form-control" name="edt_depilacion" id="edt_depilacion" placeholder="depilación">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Digite meta Otros:</strong>
                                <input type="text" class="form-control" name="edt_otros" id="edt_otros" placeholder="Otros">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Cantidad dias habiles del mes:</strong>
                                <input type="text" class="form-control" name="edt_d_habiles" id="edt_d_habiles" placeholder="Digite dias habiles">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cerrar_edt" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="edt_guardarComision">modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin del modal que edita el presupuesto -->
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

@endsection