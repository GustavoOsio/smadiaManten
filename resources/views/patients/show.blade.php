@extends('layouts.show')
@section('style')
    <style>
        .icon-print-02:before {
            color: #fb8e8e;
            font-size: 16pt;
        }
        /*
        .totalPending{
            background: #06E384;
        }
        .totalBalance{
            background: #EB5959;
        }
         */
        .totalSalmon{
            /*background: #eb7e1a;*/
            background: url("{{asset('/img/income-01.svg')}}") no-repeat;
        }
        .editMoneyBox:hover{
            cursor: pointer;
        }
        .totalMoneyBox{
            position: fixed;
            bottom: 5px;
            right: 24%;
            z-index: 2;
            width: 171px;
            height: 53px;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 12pt;
            letter-spacing: 1px;
            padding: .35rem 2rem;
            background: url("{{asset('/img/income-02.svg')}}") no-repeat;
        }
        .totalMoneyBox p{
            font-size: 9pt;
            font-weight: 400;
        }
    </style>
@endsection
@section('content')
    @if($balance <= 0)
        @php
            //$balance = 0
        @endphp
    @endif
    @if($pending <= 0)
        @php
            $pending = 0
        @endphp
    @endif
    @if($moneyBox <= 0)
        @php
            $moneyBox = 0
        @endphp
    @endif
    <div class="totalMoneyBox"><p>Dinero en caja</p>$ {{ number_format($moneyBox, 0) }}</div>
    <div class="totalPending {{$balance <= 0?'totalSalmon':''}}"><p>Saldo disponible</p>$ {{ number_format($balance, 0) }}</div>
    <div class="totalBalance"><p>Saldo pendiente</p>$ {{ number_format($pending, 0) }}</div>
    <div class="modal fade" id="ModalReceipt" tabindex="-1" role="dialog" aria-labelledby="exampleModalReceiptTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalReceiptTitle">Tomar foto</h5>
                    <input type="hidden" id="destination">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="capture">
                        <div class="capture__frame">
                            <div id="camera"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="take_snapshot()">Capturar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form id="frmMonitoring" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Seguimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 contract_validate_2">
                                <div class="form-group">
                                    <select style="width: 100% !important;" name="contract_id" id="contract_validate_id_2" class="form-control">
                                        <option value="">Seleccione el contrato</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <input type="hidden" name="patient_id" id="patient_id" value="{{ $patient->id }}">
                                    <input type="hidden" name="schedule_id" id="schedule_id">
                                    <input type="hidden" name="status_schedule" id="status_schedule">
                                    <input type="text" name="date" class="form-control" placeholder="Fecha de acción" id="date" required>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="issue_id" class="form-control" required>
                                        <option value="">Seleccione el tema</option>
                                        @foreach($issues as $i)
                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="responsable_id" class="form-control" required>
                                        <option value="">Seleccione el responsable</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="comment" rows="4" class="form-control" placeholder="Observaciones"></textarea>
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
    <div class="cont-show d-flex justify-content-between">
        <div class="cont-show__left">
            <div class="cont-show__content">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="title-crud pl-2">
                            <h2 class="float-left">
                                Paciente #{{$patient->id}} en sala
                            </h2>
                            <input type="hidden" name="status" value="{{ ($in_room) ? "activo" : "inactivo" }}" class="inRoom">
                            <button type="button" class="btn btn-sm btn-toggle float-left mt-2 status @if ($in_room) active @endif" data-toggle="button" aria-pressed="{{ ($in_room) ? "true" : "false" }}" autocomplete="off">
                                <div class="handle"></div>
                            </button>
                        </div>
                        <div class="button-new">
                            <a class="btn btn-primary" href="{{ route('patients.index') }}"> Atrás</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4"></div>
            <div class="cont-show__content">
                <div class="cont-show__img">
                    @php $sw = false @endphp
                    @foreach($patient->schedules as $sh)
                        @if ($sh->status == "completada")
                            @php $sw = true @endphp
                        @endif
                    @endforeach
                    @if (!$sw) <img class="cont-show__img__new" src="{{ asset("img/new-02.png") }}" alt="nuevo"> @endif
                    <img class="cont-show__img__profile" src="{{ asset(($patient->photo != "") ? $patient->photo : "profile") }}" alt="profile">
                </div>
                <div class="cont-show__rol">{{ $patient->name . " " . $patient->lastname }}</div>
                <div class="cont-show__active">{{ ucfirst($patient->status) }} {!! ($patient->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</div>
                <div class="cont-show__info">
                    <div>C.C:</div><div>{{ $patient->identy }}</div>
                    <div>F. Nacimiento:</div><div>{{ $patient->birthday }}</div>
                    <div>Edad:</div><div>
                        @php
                            $cumpleanos = new DateTime($patient->birthday);
                            $hoy = new DateTime();
                            $annos = $hoy->diff($cumpleanos);
                            print $annos->y;
                        @endphp
                    </div>
                    <div>Género:</div><div>{{ ($patient->gender) ? $patient->gender->name : "" }}</div>
                    <div>Estado civil:</div><div>{{ ($patient->civil) ? $patient->civil->name : "" }}</div>
                    <div>Ciudad:</div><div>{{ ($patient->city) ? $patient->city->name : "" }}</div>
                    <div>Dirección:</div><div>{{ $patient->address }}</div>
                    <div>Barrio:</div><div>{{ $patient->urbanization }}</div>
                    <div>E-mail:</div><div>{{ $patient->email }}</div>
                    <div>Teléfono:</div><div>{{ $patient->phone }}</div>
                    <div>Celular:</div><div>{{ $patient->cellphone }}</div>
                    <div>Ocupación:</div><div>{{ $patient->ocupation }}</div>
                    <div>EPS:</div><div>{{ ($patient->eps) ? $patient->eps->name : "" }}</div>
                    <div>Tipo de vinculación:</div><div>{{ $patient->linkage }}</div>
                    <div>Tratamiento de interés:</div><div>
                        @if($patient->service != '')
                            {{ $patient->service->name }}
                        @endif
                    </div>
                    <div>Fuente de contacto:</div><div>{{ ($patient->contact != '')?$patient->contact->name:'' }}</div>
                    <div>Activo</div><div></div>
                    <div>{{ $referer }}</div><div></div>
                    <div>Creado por:</div>
                    <div>{{ $patient->creator->name . " " . $patient->creator->lastname }}</div>
                    <div>Observaciones:</div><div></div>
                    <div style="max-width: 100%;flex: 0 0 100%;-webkit-flex: 0 0 100%;-ms-flex: 0 0 100%;">
                        {{ $patient->observations }}
                    </div>
                </div>
                <div class="cont-show__relations">Información acompañante</div>
                <div class="cont-show__info">
                    <div>Nombre:</div><div>{{ $patient->f_name }}</div>
                    <div>Celular:</div><div>{{ $patient->f_phone }}</div>
                    <div>Parentesco:</div><div>{{ $patient->f_relationship }}</div>
                </div>
                <a href="{{ route('patients.edit',$patient->id) }}">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="cont-show__right">
            <div class="cont-show__content">
                <ul class="nav nav-tabs tabs-patiens" role="tablist">
                    @can('view', \App\Models\Schedule::class)
                        <li class="nav-item">
                            <a id="dates" class="nav-link active" href="#citas" role="tab" data-toggle="tab">Citas</a>
                        </li>
                    @endcan
                    @can('view', \App\Models\Contract::class)
                        <li class="nav-item">
                            <a id="contracts" class="nav-link" href="#contratos" role="tab" data-toggle="tab">Contratos</a>
                        </li>
                    @endcan
                    @can('view', \App\Models\Budget::class)
                        <li class="nav-item">
                            <a id="budgets" class="nav-link" href="#presupuesto" role="tab" data-toggle="tab">Presupuesto</a>
                        </li>
                    @endcan
                    @can('view', \App\Models\Income::class)
                        <li class="nav-item">
                            <a id="incomes" class="nav-link" href="#ingresos" role="tab" data-toggle="tab">Ingresos</a>
                        </li>
                    @endcan
                    @can('view', \App\Models\Monitoring::class)
                        <li class="nav-item">
                            <a id="monitorings" class="nav-link" href="#seguimientos" role="tab" data-toggle="tab">Seguimientos</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a id="historyCliniClick" class="nav-link" href="#clinica" role="tab" data-toggle="tab">H. Clínica</a>
                    </li>
                    <li class="nav-item">
                        <a id="success" class="nav-link" href="#sucesos" role="tab" data-toggle="tab">Sucesos</a>
                    </li>
                    @can('view', \App\Models\Sale::class)
                    <li class="nav-item">
                        <a id="sales" class="nav-link" href="#ventas" role="tab" data-toggle="tab">Ventas</a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" href="#moneyBox" role="tab" data-toggle="tab">
                            Dinero en Caja
                        </a>
                    </li>
                    @can('view', \App\Models\PatientsFiles::class)
                        <li class="nav-item">
                            <a id="patientF" class="nav-link" href="#patientsFiles" role="tab" data-toggle="tab">
                                Archivos
                            </a>
                        </li>
                    @endcan
                    @can('view', \App\Models\InformedConsents::class)
                        <li class="nav-item">
                            <a id="informedConsentsClick" class="nav-link" href="#informedConsents" role="tab" data-toggle="tab">
                                Consentimientos
                            </a>
                        </li>
                    @endcan
                    @can('view', \App\Models\PoliciesPatients::class)
                        <li class="nav-item">
                            <a id="polizasClick" class="nav-link" href="#polizas" role="tab" data-toggle="tab">
                                Polizas
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item" style="visibility: hidden">
                        <a class="nav-link darClickHistorial" href="#moneyBoxHistorial" role="tab" data-toggle="tab">
                            Historial
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-content-patiens">
                    @component('patients.informedConsents',[
                        'informedConsents'=>$patient->informedConsents,
                        'contracts'=>$patient->contracts,
                        'patient'=>$patient
                    ])
                    @endcomponent
                    @component('patients.polizas',[
                        'data'=>$patient->policies,
                        'contracts'=>$patient->contracts,
                        'patient'=>$patient
                    ])
                    @endcomponent
                    @component('patients.moneyBox',[
                        'moneyBox'=>$patient->incomesCaja,
                        'moneyBoxHistorial'=>$patient->incomesHistorial,
                        'contracts'=>$patient->contracts,
                        'patient'=>$patient
                    ])
                    @endcomponent
                    @component('patients.patientsFile',[
                        'files'=>$patient->getFile,
                    ])
                    @endcomponent
                    @can('view', \App\Models\Sale::class)
                        <div role="tabpanel" class="tab-pane fade" id="ventas">
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="title-crud mb-3">
                                        <h2>Ventas</h2>
                                    </div>
                                    <div class="button-new">
                                        @can('create', \App\Models\Sale::class)
                                            <a class="btn btn-primary" href="{{ route("sales.create") }}/patient/{{ $patient->id }}"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-soft">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Total</th>
                                        <th>Forma de pago</th>
                                        <th>Sub total</th>
                                        <th>IVA</th>
                                        <th>Descuento</th>
                                        <th>Vendedor</th>
                                        <th>Realizado</th>
                                        <th>Fecha</th>
                                        <th class="fl-ignore" width="130px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>V-{{ $sale->id }}</td>
                                        <td>$ {{ number_format($sale->amount, 2) }}</td>
                                        <td>{{ ucfirst($sale->method_payment) }}</td>
                                        <td>$ {{ number_format($sale->amount - $sale->tax - $sale->discount_total, 2) }}</td>
                                        <td>$ {{ number_format($sale->tax, 2) }}</td>
                                        <td>$ {{ number_format($sale->discount_total, 2) }}</td>
                                        <td>{{ ucfirst(mb_strtolower($sale->seller->name . " " . $sale->seller->lastname)) }}</td>
                                        <td>{{ ucfirst(mb_strtolower($sale->user->name . " " . $sale->user->lastname)) }}</td>
                                        <td>{{ date("Y-m-d", strtotime($sale->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('sales.show',$sale->id) }}"><span class="icon-eye mr-2"></span></a>
                                            <a target="_blank" href="{{ url("/sales/pdf/" . $sale->id) }}"><span class="icon-print-02"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endcan
                    @can('view', \App\Models\Schedule::class)
                    <div role="tabpanel" class="tab-pane fade show active" id="citas">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="title-crud mb-3">
                                    <h2>Citas</h2>
                                </div>
                                <div class="button-new">
                                    @can('create', \App\Models\Schedule::class)
                                        <a class="btn btn-primary" href="{{ route("schedules.create") }}/patient/{{ $patient->id }}"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        @component('patients.schedule',[
                            'schedules'=>$patient->schedules
                        ])
                        @endcomponent
                    </div>
                    @php
                        /*
                        $services1 = \App\Models\Service::join('items','services.id','=','items.service_id')
                            ->join('contracts','items.contract_id','=','contracts.id')
                            ->where('contracts.patient_id',$patient->id)
                            ->where(['services.status' => 'activo'])
                            ->where('contracts.status','!=','anulado')
                            ->where('contracts.status','!=','liquidado')
                            ->where(['services.contract' => 'SI'])
                            ->orderBy('services.name')
                            ->select('services.*')
                            ->groupBy('services.id')
                            ->get();
                        $services_2 = \App\Models\Service::where('status','activo')
                            ->where('contract','no')
                            ->get();
                        $servicesSchedule = $services1->merge($services_2);
                        */
                        $servicesSchedule = \App\Models\Service::where('status','activo')
                            ->orderBy('name','asc')
                            ->get();
                    @endphp
                     @component('patients.modal_schedule',[
                        'servicesSchedule'=>$servicesSchedule,
                        'patient_id'=>$patient->id,
                        'professionals'=>\App\User::where(['status' => 'activo', 'schedule' => 'si'])->orderBy('name')->orderBy('lastname')->get()
                     ])
                     @endcomponent
                    @endcan
                    @can('view', \App\Models\Contract::class)
                    <div role="tabpanel" class="tab-pane fade" id="contratos">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="title-crud mb-3">
                                    <h2>Contratos</h2>
                                </div>
                                <div class="button-new">
                                    @can('create', \App\Models\Contract::class)
                                        <a class="btn btn-primary" href="{{ route("contracts.create") }}/patient/{{ $patient->id }}"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-soft">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Saldo</th>
                                <th>Saldo a favor</th>
                                <th>Servicio contratado</th>
                                <th>Elaborador</th>
                                <th>Vendedor</th>
                                <th>Estado</th>
                                <th width="100px">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patient->contracts as $c)
                                <tr>
                                    <td>C-{{ $c->id }}</td>
                                    {{-- date("Y-m-d", strtotime($c->created_at)) --}}
                                    <td>{{ date("Y-m-d", strtotime($c->created_at)) }}</td>
                                    <td>$ {{ number_format($c->amount) }}</td>
                                    <td>$ {{ number_format($c->amount - $c->balance) }}</td>
                                    @php
                                        $consumed = \App\Models\Consumed::where("contract_id",$c->id)->get();
                                        $totalConsumed = 0;
                                        foreach ($consumed as $con) {
                                            $totalConsumed += $con->amount;
                                        }
                                        $balance = $c->balance - $totalConsumed;
                                    @endphp
                                    <td>
                                        $ {{ number_format($balance, 0,',','.') }}
                                    </td>
                                    <td>
                                        @if(!empty($c->items))
                                            @foreach($c->items as $i) {{ $i->name }} @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $c->user->name . " " . $c->user->lastname }}</td>
                                    <td>{{ $c->seller->name . " " . $c->seller->lastname }}</td>
                                    <td>{{ ucfirst($c->status) }}</td>
                                    <td>
                                        <form id="form-{{ $c->id }}" action="{{ route('contracts.destroy',$c->id) }}" method="POST">
                                        <a href="{{ route('contracts.show',$c->id) }}"><span class="icon-eye"></span></a>
                                        @can('update', \App\Models\Contract::class)
                                            @if ($c->status == "sin confirmar")
                                                <a class="" href="{{ route('contracts.edit',$c->id) }}"><span class="icon-icon-11 ml-2"></span></a>
                                            @endif
                                        @endcan
                                        @can('delete', \App\Models\Contract::class)
                                            @csrf
                                            @method('DELETE')
                                            @if ($c->status == "sin confirmar")
                                                <a href="#" class="form-submit" data-id="form-{{ $c->id }}"><span class="icon-icon-12"></span></a>
                                            @endif
                                        @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endcan
                    @can('view', \App\Models\Budget::class)
                    <div role="tabpanel" class="tab-pane fade" id="presupuesto">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="title-crud mb-3">
                                    <h2>Presupuestos</h2>
                                </div>
                                <div class="button-new">
                                    @can('create', \App\Models\Budget::class)
                                        <a class="btn btn-primary" href="{{ route("budgets.create") }}/patient/{{ $patient->id }}"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-soft">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Servicios</th>
                                <th>Elaborador</th>
                                <th>Vendedor</th>
                                <th>Estado</th>
                                <th width="150px">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patient->budgets as $c)
                            {{-- date("Y-m-d", strtotime($c->created_at)) --}}
                                <tr>
                                    <td>P-{{ $c->id }}</td>
                                    <td>{{ date("Y-m-d", strtotime($c->created_at)) }}</td>
                                    <td>$ {{ number_format($c->amount) }}</td>
                                    <td>@foreach($c->items as $i) {{ $i->name }} @endforeach</td>
                                    <td>{{ $c->user->name . " " . $c->user->lastname }}</td>
                                    <td>{{ $c->seller->name . " " . $c->seller->lastname }}</td>
                                    <td>{{ ucfirst($c->status) }}</td>
                                    <td>
                                        <form id="form-{{ $c->id }}" action="{{ route('budgets.destroy',$c->id) }}" method="POST">
                                            <a target="_blank" href="{{ url("/budget/pdf/" . $c->id) }}"><span class="icon-print-02"></span></a>
                                            <a href="{{ route('budgets.show',$c->id) }}"><span class="icon-eye"></span></a>
                                            @if ($c->status == "activo")
                                                @can('update', \App\Models\Budget::class)
                                                        <a class="" href="{{ route('budgets.edit',$c->id) }}"><span class="icon-icon-11"></span></a>
                                                @endcan
                                                @can('delete', \App\Models\Budget::class)
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="form-submit" data-id="form-{{ $c->id }}"><span class="icon-icon-12"></span></a>
                                                @endcan
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endcan
                    @can('view', \App\Models\Income::class)
                    <div role="tabpanel" class="tab-pane fade" id="ingresos">
                        <div id="seeIncome">
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="title-crud mb-3">
                                        <h2>Ingresos</h2>
                                    </div>
                                    <div class="button-new">
                                        @can('create', \App\Models\Income::class)
                                            <a class="btn btn-primary createIncome" href="#"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-soft">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Contrato</th>
                                    <th>Vendedor</th>
                                    <th>Responsable</th>
                                    <th>Monto</th>
                                    <th>Comentario</th>
                                    <th>Forma de pago</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th width="100px">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patient->incomes as $i)
                                    @if($i->method_of_pay_2 != '')
                                        <tr>
                                            <td>I-{{ $i->id }}</td>
                                            <td>{{ ($i->contract) ? "C-" . $i->contract->id : "" }}</td>
                                            <td>{{ $i->seller->name . " " . $i->seller->lastname }}</td>
                                            <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                                            <td>{{ number_format($i->amount_one, 2) }}</td>
                                            <td>{{ $i->comment }}</td>
                                            <td>{{ ucfirst($i->method_of_pay) }}</td>
                                            <td>{{ $i->status }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td>
                                                <form id="form-{{ $i->id }}" action="{{ route('incomes.destroy',$i->id) }}" method="POST">
                                                    @can('view', \App\Models\Income::class)
                                                        <a href="{{ route('incomes.show',$i->id) }}"><span class="icon-eye"></span></a>
                                                        <a target="_blank" href="{{ url("/incomes/pdf/" . $i->id) }}"><span class="icon-print-02"></span></a>
                                                    @endcan
                                                </form>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>I-{{ $i->id }}</td>
                                            <td>{{ ($i->contract) ? "C-" . $i->contract->id : "" }}</td>
                                            <td>{{ $i->seller->name . " " . $i->seller->lastname }}</td>
                                            <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                                            <td>{{ number_format($i->amount_two, 2) }}</td>
                                            <td>{{ $i->comment }}</td>
                                            <td>{{ ucfirst($i->method_of_pay_2) }}</td>
                                            <td>{{ $i->status }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td>
                                                <form id="form-{{ $i->id }}" action="{{ route('incomes.destroy',$i->id) }}" method="POST">
                                                    @can('view', \App\Models\Income::class)
                                                        <a href="{{ route('incomes.show',$i->id) }}"><span class="icon-eye"></span></a>
                                                        <a target="_blank" href="{{ url("/incomes/pdf/" . $i->id) }}"><span class="icon-print-02"></span></a>
                                                    @endcan
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>I-{{ $i->id }}</td>
                                            <td>{{ ($i->contract) ? "C-" . $i->contract->id : "" }}</td>
                                            <td>{{ $i->seller->name . " " . $i->seller->lastname }}</td>
                                            <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                                            <td>{{ number_format($i->amount, 2) }}</td>
                                            <td>{{ $i->comment }}</td>
                                            <td>{{ ucfirst($i->method_of_pay) }}</td>
                                            <td>{{ $i->status }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td>
                                                <form id="form-{{ $i->id }}" action="{{ route('incomes.destroy',$i->id) }}" method="POST">
                                                    @can('view', \App\Models\Income::class)
                                                        <a href="{{ route('incomes.show',$i->id) }}"><span class="icon-eye"></span></a>
                                                        <a target="_blank" href="{{ url("/incomes/pdf/" . $i->id) }}"><span class="icon-print-02"></span></a>
                                                    @endcan
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="createIncome" style="display: none;">
                            <div class="title-crud mb-5">
                                <h2>Crear ingreso</h2>
                            </div>
                            <div class="clear"></div>
                            <p class="title-pry mb-4">Contratos asignados</p>
                            <form id="Income" method="POST" class="form-swal-alert">
                                @csrf
                                <select name="contract_id_select" id="contract_id_select" class="form-control" style="width: 25% !important;">
                                    <option value="" selected>Seleccionar Contrato</option>
                                    @foreach($patient->contracts as $k)
                                        @if($k->status == 'activo' && ($k->amount - $k->balance) > 0)
                                            <option value="{{$k->id}}">C-{{$k->id}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                @forelse($patient->contracts as $k)
                                    @if($k->status == 'activo' && ($k->amount - $k->balance) > 0)
                                    @for($i=1;$i<=1;$i++)
                                         @php
                                            $c = $k->id.'-'.$i;
                                         @endphp
                                    <div class="row align-items-end contract-div contract-div-{{$k->id}}">
                                        <div class="col-md-8">
                                            <div class="row align-items-center">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" name="type-{{ $c }}" value="unico">
                                                        <!--
                                                        <select name="type-{{ $c }}" class="form-control">
                                                            <option value="unico">Pago único</option>
                                                            <option value="compartido">Pago compartido</option>
                                                        </select>
                                                        -->
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Contrato</strong>
                                                        <input readonly type="text" class="form-control" value="C-{{ $k->id }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <strong>Centro de costo</strong>
                                                        <select name="center_cost_id-{{ $c }}" id="center_cost_id-{{ $c }}" class="center_cost_contract form-control">
                                                            <option value="">Seleccione</option>
                                                            @foreach($centers as $ct)
                                                                <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <strong>Vendedor</strong>
                                                        <select name="seller_id-{{ $c }}" id="seller_id-{{ $c }}" class="form-control" readonly>
                                                            <!--<option value="">Seleccione</option>-->
                                                            @foreach($users as $u)
                                                                @if($u->id == $k->seller_id)
                                                                    <option value="{{ $u->id }}" selected>{{ $u->name . " " . $u->lastname }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-12 mb-3" style="width: 0px;visibility: hidden">
                                                    <label class="container-soft"><input type="checkbox" data-id="{{ $c }}" class="addIncome addIncome{{$c}}" name="contract[]" value="{{ $c }}"><span class="checkmark"></span></label>
                                                </div>
                                                {{--<div class="col-md-4">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<strong>Total</strong>--}}
                                                        {{--<input type="text" id="totalC-{{ $c->id }}" data-value="{{ $c->amount }}" value="$ {{ number_format($c->amount, 2, '.', '.') }}" disabled class="form-control">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <strong>Saldo</strong>
                                                        <input type="text" id="balanceC-{{ $c }}" data-value="{{ $k->amount - $k->balance }}" value="$ {{ number_format($k->amount - $k->balance, 2, '.', '.') }}" disabled class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <strong>Ingresar Valor</strong>
                                                        <input type="text" name="V-{{ $c }}" id="incomeC-{{ $c }}" class="center_value_contract form-control OnlyNumber incomeI" onkeyup="incomeTotal(this)" id_number="{{$c}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                    @endif
                                @empty
                                    <p>No hay contratos</p>
                                @endforelse
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Total de ingreso(automatico con contrato)</strong>
                                        <input type="text" class="form-control OnlyNumber" name="amount" id="incomeAmount" required onkeyup="formatNumberWrite(this)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Responsable</strong>
                                        <select name="responsable_id" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            @foreach($users as $u)
                                                @if ($u->id == $user->id)
                                                    <option selected value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Centro de costo (si no hay contrato)</strong>
                                        <select name="center_cost_id" id="center_cost_id" class="form-control" required="required">
                                            <option value="">Seleccione</option>
                                            @foreach($centers as $ct)
                                                <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Vendedor (si no hay contrato)</strong>
                                        <select name="seller_id" id="seller_id" class="form-control" required="required">
                                            <option value="">Seleccione</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <strong>Responsable de seguimiento</strong>
                                        <select name="follow_id" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            <option value="0">No aplica</option>
                                            @foreach($users as $u)
                                                @if ($u->id == 28 || $u->id == 40 || $u->id == 29 || $u->id == 26 || $u->id == 82)
                                                    <option value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Forma de pago</strong>
                                                    <select name="method_of_pay" class="form-control" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="efectivo">Efectivo</option>
                                                        <option value="tarjeta">Tarjeta</option>
                                                        <option value="consignacion">Consignación</option>
                                                        <option value="tarjeta recargable">T. Recargable</option>
                                                        <!--<option value="software">U. Software</option>-->
                                                        <option value="online">Pago online</option>
                                                        <option value="transferencia">Transferencia</option>
                                                        <option value="unificacion">Unificación</option>
                                                        <option value="bono">Bono/Regalo</option>
                                                        <option value="sistecredito">Sistecredito</option>
                                                        <option value="pse">Pse</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 priceOne">
                                                <div class="form-group">
                                                    <strong>Valor</strong>
                                                    <input type="text" name="amount_one" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 unificacion" style="display: none">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <strong>Motivo de unificacion</strong>
                                                    <textarea name="unification" class="form-control" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tarjeta">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Tipo de tarjeta</strong>
                                                    <select name="type_of_card" id="type_of_card" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="debito">Debito Maestro</option>
                                                        <option value="mastercard">Mastercard</option>
                                                        <option value="visa">Visa</option>
                                                        <option value="american express">American Express</option>
                                                        <option value="dinners club">Dinners Club</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Aprobación de Tarjeta</strong>
                                                    <input type="text" class="form-control" name="approved_of_card">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Entidad de Tarjeta</strong>
                                                    <input type="text" class="form-control" name="card_entity">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Recibo</strong>
                                                    <input type="hidden" name="receipt">
                                                    <div class="form-group cam-soft" data-destination="receipt" data-toggle="modal" data-target="#ModalReceipt">
                                                        <div>Agregar foto</div>
                                                        <div><span class="icon-file-02"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 consignacion">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Banco origen</strong>
                                                    <input type="text" class="form-control" name="origin_bank">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Cuenta origen</strong>
                                                    <input type="text" class="form-control" name="origin_account">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Número de aprobación</strong>
                                                    <input type="text" class="form-control" name="approved_Banco">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 online">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Referencia ePayco</strong>
                                                    <input type="text" class="form-control" name="ref_epayco">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Número de aprobación</strong>
                                                    <input type="text" class="form-control" name="approved_epayco">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 account">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Cuenta de Banco Destino</strong>
                                                    <select name="account_id" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->account }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Forma de pago 2</strong>
                                                    <select name="method_of_pay_2" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="efectivo">Efectivo</option>
                                                        <option value="tarjeta">Tarjeta</option>
                                                        <option value="online">Pago online</option>
                                                        <option value="consignacion">Consignación</option>
                                                        <option value="tarjeta recargable">T. Recargable</option>
                                                        <!--<option value="software">U. Software</option>-->
                                                        <option value="transferencia">Transferencia</option>
                                                        <option value="unificacion">Unificación</option>
                                                        <option value="bono">Bono/Regalo</option>
                                                        <option value="sistecredito">Sistecredito</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 priceTwo">
                                                <div class="form-group">
                                                    <strong>Valor</strong>
                                                    <input type="text" name="amount_two" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 unificacion2" style="display: none">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <strong>Motivo de unificacion</strong>
                                                    <textarea name="unification_2" class="form-control" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tarjeta2">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Tipo de tarjeta</strong>
                                                    <select name="type_of_card_2" id="type_of_card_2" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="debito">Debito Maestro</option>
                                                        <option value="mastercard">Mastercard</option>
                                                        <option value="visa">Visa</option>
                                                        <option value="american express">American Express</option>
                                                        <option value="dinners club">Dinners Club</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Aprobación de Tarjeta</strong>
                                                    <input type="text" class="form-control" name="approved_of_card_2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Entidad de Tarjeta</strong>
                                                    <input type="text" class="form-control" name="card_entity_2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Recibo</strong>
                                                    <input type="hidden" name="receipt_2">
                                                    <div class="form-group cam-soft" data-destination="receipt_2" data-toggle="modal" data-target="#ModalReceipt">
                                                        <div>Agregar foto</div>
                                                        <div><span class="icon-file-02"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 consignacion2">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Banco origen</strong>
                                                    <input type="text" class="form-control" name="origin_bank_2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Cuenta origen</strong>
                                                    <input type="text" class="form-control" name="origin_account_2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Número de aprobación</strong>
                                                    <input type="text" class="form-control" name="approved_Banco_2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 online2">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Referencia ePayco</strong>
                                                    <input type="text" class="form-control" name="ref_epayco_2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Número de aprobación</strong>
                                                    <input type="text" class="form-control" name="approved_epayco_2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 account2">
                                    <div class="form-group" style="line-height: 24px">
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <strong>Cuenta de Banco Destino</strong>
                                                    <select name="account2_id" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->account }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <strong>Campaña o promocion</strong>
                                        @php
                                            $campaign = \App\Models\Campaign::where('status','activo')->get();
                                        @endphp
                                        <select name="campaign" class="form-control" required>
                                            <option value="Ninguna">Ninguna</option>
                                            @foreach($campaign as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Descripción</strong>
                                        <textarea name="comment" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3"><button type="submit" class="btn btn-primary" id="guardarIngre">Guardar</button></div>
                                        <div class="col-md-3"><div class="btn btn-primary seeIncome" style="background: #4cd455;">Ver ingresos</div></div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    @endcan
                    @can('view', \App\Models\Monitoring::class)
                    <div role="tabpanel" class="tab-pane fade" id="seguimientos">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="title-crud mb-3">
                                    <h2>Seguimientos</h2>
                                </div>
                                <div class="button-new">
                                    @can('create', \App\Models\Monitoring::class)
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#ModalCenter" href="#"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-soft">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Tema</th>
                                <th>Elaborador</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                                <th width="100px">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($patient->monitorings as $c)
                                <tr>
                                    <td>S-{{ $c->id }}</td>
                                    {{-- date("d-M-Y", strtotime($c->date)) --}}
                                    <td>{{ $c->date }}</td>
                                    <td>{{ $c->issue->name }}</td>
                                    <td>{{ $c->user->name . " " . $c->user->lastname }}</td>
                                    <td>{{ $c->responsable->name . " " . $c->responsable->lastname }}</td>
                                    <td>{{ ucfirst($c->status) }}</td>
                                    <td>
                                        <form id="form-{{ $c->id }}" action="{{ route('monitorings.destroy',$c->id) }}" method="POST">
                                            <a href="{{ route('monitorings.show',$c->id) }}"><span class="icon-eye"></span></a>
                                            @can('delete', \App\Models\Monitoring::class)
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="form-submit" data-id="form-{{ $c->id }}"><span class="icon-icon-12"></span></a>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endcan
                    <div role="tabpanel" class="tab-pane fade" id="clinica">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="title-crud mb-3">
                                    <h2>Historial médico</h2>
                                </div>
                                <!--
                                <div class="button-new">
                                    @can('create', \App\Models\Patient::class)
                                        <a class="btn btn-primary butonHistoryClinic" href="{{ route("anamnesis.index") }}"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                    @endcan
                                </div>
                                -->
                                <div class="button-new">
                                    <a target="_blank" class="btn btn-primary" style="background: #ffffff !important;color: red" href="{{ url("patients/pdf/".$patient->id) }}"><span class="icon-print-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Imprimir</a>
                                    <a target="_blank" class="btn btn-primary print2" style="background: #ffffff !important;color: red"  data-id="{{$patient->id}}"> <span class="icon-print-02"><span class="path1 print2"></span><span class="path2"></span><span class="path3"></span></span> Imprimir 2</a>
                                
                                </div>
                            </div>
                        </div>
                        <style>
                            .tabs-history li{
                                float: inherit;
                                width: 100%;
                                margin: 0px !important;
                                margin-bottom: 4px !important;
                            }
                        </style>
                        <div class="row">
                            <div class="col-lg-3">
                                <ul class="nav nav-tabs tabs-patiens tabs-history d-flex" role="tablist">
                                    @php
                                        $typeMedicalHistory = \App\Models\TypeMedicalHistory::all();
                                    @endphp
                                    @foreach($typeMedicalHistory as $key => $tmh)
                                        <li class="nav-item">
                                            <a ondblclick="location.href = '{{url($tmh->href)}}/{{$patient->id}}'" class="nav-link {{($key == 0)?'active show':''}} clickHistoryClinic" href="#{{str_replace(' ','',$tmh->name)}}" role="tab" data-toggle="tab" aria-selected="false" link="{{$tmh->href}}">
                                                {{$tmh->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-lg-9">
                                <div class="tab-content tab-content-patiens" style="border-top: none">
                                    @foreach($typeMedicalHistory as $key => $tmh)
                                        <div role="tabpanel" class="tab-pane fade {{($key == 0)?'active show':''}}" id="{{str_replace(' ','',$tmh->name)}}">
                                            <p class="title-form">
                                                {{$tmh->name}}
                                            </p>
                                            @switch($tmh->id)
                                                @case(1)
                                                    @component('patients.history.anamnesis',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(2)
                                                    @component('patients.history.system-review',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(3)
                                                    @component('patients.history.physical-exams',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(4)
                                                    @component('patients.history.measurements',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(5)
                                                    @component('patients.history.clinical-diagnostics',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(6)
                                                    @component('patients.history.treatment-plan',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(7)
                                                    @component('patients.history.biological-medicine-plan',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(8)
                                                    @component('patients.history.laboratory-exams',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(9)
                                                    @component('patients.history.medical-evolutions',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(10)
                                                    @component('patients.history.cosmetological-evolution',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(11)
                                                    @component('patients.history.infirmary-evolution',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(12)
                                                    @component('patients.history.formulation-appointment',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(13)
                                                    @component('patients.history.expenses-sheet',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(14)
                                                    @component('patients.history.surgery-expenses-sheet',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(15)
                                                    @component('patients.history.infirmary-notes',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(16)
                                                    @component('patients.history.surgical-description',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(17)
                                                    @component('patients.history.patient-photographs',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(18)
                                                    @component('patients.history.lab-results',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(19)
                                                    @component('patients.history.medication-control',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                                @case(20)
                                                    @component('patients.history.liquid-control',[
                                                        'medicalHistory'=>$medicalHistory
                                                    ])
                                                    @endcomponent
                                                    @break
                                            @endswitch
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @component('patients.modalSucess',[
                        'patient'=>$patient
                    ])
                    @endcomponent
                    <div role="tabpanel" class="tab-pane fade" id="sucesos">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="title-crud mb-3">
                                    <h2>Sucesos</h2>
                                </div>
                                <div class="button-new">
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#ModalSucess" href="#"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Crear</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-soft">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Suceso</th>
                                <th>Elaborador</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sucess as $s)
                                <tr>
                                    {{--  --}}
                                    <td>{{ date("Y-m-d", strtotime($s->created_at)) }}</td>
                                    <td>{{ $s->observation }}</td>
                                    <td>{{ $s->user->name . " " . $s->user->lastname }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div id="results"></div>
    </div>

    <iframe id="iframePdf"></iframe>
    <div class="modal fade" id="modalHistoryClinic" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form method="POST">
                @csrf
                <div id="datosModal">
                </div>
            </form>
        </div>
    </div>
    <style>
        .modal form{
            width: 100%;
        }
        .modal .modal-lg{
            /*width: 1000px;*/
            max-width: 1000px;
        }

        .icon-eye:hover,.patientModalSelecteMoneyBox:hover{
            cursor: pointer;
        }
         #carouselExampleIndicators img{
             width: 50% !important;
             margin-left: auto !important;
             margin-right: auto !important;
             display: block !important;
             vertical-align: middle !important;
         }
        #carouselExampleIndicators .btn button,#carouselExampleIndicators .btn{
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
        }
    </style>
@endsection
@section('script')
    <script src="{{ asset("js/webcam.min.js") }}"></script>
    <script>



       /* function detectWebcam(callback) {
            let md = navigator.mediaDevices;
            if (!md || !md.enumerateDevices) return callback(false);
            md.enumerateDevices().then(devices => {
                callback(devices.some(device => 'videoinput' === device.kind));
            })
        }

        detectWebcam(function(hasWebcam) {
            if (hasWebcam) {
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach( '#camera' );
            }
        })

        @if ($referer)
            $("#incomes").click();
            $("#createIncome").show();
            $("#seeIncome").hide();
        @endif
        */
        @if(session()->has('menu_patient_show'))
            @if(session()->get('menu_patient_show') == 1)
            $("#dates").click();
            @endif
            @if(session()->get('menu_patient_show') == 2)
            $("#contracts").click();
            @endif
            @if(session()->get('menu_patient_show') == 3)
            $("#budgets").click();
            @endif
            @if(session()->get('menu_patient_show') == 4)
            $("#incomes").click();
            @endif
            @if(session()->get('menu_patient_show') == 5)
            $("#monitorings").click();
            @endif
            @if(session()->get('menu_patient_show') == 6)
            $("#historyCliniClick").click();
            @endif
            @if(session()->get('menu_patient_show') == 7)
            $("#success").click();
            @endif
            @if(session()->get('menu_patient_show') == 8)
            $("#sales").click();
            @endif
            @if(session()->get('menu_patient_show') == 9)
            $("#informedConsentsClick").click();
            @endif
            @if(session()->get('menu_patient_show') == 10)
            $("#polizasClick").click();
            @endif
            @if(session()->get('menu_patient_show') == 0)
                $("#incomes").click();
                $("#createIncome").show();
                $("#seeIncome").hide();
            @endif
        @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                if ($("#destination").val() == "receipt") {
                    $("[name=receipt]").val(data_uri.replace(/^data\:image\/\w+\;base64\,/, ''));
                    document.getElementById('results').innerHTML =
                        '<img src="'+data_uri+'"/>';
                } else {
                    $("[name=receipt_2]").val(data_uri.replace(/^data\:image\/\w+\;base64\,/, ''));
                    document.getElementById('results').innerHTML =
                        '<img src="'+data_uri+'"/>';
                }

            } );
        }

        function amounMoneyBoxChange(obj) {
            if($(obj).val() <= 0 || $(obj).val() == ''){
                $(obj).val(0);
            }
            var regex = /(\d+)/g;
            var valor = $(obj).val();
            valor = valor.match(regex);
            /*
            var valor = $(obj).val();
            valor = new Intl.NumberFormat().format(valor);
            valor = valor.replace(',' , ".");
            */
            $(obj).val(formatNumber(valor));
        }

        function incomeTotal(obj) {
            if($(obj).val() <= 0 || $(obj).val() == ''){
                $(obj).val(0);
            }
            formatNumberWrite(obj);
            var number_id = $(obj).attr('id_number');
            /*
            if(parseInt($(obj).val()) > 0){
                if ($('.addIncome'+number_id).is(':checked')) {

                }else{
                    $('.addIncome'+number_id).click();
                }
            }else{
                if ($('.addIncome'+number_id).is(':checked')) {
                    $('.addIncome'+number_id).click();
                }
            }
             */
            var income;
            var total = 0;
            var valor = $(obj).val().replace(".", "");
            valor = valor.replace(".", "");
            valor = valor.replace(",", "");
            valor = valor.replace(",", "");
            $(".incomeI").each(function () {
                if ($(this).val() != 0 || $(this).val() != "") {
                    income = $(this).val().replace(".", "");
                    income = income.replace(".", "");
                    income = income.replace(",", "");
                    income = income.replace(",", "");
                    total += parseInt(income);
                }
            });
            $("#incomeAmount").val(formatNumber(total))
        }

        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }

        function formatNumberWrite (obj) {
            var n = $(obj).val()
            n = String(n).replace(/\D/g, "");
            $(obj).val(n === '' ? n : Number(n).toLocaleString());
        }

        function modalMediaclHistory(id_type,id_relation,patiend_id)
        {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{url('/patients/modalHistoryClinic')}}",
                method: "POST",
                data: {
                    '_token':token,
                    id_type:id_type,
                    id_relation:id_relation,
                    patiend_id:patiend_id,
                    action:'modalHistoryClinic'},
                success: function (data) {
                    $('#datosModal').html('');
                    $('#datosModal').html(data);
                    $('#modalHistoryClinic').modal('show');
                }
            });
        }

        $('.editSchedule').click(function () {
            $("#date-schedule-edit").val($(this).attr('date'));
            $("#schedule-id").val($(this).attr('id'));

            $("#serviceScheduleEdit").val($(this).attr('id_service'));
            $("#contractScheduleEdit").select2({
                ajax: {
                    dataType: "json",
                    url: "/service/contracts_2",
                    data: {
                        id: $(this).attr('id_service'),
                        id_patient: $(this).attr('id_patient')
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
            $("#contractScheduleEdit").val($(this).attr('id_contract')).trigger('change');

            $('#timeStartEdit').data("DateTimePicker").date($(this).attr('start'));
            $('#timeEndEdit').data("DateTimePicker").date($(this).attr('end'));
            $("#comment-edit").val($(this).attr('comment'));
            $("#professional_id").val($(this).attr('professional'));
            $("#ModalScheduleEdit").modal("show");
        });
    </script>
    <script>
        $('#frmScheduleEditPatient').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                async:true,
                type: 'PUT',
                url: '/schedules/' + $("#schedule-id").val(),
                dataType: 'json',
                data: $(this).serialize(),
                statusCode: {
                    201: function(data) {
                        $("#ModalScheduleEdit").modal("hide");
                        swal('Bien hecho', 'La cita ha sido actualizada con éxito', 'success')
                        setTimeout(function () {
                            location.reload();
                        },500)
                    },
                    200: function (data) {
                        swal('¡Ups!', data.message, 'warning')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });

        $('.clickHistoryClinic').click(function () {
            $('.butonHistoryClinic').attr('href','{{url('/')}}/'+$(this).attr('link'));
        });
    </script>
    <style>
        .cont-show__info div{
            word-wrap: break-word;
        }
    </style>
    <script>
        //modal consentimiento informado. . .
        $('#modalInformedConsents .file_informed_consents').css('display','none');
        $('.clickAddInformedConsents').click(function () {
            $('#modalInformedConsents').modal('show');
        });
        $('#modalInformedConsents #type_informed_consents').change(function () {
            if($(this).val() == 'pdf'){
                $('#modalInformedConsents .file_informed_consents').css('display','block');
            }else{
                $('#modalInformedConsents .file_informed_consents').css('display','none');
            }
        });
        $('#modalInformedConsents #contract_informed_consents').change(function () {
            var id_contract = $(this).val();
            //alert(id_contract);
            $('#service_informed_consents').val(null).empty().select2('destroy');
            $.ajax({
                dataType: "json",
                url: "/informed_consents/services",
                data: {
                    id: id_contract
                },
            }).then(function (response) {
                $("#service_informed_consents").select2({
                    data: response,
                });
            });
        });
        $('.addInformedConsents').click(function () {
            $('#formInformedConsents').submit();
        });
        $('#formInformedConsents').submit(function (e) {
            e.preventDefault();
            swal({
                    title: "",
                    text: "¿Seguro de añadir estos datos?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        //var data = $('#updateIncomeMoneyBox').serialize();
                        var formData = new FormData();
                        formData.append('file', $('#formInformedConsents #file_informed_consents')[0].files[0]);
                        formData.append('contract', $('#formInformedConsents #contract_informed_consents').val());
                        formData.append('service', $('#formInformedConsents #service_informed_consents').val());
                        formData.append('patient', $('#formInformedConsents #patient_informed_consents').val());
                        formData.append('type', $('#formInformedConsents #type_informed_consents').val());
                        $.ajax({
                            url: "{{url('/informed_consents/store')}}",
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if($.trim(data) == 1){
                                    swal({
                                        title: "Se ha añadido el Consentimiento Informado",
                                        type: 'success',
                                        button: "OK!",
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    },1000)
                                }else{
                                    swal({
                                        title: ""+data,
                                        type: "warning",
                                        button: "OK!",
                                    });
                                }
                            }

                        });
                    } else {
                        return false;
                    }
                });
        });
        //ending

        //modal polizas
        $('#modalPolizas .file_polizas').css('display','none');
        $('.clickAddPolizas').click(function () {
            $('#modalPolizas').modal('show');
        });
        $('#modalPolizas #type_polizas').change(function () {
            if($(this).val() == 'pdf'){
                $('#modalPolizas .file_polizas').css('display','block');
            }else{
                $('#modalPolizas .file_polizas').css('display','none');
            }
        });
        $('#modalPolizas #contract_polizas').change(function () {
            var id_contract = $(this).val();
            //alert(id_contract);
            $('#service_polizas').val(null).empty().select2('destroy');
            $.ajax({
                dataType: "json",
                url: "/policies/services",
                data: {
                    id: id_contract
                },
            }).then(function (response) {
                $("#service_polizas").select2({
                    data: response,
                });
            });
        });
        $('.addPolizas').click(function () {
            $('#formPolizas').submit();
        });
        $('#formPolizas').submit(function (e) {
            e.preventDefault();
            swal({
                    title: "",
                    text: "¿Seguro de añadir estos datos?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        //var data = $('#updateIncomeMoneyBox').serialize();
                        var formData = new FormData();
                        formData.append('file', $('#formPolizas #file_polizas')[0].files[0]);
                        formData.append('contract', $('#formPolizas #contract_polizas').val());
                        formData.append('service', $('#formPolizas #service_polizas').val());
                        formData.append('patient', $('#formPolizas #patient_polizas').val());
                        formData.append('type', $('#formPolizas #type_polizas').val());
                        $.ajax({
                            url: "{{url('/policies/store')}}",
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if($.trim(data) == 1){
                                    swal({
                                        title: "Se ha añadido la poliza",
                                        type: 'success',
                                        button: "OK!",
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    },1000)
                                }else{
                                    swal({
                                        title: ""+data,
                                        type: "warning",
                                        button: "OK!",
                                    });
                                }
                            }

                        });
                    } else {
                        return false;
                    }
                });
        });
        //ending

        $('.editMoneyBox').click(function () {
            $('#modalMoneyBox').modal('show');
            $('#modalMoneyBox #income_id').val(this.id);
            var total = $(this).attr('money');
            $('#modalMoneyBox #money').val(total);
        });
        $('.updateIncomeMoneyBox').click(function () {
            $('#updateIncomeMoneyBox').submit();
        });
        $('#updateIncomeMoneyBox').submit(function (e) {
            e.preventDefault();
            /*
            if($('#updateIncomeMoneyBox #contract_id').val() == ''){
                swal('','Debe seleccionar un contrato','error');
                return false;
            }*/
            swal({
                    title: "",
                    text: "¿Seguro de actualizar este ingreso?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        var data = $('#updateIncomeMoneyBox').serialize();
                        //console.log(data);
                        //console.log('entro');
                        $.ajax({
                            url: "{{url('/incomes/updateMoneyBox')}}",
                            type: "POST",
                            data: data,
                            success: function (data) {
                                if($.trim(data) == 1){
                                    swal({
                                        title: "Se ha actualizado el ingreso",
                                        type: 'success',
                                        button: "OK!",
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    },1000)
                                }else{
                                    swal({
                                        title: ""+data,
                                        type: "warning",
                                        button: "OK!",
                                    });
                                }
                            }

                        });
                    } else {
                        return false;
                    }
                });
        });
        function patientMoneyBox(id,name){
            $('#updateIncomeMoneyBox #patient_id').val(id);
            $('#updateIncomeMoneyBox #patient_name').val(name);
            $('#ModalPatient').modal('hide');
        }
        $('.openModalFiles').click(function () {
            $('#modalFileDocuments').modal('show');
        });
        $('.uploadFileDocument').click(function () {
            if($('#uploadFileDocument #file').val() == ''){
                swal({
                    title: "Debe subir un archivo",
                    type: "warning",
                    button: "OK!",
                });
                return false;
            }

            swal({
                    title: "",
                    text: "¿Seguro de subir este archivo?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $('#uploadFileDocument').submit();
                    } else {
                        return false;
                    }
                });
        });

        $('.clickHistorial').click(function () {
            $('.darClickHistorial').click();
        });

        /*
        $('#uploadFileDocument').submit(function (e) {
            e.preventDefault();
            if($('#uploadFileDocument #file').val() == ''){
                swal({
                    title: "Debe subir un archivo",
                    type: "warning",
                    button: "OK!",
                });
                return false;
            }
            swal({
                    title: "",
                    text: "¿Seguro de subir este archivo?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        //var data = $('#uploadFileDocument').serialize();
                        var data = new FormData();
                        jQuery.each($('#uploadFileDocument input[type=file]')[0].files, function(i, file) {
                            data.append('file-'+i, file);
                        });
                        var other_data = $('#uploadFileDocument').serializeArray();
                        $.each(other_data,function(key,input){
                            data.append(input.name,input.value);
                        });
                        //console.log(other_data);
                        //console.log($('#uploadFileDocument').serialize());
                        $.ajax({
                            url: "{{url('/patients/uploadFiles')}}",
                            method: "POST",
                            data: {
                                data: other_data
                            },
                            success: function (other_data) {
                                if($.trim(data) == 1){
                                    swal({
                                        title: "Se ha actualizado el ingreso",
                                        type: 'success',
                                        button: "OK!",
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    },1000)
                                }else{
                                    console.log(data);
                                    swal({
                                        title: ""+data,
                                        type: "warning",
                                        button: "OK!",
                                    });
                                }
                            }

                        });
                    } else {
                        return false;
                    }
                });
        });
        */
    </script>

    <script>
        $('.modalCancelar').click(function () {
            $('#schedule_id_cancelar').val(this.id);
            $("#ModalCenter_2").modal();
        });
        $('.cancelateDate').click(function () {
            statusSchedule(parseInt($('#schedule_id_cancelar').val()),'cancelada');
        });
        function statusSchedule(id, status, patient = '', role = '',service_id = '',contract = '') {
            $(".contract_validate_2").hide();
            $("#contract_validate_id_2").removeAttr('required');
            if (status == "cancelada") {
                swal({
                        title: "",
                        text: "¿Está seguro(a) de cancelar esta cita?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Si, estoy seguro",
                        closeOnConfirm: false
                    },
                    function(){
                        if($('#schedule_motivo').val() ==''){
                            swal('¡Ups!', 'Debe agregar el motivo de cancelación', 'error');
                            return false;
                        }
                        statusScheduleSubmit(id, status,$('#schedule_motivo').val());
                    });
            } else if (status == "confirmada") {
                swal({
                    title: "Confirmar cita",
                    text: "Digite las observaciones correspondientes",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                    inputPlaceholder: "Escriba aquí"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("Por favor escriba la observación");
                        return false
                    }
                    statusScheduleSubmit(id, status, inputValue)
                });

            } else if (status == "atendida") {
                swal({
                        title: "",
                        text: "¿Está seguro(a) de colocar en estado " + status + " esta cita?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonText: "Si, estoy seguro",
                        closeOnConfirm: false
                    },
                    function(){
                        statusScheduleSubmit(id, status)
                    });
            } else if (status == "completada") {
                var str = role.toLowerCase();
                if (str.indexOf("medico") > -1 || str.indexOf("médico") > -1) {
                    if(contract == 'SI'){
                        $(".contract_validate_2").show();
                        $("#contract_validate_id_2").attr('required',true);
                        $("#contract_validate_id_2").select2({
                            ajax: {
                                dataType: "json",
                                url: "/service/contracts_2",
                                data: {id: service_id, id_patient: patient},
                                processResults: function (data) {
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });
                    }
                    $("#patient_id").val(patient);
                    $("#schedule_id").val(id);
                    $("#status_schedule").val('completada');
                    $("#ModalCenter").modal();
                } else {
                    swal({
                            title: "",
                            text: "¿Desea agregar un seguimiento?",
                            type: "info",
                            showCancelButton: true,
                            cancelButtonText: "No",
                            confirmButtonText: "Si",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                swal.close();
                                if(contract == 'SI'){
                                    $(".contract_validate_2").show();
                                    $("#contract_validate_id_2").attr('required',true);
                                    $("#contract_validate_id_2").select2({
                                        ajax: {
                                            dataType: "json",
                                            url: "/service/contracts_2",
                                            data: {id: service_id, id_patient: patient},
                                            processResults: function (data) {
                                                return {
                                                    results: data
                                                };
                                            }
                                        }
                                    });
                                }
                                $("#patient_id").val(patient);
                                $("#schedule_id").val(id);
                                $("#status_schedule").val('completada');
                                $("#ModalCenter").modal();
                            } else {
                                if(contract == 'SI'){
                                    swal.close()
                                    $("#contract_validate_id").select2({
                                        ajax: {
                                            dataType: "json",
                                            url: "/service/contracts_2",
                                            data: {id: service_id,id_patient:patient},
                                            processResults: function (data) {
                                                return {
                                                    results: data
                                                };
                                            }
                                        }
                                    });
                                    $("#patient_id_2").val(patient);
                                    $("#schedule_id_2").val(id);
                                    $("#ModalCenter_3").modal();
                                    return false;
                                }
                                statusScheduleSubmit(id, status)
                            }

                        });
                }
            } else if (status == "fallida") {
                swal({
                        title: "",
                        text: "¿Está seguro(a) de colocar en estado " + status + " esta cita?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonText: "Si, estoy seguro",
                        closeOnConfirm: false
                    },
                    function(){
                        swal({
                                title: "",
                                text: "Debes agregar un seguimiento",
                                type: "info",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonText: "Continuar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    swal.close();
                                    $("#patient_id").val(patient);
                                    $("#schedule_id").val(id);
                                    $("#status_schedule").val('fallida');
                                    $("#ModalCenter").modal();
                                } else {
                                    //statusScheduleSubmit(id, status)
                                }
                            });
                        //statusScheduleSubmit(id, status)
                    });
            }
        }


        function statusScheduleSubmit(id, status, comment = '') {
            setTimeout(function () {
                swal({
                    title: 'AVISO',
                    text: 'Espere un momento',
                    showCancelButton: false,
                    showConfirmButton: false,
                });
            },200);
            $.ajax({
                async:true,
                type: 'POST',
                url: '/schedule/status',
                dataType: 'json',
                data: "id="+id+"&status="+status+"&comment="+comment,
                statusCode: {
                    201: function(data) {
                        swal({
                                title: "Bien hecho",
                                text: "La cita ha sido " + status,
                                type: "success",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload()
                                }
                            });
                    },
                    202: function(data) {
                        var total = parseInt(data);
                        total = new Intl.NumberFormat().format(total);
                        total = total.replace(/,/g , ".");
                        swal({
                            title: "Lo sentimos",
                            text: "Los ingresos no son suficientes para este contrato y servicio, necesita $"+total,
                            type: "error",
                            closeOnConfirm: true
                        });
                    },
                    203: function(data) {
                        $("#ModalCenter_2").modal('hide');
                        swal({
                                title: "",
                                text: "Debes agregar un seguimiento",
                                type: "info",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonText: "Continuar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    swal.close();
                                    $("#patient_id").val(data);
                                    $("#schedule_id").val(id);
                                    $("#status_schedule").val('cancelada');
                                    $("#ModalCenter").modal();
                                    $("#ModalCenter").on('hidden.bs.modal', function () {
                                        location.reload();
                                    });
                                } else {
                                    location.reload();
                                }
                            });
                    },
                    204: function () {
                        swal('¡Ups!', 'Esta cita ya ha sido completada', 'error')
                    },
                    205: function () {
                        swal('¡Ups!', 'No se ha agregado el consentimiento informado', 'error')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }
    </script>

    <script>
        $('#serviceScheduleEdit').change(function () {
            var service= $(this).val();
            var patient_id = $(this).attr('id_patient');
            $("#contractScheduleEdit").val('');
            //$("#contractScheduleEdit .options").remove();
            $("#contractScheduleEdit").select2({
                ajax: {
                    dataType: "json",
                    url: "/service/contracts_2",
                    data: {id: service,id_patient:patient_id},
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        });

        $('#frmCompletScheduleContract').on('submit', function(e){
            e.preventDefault();
            swal({
                title: 'AVISO',
                text: 'Espere un momento',
                showCancelButton: false,
                showConfirmButton: false,
            });
            $.ajax({
                async:true,
                type: 'POST',
                url: '/schedule/contract',
                dataType: 'json',
                data: $(this).serialize(),
                statusCode: {
                    201: function(data) {
                        statusScheduleSubmit($('#schedule_id_2').val(), 'completada');
                    },
                    202: function(data) {
                        var total = parseInt(data);
                        total = new Intl.NumberFormat().format(total);
                        total = total.replace(/,/g , ".");
                        swal({
                            title: "Lo sentimos",
                            text: "Los ingresos no son suficientes para este contrato y servicio, necesita $"+total,
                            type: "error",
                            closeOnConfirm: true
                        });
                    },
                    400: function (data) {
                        swal('¡Ups!', ''+data.message, 'error')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });

        $('.contract-div').hide();
        $('#contract_id_select').change(function () {
            number_id = $(this).val();
            $('.contract-div').hide();
            $('.contract-div-'+number_id).show();
            //$('.addIncome').click();
            $(".addIncome").prop('checked', false);
            $(".center_cost_contract").removeAttr('required');
            $(".center_value_contract").removeAttr('required');
            $(".center_value_contract").val(0);
            if(number_id == ''){
                $('#center_cost_id').attr('required',true);
                $('#seller_id').attr('required',true);
            }else{
                $("#center_cost_id-"+number_id+"-1").attr('required',true);
                $("#incomeC-"+number_id+"-1").attr('required',true);
                $(".addIncome"+number_id+"-1").prop('checked', true);

                $('#center_cost_id').removeAttr('required');
                $('#seller_id').removeAttr('required');
            }
            /*
            if(parseInt($(this).val()) > 0){
                if ($('.addIncome'+number_id).is(':checked')) {
                }else{
                    $('.addIncome'+number_id).click();
                }
            }else{
                if ($('.addIncome'+number_id).is(':checked')) {
                    $('.addIncome'+number_id).click();
                }
            }
            */
        });
    </script>
@endsection
