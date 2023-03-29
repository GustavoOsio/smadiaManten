@extends('layouts.app')

@section('content')
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form id="frmIncident" method="POST">
                @csrf
                <input type="hidden" name="monitoring_id" value="{{ $monitoring->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Incidente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="date" class="form-control" placeholder="Fecha de acción" id="date" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="responsable_id" class="form-control" required>
                                        <option value="">Seleccione el responsable</option>
                                        @foreach($users as $u)
                                            @if ($u->id === \Illuminate\Support\Facades\Auth::id())
                                                <option selected value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                            @else
                                                <option value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="comment" rows="4" class="form-control" placeholder="Observaciones" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="ModalClose" tabindex="-1" role="dialog" aria-labelledby="exampleModalCloseTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form id="frmMonitoringClose" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $monitoring->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCloseTitle">Cerrar Seguimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    @php
                                        $dateToday = date("Y-m-d");
                                    @endphp
                                    <input type="text" name="date_close" class="form-control" value="{{$dateToday}}" placeholder="Fecha de acción" id="date-close-no" required readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="comment_close" rows="4" minlength="4" class="form-control" placeholder="Observaciones" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form id="frmMoni">
        @csrf
        <input type="hidden" name="id" value="{{ $monitoring->id }}">
        <div class="row mb-4">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud">
                    <h2>Seguimiento S-{{ $monitoring->id }}</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
                </div>
            </div>
        </div>

        <div class="separator"></div>
        <p class="title-form">Datos</p>
        <div class="line-form"></div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Paciente</th>
                <th class="fl-ignore">Cédula</th>
                <th class="fl-ignore">Celular</th>
                <th class="fl-ignore">Tema</th>
                <th class="fl-ignore">Estado</th>
                <th class="fl-ignore">Fecha de acción</th>
                <th class="fl-ignore">Fecha creación</th>
                <th class="fl-ignore">Responsable</th>
                <th class="fl-ignore">Elaborado por</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ ucwords(mb_strtolower($monitoring->patient->name . " " . $monitoring->patient->lastname, "UTF-8")) }}</td>
                <td>{{ $monitoring->patient->identy }}</td>
                <td>{{ $monitoring->patient->cellphone }}</td>
                <td>{{ $monitoring->issue->name }}</td>
                <td>{{ ucfirst($monitoring->status) }}</td>
                <td>{{ date("Y-m-d", strtotime($monitoring->date)) }}</td>
                <td>{{ date("Y-m-d h:i a", strtotime($monitoring->created_at)) }}</td>
                <td>{{ ucwords(mb_strtolower($monitoring->responsable->name . " " . $monitoring->responsable->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($monitoring->user->name . " " . $monitoring->user->lastname)) }}</td>
            </tr>
            </tbody>
        </table>

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Observaciones</th>
                @if ($monitoring->status == "cerrado")
                    <th class="fl-ignore">Responsable de cierre</th>
                    <th class="fl-ignore">Fecha de cierre</th>
                    <th class="fl-ignore">Observaciones de cierre</th>
                @endif
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $monitoring->comment }}</td>
                @if ($monitoring->status == "cerrado")
                    <td>{{$monitoring->close->name}} {{$monitoring->close->lastname}}</td>
                    <td>{{ date("Y-m-d", strtotime($monitoring->date_close)) }}</td>
                    <td>{{ $monitoring->comment_close }}</td>
                @endif
            </tr>
            </tbody>
        </table>
        @php
            $id = App\User::find(Auth::id());
        @endphp
        @if ($monitoring->responsable_id == \Illuminate\Support\Facades\Auth::id() || $id->role->superadmin == 1)
            @if($monitoring->status != "cerrado")
                <div class="row justify-content-md-center mt-5">
                    <div class="col-md-3">
                        <a class="btn btn-primary w-100" data-toggle="modal" data-target="#ModalClose" href="#">
                            <span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Cerrar seguimiento
                        </a>
                    </div>
                </div>
            @endif
        @endif
        <div class="separator"></div>
        <p class="title-form">Incidentes realizados</p>
        <div class="line-form"></div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Fecha de acción</th>
                <th class="fl-ignore">Responsable</th>
                <th class="fl-ignore">Elaborador por</th>
                <th class="fl-ignore">Observaciones</th>
                <th class="fl-ignore">Fecha creación</th>
            </tr>
            </thead>
            <tbody>
            @forelse($monitoring->incidents as $i)
                <tr>
                    <td>{{ date("Y-m-d", strtotime($i->date)) }}</td>
                    <td>{{ ucwords(mb_strtolower($i->responsable->name . " " . $i->responsable->lastname, "UTF-8")) }}</td>
                    <td>{{ ucwords(mb_strtolower($i->user->name . " " . $i->user->lastname, "UTF-8")) }}</td>
                    <td>{{ $i->comment }}</td>
                    <td>{{ date("Y-m-d h:i a", strtotime($i->created_at)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">No hay incidentes registrados</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($monitoring->status != "cerrado")
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-3">
                <a class="btn btn-primary w-100" data-toggle="modal" data-target="#ModalCenter" href="#">
                    <span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear Incidente
                </a>
            </div>
        </div>
        @endif
    </form>
@endsection
