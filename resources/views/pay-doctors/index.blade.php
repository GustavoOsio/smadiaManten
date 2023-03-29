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
    @component("components.export_comisiones", ["url"=>url("exports/pay_doctors")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Pago a Doctores</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\PayDoctors::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table id="table-soft-pay-doctors" class="table-patients table-striped">
        <thead>
        <tr>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Asistencial</th>
            <th>Trat. realizado</th>
            <th>Sesion</th>
            <th>Fecha</th>
            <th>Contrato</th>
            <th>Valor Trat.</th>
            <th>Trat. con Descuento</th>
            <th>Pago con Tarjeta</th>
            <th>Deducible</th>
            <th>Valor Final</th>
            <th>Valor Comision</th>
        </tr>
        </thead>
        <tbody>
            <tr class="search-table-input">
                <th>
                    <input id="patient_doctor" value="{{$request->patient}}">
                </th>
                <th>
                    <input id="cc_doctor" value="{{$request->cc}}">
                </th>
                <th>
                    <input id="name_doctor" value="{{$request->name}}">
                </th>
                <th>
                    <input id="treatment_doctor" value="{{$request->treatment}}">
                </th>
                <th>
                    <input id="session_doctor" value="{{$request->sesion}}">
                </th>
                <th>
                    <input id="date_doctor" value="{{$request->date}}">
                </th>
                <th>
                    <input id="contract_doctor" value="{{$request->contract}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="value_doctor" value="{{$request->value}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="desc_doctor" value="{{$request->desc}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="tarjet_doctor" value="{{$request->tarjet}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="deducible_doctor" value="{{$request->deducible}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="total_doctor" value="{{$request->total}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="commission_doctor" value="{{$request->commission}}">
                </th>
            </tr>
            @foreach($payment as $p)
                <tr>
                    <td>{{$p->patient}}</td>
                    <td>{{$p->identification}}</td>
                    <td>{{$p->assistant}}</td>
                    <td>{{$p->service}}</td>
                    <td>{{$p->session}}</td>
                    <td>{{$p->date}}</td>
                    <td>{{$p->contract}}</td>
                    <td>${{number_format($p->price,0,',','.')}}</td>
                    <td>${{number_format($p->discount,0,',','.')}}</td>
                    <td>${{number_format($p->card,0,',','.')}}</td>
                    <td>${{number_format($p->deducible,0,',','.')}}</td>
                    <td>${{number_format($p->totally,0,',','.')}}</td>
                    <td>${{number_format($p->commission,0,',','.')}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="value_tra text-align-center">${{number_format($value_tra,0,',','.')}}</th>
                <th class="desc text-align-center">${{number_format($value_desc,0,',','.')}}</th>
                <th class="tarjet text-align-center">${{number_format($value_tarjet,0,',','.')}}</th>
                <th class="deducible text-align-center">${{number_format($value_deducible,0,',','.')}}</th>
                <th class="total text-align-center">${{number_format($value_total,0,',','.')}}</th>
                <th class="comision text-align-center">${{number_format($value_comision,0,',','.')}}</th>
            </tr>
        </tfoot>
    </table>
    {{$payment->appends([
            'patient'=>$request->patient,
            'cc' => $request->cc,
            'name' => $request->name,
            'treatment' => $request->treatment,
            'sesion' => $request->sesion,
            'date' => $request->date,
            'contract' => $request->contract,
            'value' => $request->value,
            'desc' => $request->desc,
            'tarjet' => $request->tarjet,
            'deducible' => $request->deducible,
            'total' => $request->total,
            'commission' => $request->commission,
        ])->links()}}
@endsection

@section('script')
    <style>
        .text-align-center{
            text-align: center;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#date_doctor').datepicker({
                locale: 'es',
                dateFormat: "yy-mm-dd",
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                weekHeader: 'Sem',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            }).on("change", function (e) {
                onChangeFilter();
            }).on("keypress", function (e) {
                if (e.which == 13) {
                    onChangeFilter();
                }
            });

            let $patient_doctor,$cc_doctor,$name_doctor,$treatment_doctor,$session_doctor,$date_doctor,$contract_doctor;
            let $value_doctor,$desc_doctor,$tarjet_doctor,$deducible_doctor,$total_doctor,$commission_doctor;
            $(function () {
                $patient_doctor = $('#patient_doctor');
                $cc_doctor = $('#cc_doctor');
                $name_doctor = $('#name_doctor');
                $treatment_doctor = $('#treatment_doctor');
                $session_doctor = $('#session_doctor');
                $date_doctor = $('#date_doctor');
                $contract_doctor = $('#contract_doctor');
                $value_doctor = $('#value_doctor');
                $desc_doctor = $('#desc_doctor');
                $tarjet_doctor = $('#tarjet_doctor');
                $deducible_doctor = $('#deducible_doctor');
                $total_doctor = $('#total_doctor');
                $commission_doctor = $('#commission_doctor');
            });

            $('#patient_doctor,#cc_doctor,#name_doctor,#treatment_doctor,#session_doctor,#date_doctor,#contract_doctor').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#value_doctor,#desc_doctor,#tarjet_doctor,#deducible_doctor,#total_doctor,#commission_doctor').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            function onChangeFilter(){
                location.href = '/pay-doctors?patient='+$patient_doctor.val()+
                    '&cc='+$cc_doctor.val()+
                    '&name='+$name_doctor.val()+
                    '&treatment='+$treatment_doctor.val()+
                    '&sesion='+$session_doctor.val()+
                    '&date='+$date_doctor.val()+
                    '&contract='+$contract_doctor.val()+
                    '&value='+$value_doctor.val()+
                    '&desc='+$desc_doctor.val()+
                    '&tarjet='+$tarjet_doctor.val()+
                    '&deducible='+$deducible_doctor.val()+
                    '&total='+$total_doctor.val()+
                    '&commission='+$commission_doctor.val();
            }

            function formatNumberWrite (obj) {
                var n = $(obj).val();
                n = String(n).replace(/\D/g, "");
                $(obj).val(n === '' ? n : Number(n).toLocaleString());
            }
        });
    </script>
@endsection
