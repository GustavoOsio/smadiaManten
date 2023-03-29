@can('view', \App\Models\InformedConsents::class)
    <div role="tabpanel" class="tab-pane fade" id="informedConsents">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud mb-3">
                    <h2>Consentimientos Informados</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary clickAddInformedConsents" style="color:#ffffff">
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
            @foreach($informedConsents as $i)
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
                                <a id="{{$i->id}}" target="_blank" href="{{url('/informed_consents/pdf/'.$i->id)}}">
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

<form action="" id="formInformedConsents">
    <div class="modal fade" id="modalInformedConsents" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Consentimiento Informado</h5>
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
                                <select required style="width: 100%" name="contract_informed_consents" id="contract_informed_consents" class="form-control filter-schedule">
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
                                                        $consentC = \App\Models\InformedConsents::where('contract_id',$c->id)->count();
                                                        $itemC = \App\Models\Item::where('contract_id',$c->id)->count();
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
                                <select required style="width: 100%" name="service_informed_consents" id="service_informed_consents" class="form-control filter-schedule">
                                    <option value="">Seleccionar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <h6>
                                    Tipo
                                </h6>
                                <select required style="width: 100%" name="type_informed_consents" id="type_informed_consents" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="firma">FIRMA</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                            <div class="form-group file_informed_consents">
                                <h6>
                                    Archivo
                                </h6>
                                <input style="padding: 0.7% 1%;" type="file" id="file_informed_consents" name="file_informed_consents" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <input required type="hidden" id="patient_informed_consents" name="patient_informed_consents" value="{{$patient->id}}" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ATRAS</button>
                    <div class="btn btn-primary addInformedConsents">Agregar</div>
                </div>
            </div>
        </div>
    </div>
</form>
