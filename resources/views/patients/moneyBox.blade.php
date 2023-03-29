@can('view', \App\Models\Income::class)
    <div role="tabpanel" class="tab-pane fade" id="moneyBox">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud mb-3">
                    <h2>Dinero en Caja</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary clickHistorial" style="color:#ffffff">
                        Historial
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>ID</th>
                <th>Vendedor</th>
                <th>Responsable</th>
                <th>Monto</th>
                <th>Comentario</th>
                <th>Forma de pago</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th width="100px">Editar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($moneyBox as $i)
                @php
                    $method_pay = ucfirst($i->method_of_pay);
                    if($i->method_of_pay_2 != ''){
                        $method_pay = $method_pay .'/'.ucfirst($i->method_of_pay_2);
                    }
                @endphp
                <tr>
                    <td>I-{{ $i->id }}</td>
                    <td>{{ $i->seller->name . " " . $i->seller->lastname }}</td>
                    <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                    <td>{{ number_format($i->amount, 2) }}</td>
                    <td>{{ $i->comment }}</td>
                    <td>{{ ucfirst($method_pay) }}</td>
                    <td>{{ $i->status }}</td>
                    <td>{{ $i->created_at }}</td>
                    <td>
                        @can('update', \App\Models\Contract::class)
                            <a class="editMoneyBox" id="{{$i->id}}" data-id="{{$i->id}}"  money="{{str_replace(',','.',number_format($i->amount,0))}}">
                                <span class="icon-icon-11 ml-2"></span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <form action="" id="updateIncomeMoneyBox">
    <div class="modal fade" id="modalMoneyBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Asignar Ingreso</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <input required type="hidden" value="" id="income_id" name="income_id">
                            </div>
                            <div class="form-group">
                                <h6>
                                    Total de ingreso:
                                </h6>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input required type="text" id="money" name="money" readonly class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <h6>
                                    Dinero a ingresar:
                                </h6>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input required type="text" onkeyup="amounMoneyBoxChange(this)" id="cant_money" name="cant_money" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <h6>
                                    Aplicar a Contrato:
                                </h6>
                                <select required style="width: 100%" name="contract_id" id="contract_id" class="form-control filter-schedule">
                                    <option value="">Seleccionar Contrato</option>
                                    @foreach($contracts as $c)
                                        @if($c->balance < $c->amount && $c->status == 'activo')
                                            @php
                                                $total = $c->amount -  $c->balance;
                                            @endphp
                                            <option value="{{$c->id}}">
                                                C-{{$c->id}}
                                                - Total: ${{str_replace(',','.',number_format($c->amount,0))}}
                                                Pendiente: ${{str_replace(',','.',number_format($total,0))}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <h6 style="position: relative" class="mt-4">
                                    Aplicar a otro paciente (por defecto selecciona el mismo paciente)
                                    <div style="position: absolute;right: 0%;top: 0%"
                                         data-toggle="modal"
                                         data-target="#ModalPatient">
                                        <span class="icon-search"></span>
                                    </div>
                                </h6>
                                <input required type="hidden" id="patient_id" name="patient_id" value="{{$patient->id}}" readonly class="form-control">
                                <input required type="text" id="patient_name" name="patient_name" value="{{$patient->name}} {{$patient->lastname}}" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ATRAS</button>
                    <div class="btn btn-primary updateIncomeMoneyBox">Actualizar Ingreso</div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="modal fade" id="ModalPatient" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitleP" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitleP">Buscar paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmPatientSearchMoneyBox">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="patient" id="patientMoneyBox" placeholder="Cédula o celular (Al menos 3 digitos)">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mt-2" id="submitPatientSearchMoneyBox"><span class="icon-search"></span></div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped" id="resultsPatientSearch">
                        <thead>
                        <th class="fl-ignore">Cédula</th>
                        <th class="fl-ignore">Nombre</th>
                        <th class="fl-ignore">Celular</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane fade" id="moneyBoxHistorial">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud mb-3">
                    <h2>Historial Dinero en Caja</h2>
                </div>
            </div>
        </div>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>ID</th>
                <th>Vendedor</th>
                <th>Responsable</th>
                <th>Monto</th>
                <th>Comentario</th>
                <th>Forma de pago</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th width="100px">VER</th>
            </tr>
            </thead>
            <tbody>
            @foreach($moneyBoxHistorial as $i)
                @php
                    $method_pay = ucfirst($i->method_of_pay);
                    if($i->method_of_pay_2 != ''){
                        $method_pay = $method_pay .'/'.ucfirst($i->method_of_pay_2);
                    }
                @endphp
                <tr>
                    <td>I-{{ $i->id }}</td>
                    <td>{{ $i->seller->name . " " . $i->seller->lastname }}</td>
                    <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                    <td>{{ number_format($i->amount, 2) }}</td>
                    <td>{{ $i->comment }}</td>
                    <td>{{ ucfirst($method_pay) }}</td>
                    <td>{{ $i->status }}</td>
                    <td>{{ $i->created_at }}</td>
                    <td>
                        @can('update', \App\Models\Contract::class)
                            <a href="{{url('incomes/'.$i->id)}}">
                                <span class="icon-eye"></span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endcan
