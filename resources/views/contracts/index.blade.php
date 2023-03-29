@extends('layouts.app')

@section('content')
    @component("components.export", ["url"=>url("exports/contracts")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Contratos</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Contract::class)
                @if ($user->id != 26)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @else 
                
                @endif
                    @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft-contracts" class="table-patients table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Cédula</th>
                <th>Valor</th>
                <th>Saldo</th>
                <th>Saldo a favor</th>
                <th>Descripción</th>
                <th>Vendedor</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th width="120px">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="search-table-input">
                <th>
                    <input id="id_contract" value="{{$request->id}}">
                </th>
                <th>
                    <input id="patient_contract" value="{{$request->patient}}">
                </th>
                <th>
                    <input id="cc_contract" value="{{$request->cc}}">
                </th>
                <th>
                    <input class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="value_contract" value="{{$request->value}}">
                </th>
                <th>
                </th>
                <th>
                </th>
                <th>
                    <input id="description_contract" value="{{$request->description}}">
                </th>
                <th>
                    <input id="seller_contract" value="{{$request->seller}}">
                </th>
                <th>
                    <input id="responsable_contract" value="{{$request->responsable}}">
                </th>
                <th>
                    <select id="status_contract">
                        <option value="">Seleccionar</option>
                        <option value="activo" {{$request->status=='activo'?'selected':''}}>Activo</option>
                        <option value="sin confirmar" {{$request->status=='sin confirmar'?'selected':''}}>Sin Confirmar</option>
                        <option value="liquidado" {{$request->status=='liquidado'?'selected':''}}>Liquidado</option>
                        <option value="anulado" {{$request->status=='anulado'?'selected':''}}>Anulado</option>
                    </select>
                </th>
                <th>
                    <input id="date_contract" value="{{$request->date}}">
                </th>
                <th></th>
            </tr>
        @foreach ($contracts as $contract)
            <tr>
                <td>C-{{ $contract->id }}</td>
                <td class="openPatientdDC" id="{{$contract->patient_id}}">{{ $contract->patient->name . " " . $contract->patient->lastname }}</td>
                <td>{{ $contract->patient->identy }}</td>
                <td>$ {{ number_format($contract->amount, 2) }}</td>
                <td>$ {{ number_format($contract->amount - $contract->balance, 2) }}</td>
                @php
                    $consumed = \App\Models\Consumed::where("contract_id",$contract->id)->get();
                    $totalConsumed = 0;
                    foreach ($consumed as $c) {
                        $totalConsumed += $c->amount;
                    }
                    $balance = $contract->balance - $totalConsumed;
                @endphp
                <td>
                    $ {{ number_format($balance, 0,',','.') }}
                </td>
                <td>{{ $contract->comment }}</td>
                <td>{{ $contract->seller->name . " " . $contract->seller->lastname }}</td>
                <td>{{ $contract->user->name . " " . $contract->user->lastname }}</td>
                <td>{{ ucfirst($contract->status) }}</td>
                <td>{{ date("Y-m-d", strtotime($contract->created_at)) }}</td>
                <td>
                    <form id="form-{{ $contract->id }}" action="{{ route('contracts.destroy',$contract->id) }}" method="POST">
                        <a href="{{ route('contracts.show',$contract->id) }}"><span class="icon-eye"></span></a>
                    @can('update', \App\Models\Contract::class)
                        @if ($contract->status == "sin confirmar")
                            <a class="" href="{{ route('contracts.edit',$contract->id) }}"><span class="icon-icon-11 ml-2"></span></a>
                        @endif
                    @endcan
                    @can('delete', \App\Models\Contract::class)
                        @csrf
                        @method('DELETE')
                        @if ($contract->status == "sin confirmar")
                            <a href="#" class="form-submit" data-id="form-{{ $contract->id }}"><span class="icon-icon-12"></span></a>
                        @endif
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$contracts->appends([
        'id' => $request->id,
        'patient'=>$request->patient,
        'cc' => $request->cc,
        'value'=>$request->value,
        'description' => $request->description,
        'seller'=>$request->seller,
        'responsable'=>$request->responsable,
        'status'=>$request->status,
        'date'=>$request->date,
    ])->links()}}

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#date_contract').datepicker({
                locale: 'es',
                dateFormat:"yy-mm-dd",
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['D','L','M','M','J','V','S'],
                weekHeader: 'Sem',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            }).on("change", function (e) {
                onChangeFilter();
            }).on("keypress", function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            let $id_contract,$patient_contract,$cc_contract,$value_contract,$description_contract,$seller_contract;
            let $responsable_contract,$status_contract,$date_contract;
            $(function () {
                $id_contract = $('#id_contract');
                $patient_contract = $('#patient_contract');
                $cc_contract = $('#cc_contract');
                $value_contract = $('#value_contract');
                $description_contract = $('#description_contract');
                $seller_contract = $('#seller_contract');
                $responsable_contract = $('#responsable_contract');
                $status_contract = $('#status_contract');
                $date_contract = $('#date_contract');

                $status_contract.change(onChangeFilter);
            });
            $('#id_contract,#patient_contract,#cc_contract,#value_contract,#description_contract,#seller_contract').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#responsable_contract,#date_contract').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            function onChangeFilter(){
                location.href = '/contracts?id='+$id_contract.val()+
                    '&patient='+$patient_contract.val()+
                    '&cc='+$cc_contract.val()+
                    '&value='+$value_contract.val()+
                    '&description='+$description_contract.val()+
                    '&seller='+$seller_contract.val()+
                    '&responsable='+$responsable_contract.val()+
                    '&status='+$status_contract.val()+
                    '&date='+$date_contract.val();
            }

            function formatNumberWrite (obj) {
                var n = $(obj).val();
                n = String(n).replace(/\D/g, "");
                $(obj).val(n === '' ? n : Number(n).toLocaleString());
            }
        });
    </script>
@endsection
