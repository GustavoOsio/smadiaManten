@can('view', \App\Models\PoliciesPatients::class)
    <div role="tabpanel" class="tab-pane fade" id="polizas">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud mb-3">
                    <h2>Polizas</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary clickAddPolizas" style="color:#ffffff">
                        Agregar
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-soft">
            <thead>
            <tr>
                <th>ID</th>
                <th>Contrato</th>
                <th>Servicio</th>
                <th>Responsable</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th width="100px">VER</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $i)
                <tr>
                    <td>CI-{{ $i->id }}</td>
                    <td>C-{{ $i->contract->id }}</td>
                    <td>{{ $i->service->name }}</td>
                    <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                    <td>{{ ucfirst($i->type) }}</td>
                    <td>{{ $i->status }}</td>
                    <td>{{ date("Y-m-d", strtotime($i->created_at)) }}</td>
                    <td>
                        @if($i->type == 'firma')
                            @if($i->status == 'CONFIRMADO')
                                <a id="{{$i->id}}" target="_blank" href="{{url('/policies/pdf/'.$i->id)}}">
                                    <span class="icon-eye ml-2"></span>
                                </a>
                            @else
                                <a id="{{$i->id}}" href="{{$i->link}}">
                                    <span class="icon-eye ml-2"></span>
                                </a>
                            @endif
                        @else
                            <a id="{{$i->id}}" target="_blank" href="{{url($i->file)}}">
                                <span class="icon-eye ml-2"></span>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endcan

<form action="" id="formPolizas">
    <div class="modal fade" id="modalPolizas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Poliza</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <h6>
                                    Contrato:
                                </h6>
                                <select required style="width: 100%" name="contract_polizas" id="contract_polizas" class="form-control filter-schedule">
                                    <option value="">Seleccionar Contrato</option>
                                    @foreach($contracts as $c)
                                        @if($c->status == 'activo')
                                            @php
                                                $saldo = $c->amount - $c->balance;
                                                $consumed = \App\Models\Consumed::where("contract_id",$c->id)->get();
                                                $totalConsumed = 0;
                                                foreach ($consumed as $con) {
                                                    $totalConsumed += $con->amount;
                                                }
                                                $balance = $c->balance - $totalConsumed;
                                            @endphp
                                            @if($balance >= 0)
                                                @if($saldo > 0)
                                                    @php
                                                        $consentC = \App\Models\PoliciesPatients::where('contract_id',$c->id)
                                                        ->whereIn('service_id',[70,69,119,114,1,90,123])
                                                        ->count();
                                                        $itemC = \App\Models\Item::where('contract_id',$c->id)
                                                        ->whereIn('service_id',[70,69,119,114,1,90,123])
                                                        ->count();
                                                    @endphp
                                                    @if($consentC < $itemC)
                                                        <option value="{{$c->id}}">
                                                            C-{{$c->id}}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <h6>
                                    Servicio
                                </h6>
                                <select required style="width: 100%" name="service_polizas" id="service_polizas" class="form-control filter-schedule">
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <h6>
                                    Tipo
                                </h6>
                                <select required style="width: 100%" name="type_polizas" id="type_polizas" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="firma">FIRMA</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                            <div class="form-group file_polizas">
                                <h6>
                                    Archivo
                                </h6>
                                <input style="padding: 0.7% 1%;" type="file" id="file_polizas" name="file_polizas" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <input required type="hidden" id="patient_polizas" name="patient_polizas" value="{{$patient->id}}" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ATRAS</button>
                    <div class="btn btn-primary addPolizas">Agregar</div>
                </div>
            </div>
        </div>
    </div>
</form>
