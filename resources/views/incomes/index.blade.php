@extends('layouts.app')
@section('style')
    <style>
        .icon-print-02:before {
            color: #fb8e8e;
            font-size: 16pt;
        }
    </style>
@endsection
@section('content')
    @component("components.export", ["url"=>url("exports/incomes")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Ingresos</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Income::class)
                @if($user->id != 26)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @else
                
                @endif
                    @endcan
            </div>


<table class="table-patients table-striped">
    
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>$ <span class="valor">{{ number_format($value_total, 2)  }}</span></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Cédula</th>
                <th>Valor</th>
                <th>Descripción</th>
                <th>Centro de costo</th>
                <th>Forma de pago</th>
                <th>Fecha</th>
                <th>Cuenta Bancaria</th>
                <th>Numero Aprobación</th>
                <th>Contrato</th>
                <th>Vendedor</th>
                <th>Responsable</th>
                <th>Seguimiento</th>
                <th>Estado</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        <tr class="search-table-input">
            <th>
                <input id="id_income" value="{{$request->id}}">
            </th>
            <th>
                <input id="patient_income" value="{{$request->patient}}">
            </th>
            <th>
                <input id="cc_income" value="{{$request->cc}}">
            </th>
            <th>
                <input class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="value_income" value="{{$request->value}}">
            </th>
            <th>
                <input id="description_income" value="{{$request->description}}">
            </th>
            <th>
                <select id="center_cost_income">
                    <option value="">Seleccionar</option>
                    @foreach($centers as $c)
                        <option value="{{$c->id}}" {{$request->center_cost==$c->id?'selected':''}}>{{$c->name}}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <select id="form_pay_income">
                    <option value="">Seleccionar</option>
                    <option value="efectivo" {{$request->form_pay=='efectivo'?'selected':''}}>Efectivo</option>
                    <option value="tarjeta" {{$request->form_pay=='tarjeta'?'selected':''}}>Tarjeta</option>
                    <option value="consignacion" {{$request->form_pay=='consignacion'?'selected':''}}>Consignacion</option>
                    <option value="tarjeta recargable" {{$request->form_pay=='tarjeta recargable'?'selected':''}}>Tarjeta recargable</option>
                    <option value="software" {{$request->form_pay=='software'?'selected':''}}>Software</option>
                    <option value="online" {{$request->form_pay=='online'?'selected':''}}>Online</option>
                    <option value="tranferencia" {{$request->form_pay=='tranferencia'?'selected':''}}>Tranferencia</option>
                    <option value="unificacion" {{$request->form_pay=='unificacion'?'selected':''}}>Unificacion</option>
                    <option value="white" {{$request->form_pay=='white'?'selected':''}}>White</option>
                    <option value="sistecredito" {{$request->form_pay=='sistecredito'?'selected':''}}>Sistecredito</option>
                </select>
            </th>
            <th>
                <input id="date_income" value="{{$request->date}}">
            </th>
            <th>
                <!--<input id="account_bank_income" value="{{$request->account_bank}}">-->
            </th>
            <th>
                <input id="number_aprov_income" value="{{$request->number_aprov}}">
            </th>
            <th>
                <input id="contract_income" value="{{$request->contract}}">
            </th>
            <th>
                <input id="seller_income" value="{{$request->seller}}">
            </th>
            <th>
                <input id="responsable_income" value="{{$request->responsable}}">
            </th>
            <th>
                <select id="follow_income">
                    <option value="">Seleccionar</option>
                    <option value="0">No aplica</option>
                    @foreach($follows as $f)
                        @if ($f->id == 28 || $f->id == 40 || $f->id == 29 || $f->id == 26 || $f->id == 82)
                            <option value="{{$f->id}}" {{$request->follow==$f->id?'selected':''}}>{{$f->name}} {{$f->lastname}}</option>
                        @endif
                    @endforeach
                </select>
            </th>
            <th>
                <select id="status_income">
                    <option value="">Seleccionar</option>
                    <option value="activo" {{$request->status=='activo'?'selected':''}}>Activo</option>
                    <option value="anulado" {{$request->status=='anulado'?'selected':''}}>Anulado</option>
                </select>
            </th>
            <th></th>
        </tr>
        @foreach ($incomes as $income)
            @php
                $method_pay = ucfirst($income->method_of_pay);
                if($income->method_of_pay_2 != ''){
                    $method_pay = $method_pay .'/'.ucfirst($income->method_of_pay_2);
                }
                $validate_1 = true;
                $validate_2 = true;
            @endphp
            @if($income->method_of_pay_2 != '')
                @if($request->form_pay != '')
                    @php
                        $validate_1 = false;
                        $validate_2 = false;
                    @endphp
                    @if($request->form_pay == $income->method_of_pay)
                        @php
                            $validate_1 = true;
                        @endphp
                    @endif
                    @if($request->form_pay == $income->method_of_pay_2)
                        @php
                            $validate_2 = true;
                        @endphp
                    @endif
                @endif
                @if($validate_1 == true)
                <tr>
                    <td>I-{{ $income->id }}</td>
                    <td class="openPatientdDC" id="{{$income->patient_id}}">{{ $income->patient->name . " " . $income->patient->lastname }}</td>
                    <td>{{ $income->patient->identy }}</td>
                    <td>$ {{ number_format($income->amount_one, 2)  }}</td>
                    <td>{{ $income->comment }}</td>
                    @if($income->center_cost_id != '')
                        <td>{{ $income->center->name }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ ucfirst($income->method_of_pay) }}</td>
                    <td>{{ date("Y-m-d", strtotime($income->created_at)) }}</td>
                    <td>
                        @if($income->account_id != '')
                            {{ $income->account->account }}
                        @endif
                    </td>
                    <td>{{ $income->approved_of_card }}</td>
                    <td>{{ ($income->contract) ? "C-" . $income->contract->id : "" }}</td>
                    <td>{{ $income->seller->name . " " . $income->seller->lastname }}</td>
                    <td>{{ $income->responsable->name . " " . $income->responsable->lastname }}</td>
                    @if($income->follow_id != 0)
                        <td>{{ $income->follow->name . " " . $income->follow->lastname }}</td>
                    @else
                        <td>No aplica</td>
                    @endif
                    <td>{{ $income->status }}</td>
                    <td>
                        <form id="form-{{ $income->id }}" action="{{ route('incomes.destroy',$income->id) }}" method="POST">
                            <a href="{{ route('incomes.show',$income->id) }}"><span class="icon-eye"></span></a>
                            <a target="_blank" href="{{ url("/incomes/pdf/" . $income->id) }}"><span class="icon-print-02"></span></a>
                        </form>
                    </td>
                </tr>
                @endif
                @if($validate_2 == true)
                <tr>
                    <td>I-{{ $income->id }}</td>
                    <td class="openPatientdDC" id="{{$income->patient_id}}">{{ $income->patient->name . " " . $income->patient->lastname }}</td>
                    <td>{{ $income->patient->identy }}</td>
                    <td>$ {{ number_format($income->amount_two, 2)  }}</td>
                    <td>{{ $income->comment }}</td>
                    @if($income->center_cost_id != '')
                        <td>{{ $income->center->name }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ ucfirst($income->method_of_pay_2) }}</td>
                    <td>{{ date("Y-m-d", strtotime($income->created_at)) }}</td>
                    <td>
                        @if($income->account_2_id != '')
                            {{ $income->account2->account }}
                        @endif
                    </td>
                    <td>{{ $income->approved_of_card_2 }}</td>
                    <td>{{ ($income->contract) ? "C-" . $income->contract->id : "" }}</td>
                    <td>{{ $income->seller->name . " " . $income->seller->lastname }}</td>
                    <td>{{ $income->responsable->name . " " . $income->responsable->lastname }}</td>
                    @if($income->follow_id != 0)
                        <td>{{ $income->follow->name . " " . $income->follow->lastname }}</td>
                    @else
                        <td>No aplica</td>
                    @endif
                    <td>{{ $income->status }}</td>
                    <td>
                        <form id="form-{{ $income->id }}" action="{{ route('incomes.destroy',$income->id) }}" method="POST">
                            <a href="{{ route('incomes.show',$income->id) }}"><span class="icon-eye"></span></a>
                            <a target="_blank" href="{{ url("/incomes/pdf/" . $income->id) }}"><span class="icon-print-02"></span></a>
                        </form>
                    </td>
                </tr>
                @endif
            @else
                <tr>
                    <td>I-{{ $income->id }}</td>
                    <td class="openPatientdDC" id="{{$income->patient_id}}">{{ $income->patient->name . " " . $income->patient->lastname }}</td>
                    <td>{{ $income->patient->identy }}</td>
                    <td>$ {{ number_format($income->amount, 2)  }}</td>
                    <td>{{ $income->comment }}</td>
                    @if($income->center_cost_id != '')
                        <td>{{ $income->center->name }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ ucfirst($method_pay) }}</td>
                    <td>{{ date("Y-m-d", strtotime($income->created_at)) }}</td>
                    <td>
                        @if($income->account_id != '')
                            {{ $income->account->account }}
                        @endif
                    </td>
                    <td>{{ $income->approved_of_card }}</td>
                    <td>{{ ($income->contract) ? "C-" . $income->contract->id : "" }}</td>
                    <td>{{ $income->seller->name . " " . $income->seller->lastname }}</td>
                    <td>{{ $income->responsable->name . " " . $income->responsable->lastname }}</td>
                    @if($income->follow_id != 0)
                        <td>{{ $income->follow->name . " " . $income->follow->lastname }}</td>
                    @else
                        <td>No aplica</td>
                    @endif
                    <td>{{ $income->status }}</td>
                    <td>
                        <form id="form-{{ $income->id }}" action="{{ route('incomes.destroy',$income->id) }}" method="POST">
                            <a href="{{ route('incomes.show',$income->id) }}"><span class="icon-eye"></span></a>
                            <a target="_blank" href="{{ url("/incomes/pdf/" . $income->id) }}"><span class="icon-print-02"></span></a>
                        </form>
                    </td>
                </tr>
            @endif
        @endforeach
        <tfoot>
        
        </tfoot>
        </tbody>
    </table>

        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    
    {{$incomes->appends([
            'id' => $request->id,
            'patient'=>$request->patient,
            'cc' => $request->cc,
            'value'=>$request->value,
            'description' => $request->description,
            'center_cost'=>$request->center_cost,
            'form_pay'=>$request->form_pay,
            'date'=>$request->date,
            'account_bank'=>$request->account_bank,
            'number_aprov'=>$request->number_aprov,
            'contract'=>$request->contract,
            'seller'=>$request->seller,
            'responsable'=>$request->responsable,
            'follow'=>$request->follow,
            'status'=>$request->status,

            
        ])->links()}}
@endsection

@section('script')
    <style>
        .table-patients{
            background: #ffffff !important;
        }
        .table-patients thead th{
            padding: 0px 5px !important;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#date_income').datepicker({
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

            let $id_income,$patient_income,$cc_income,$value_income,$description_income,$center_cost_income;
            let $form_pay_income,$date_income,$contract_income,$seller_income;
            let $responsable_income,$follow_income,$status_income,$number_aprov;
            $(function () {
                $id_income = $('#id_income');
                $patient_income = $('#patient_income');
                $cc_income = $('#cc_income');
                $value_income = $('#value_income');
                $description_income = $('#description_income');
                $center_cost_income = $('#center_cost_income');
                $form_pay_income = $('#form_pay_income');
                $date_income = $('#date_income');
                $contract_income = $('#contract_income');
                $seller_income = $('#seller_income');
                $responsable_income = $('#responsable_income');
                $follow_income = $('#follow_income');
                $status_income = $('#status_income');
                $number_aprov = $('#number_aprov_income');

                $center_cost_income.change(onChangeFilter);
                $form_pay_income.change(onChangeFilter);
                $follow_income.change(onChangeFilter);
                $status_income.change(onChangeFilter);
            });
            $('#id_income,#patient_income,#cc_income,#value_income,#description_income,#date_income,#number_aprov_income').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#contract_income,#contract_income,#seller_income,#responsable_income').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            function onChangeFilter(){
                location.href = '/incomes?id='+$id_income.val()+
                    '&patient='+$patient_income.val()+
                    '&cc='+$cc_income.val()+
                    '&value='+$value_income.val()+
                    '&description='+$description_income.val()+
                    '&center_cost='+$center_cost_income.val()+
                    '&form_pay='+$form_pay_income.val()+
                    '&date='+$date_income.val()+
                    '&contract='+$contract_income.val()+
                    '&seller='+$seller_income.val()+
                    '&responsable='+$responsable_income.val()+
                    '&follow='+$follow_income.val()+
                    '&status='+$status_income.val()+
                    '&number_aprov='+$number_aprov.val();
            }

            function formatNumberWrite (obj) {
                var n = $(obj).val();
                n = String(n).replace(/\D/g, "");
                $(obj).val(n === '' ? n : Number(n).toLocaleString());
            }
        });
    </script>
@endsection
