@extends('layouts.app')

@section('content')
    @component("components.export", ["url"=>url("exports/expenses")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Egresos</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Expenses::class)
                @if($user->id != 26)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @else
                @endif
                    @endcan
            </div>
            <div class="button-new">
                @can('create', \App\Models\Expenses::class)
                    <a class="btn btn-primary" href="{{ route('expenses.create') }}"> Agregar</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table-patients table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>NIT/C.C</th>
            <th>Fecha</th>
            <th>Factura</th>
            <th>Forma de Pago</th>
            <th>Valor Egreso</th>
            <th>IVA Valor</th>
            <th>Centro de Costo</th>
            <th>Total de Egreso</th>
            <th>Realizado por:</th>
            <th>Estado</th>
            <th width="100px">Action</th>
        </tr>
        </thead>
        <tbody>

        <tr class="search-table-input">
            <th>
                <input id="id_expense" value="{{$request->id}}">
            </th>
            <th>
                <input id="provider_expense" value="{{$request->provider}}">
            </th>
            <th>
                <input id="nit_expense" value="{{$request->nit}}">
            </th>
            <th>
                <input id="date_expense" value="{{$request->date}}">
            </th>
            <th>
                <!--
                <input id="purchase_expense" value="{{$request->purchase}}">
                -->
            </th>
            <th>
                <select id="form_pay_expense">
                    <option value="">Seleccionar</option>
                    <option value="efectivo" {{$request->form_pay=='efectivo'?'selected':''}}>Efectivo</option>
                    <option value="consignacion" {{$request->form_pay=='consignacion'?'selected':''}}>Consignacion</option>
                </select>
            </th>
            <th>
                <input class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="value_expense" value="{{$request->value}}">
            </th>
            <th>
                <input class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="iva_expense" value="{{$request->iva}}">
            </th>
            <th>
                <select id="center_cost_expense">
                    <option value="">Seleccionar</option>
                    @foreach($centers as $c)
                        <option value="{{$c->id}}" {{$request->center_cost==$c->id?'selected':''}}>{{$c->name}}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <input class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="total_expense" value="{{$request->total}}">
            </th>
            <th>
                <input id="responsable_expense" value="{{$request->responsable}}">
            </th>
            <th>
                <select id="status_expense">
                    <option value="">Seleccionar</option>
                    <option value="activo" {{$request->status=='activo'?'selected':''}}>Activo</option>
                    <option value="anulado" {{$request->status=='anulado'?'selected':''}}>Anulado</option>
                </select>
            </th>
            <th></th>
        </tr>
        @foreach ($expenses as $ex)
            <tr>
                <td>E-{{ $ex->id }}</td>
                <td>{{ $ex->provider->company }}</td>
                <td>{{ $ex->provider->nit }}</td>
                <td>{{ date("Y-m-d", strtotime($ex->date)) }}</td>
                <td>
                    @if(!empty($ex->purchase->comment))
                        {{$ex->purchase->comment}}
                    @endif
                </td>
                <td>{{ $ex->form_pay }}</td>
                <td>$ {{ number_format($ex->value, 2)  }}</td>
                <td>$ {{ number_format($ex->iva, 2)  }}</td>
                <td>
                    @if(!empty($ex->center->name))
                        {{$ex->center->name}}
                    @endif
                </td>
                <td>$ {{ number_format($ex->total_expense, 2)  }}</td>
                <td>{{ $ex->users->name }} {{ $ex->users->lastname }}</td>
                <td>{{ $ex->status }}</td>
                <td>
                    <form id="form-{{ $ex->id }}" action="{{ route('expenses.destroy',$ex->id) }}" method="POST">
                        <a href="{{ route('expenses.show',$ex->id) }}"><span class="icon-eye"></span></a>
                        <a target="_blank" href="{{ url("/expense/pdf/" . $ex->id) }}"><span class="icon-print-02"></span></a>
                        <!--
                        @can('update', \App\Models\Diagnostic::class)
                            <a class="" href="{{ route('incomes.edit',$ex->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                        -->
                    </form>
                </td>
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
                <th>$ <span class="valor">{{ number_format($value, 0)  }}</span></th>
                <th>$ <span class="iva">{{ number_format($iva, 0)  }}</span></th>
                <th></th>
                <th>$ <span class="total">{{ number_format($value_total, 0)  }}</span></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    {{$expenses->appends([
            'id' => $request->id,
            'provider'=>$request->provider,
            'nit' => $request->nit,
            'date'=>$request->date,
            'purchase'=>$request->purchase,
            'form_pay' => $request->form_pay,
            'value'=>$request->value,
            'iva'=>$request->iva,
            'center_cost'=>$request->center_cost,
            'total'=>$request->total,
            'responsable'=>$request->responsable,
            'status'=>$request->status,
        ])->links()}}

@endsection
@section('script')
    <style>
        .icon-print-02:before{
            color: red !important;
        }
    </style>
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
            $('#date_expense').datepicker({
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

            let $id_expense,$provider_expense,$nit_expense,$date_expense,$purchase_expense,$form_pay_expense;
            let $value_expense,$iva_expense,$center_cost_expense,$total_expense;
            let $responsable_expense,$status_expense;
            $(function () {
                $id_expense = $('#id_expense');
                $provider_expense = $('#provider_expense');
                $nit_expense = $('#nit_expense');
                $date_expense = $('#date_expense');
                $purchase_expense = $('#purchase_expense');
                $form_pay_expense = $('#form_pay_expense');
                $value_expense = $('#value_expense');
                $iva_expense = $('#iva_expense');
                $center_cost_expense = $('#center_cost_expense');
                $total_expense = $('#total_expense');
                $responsable_expense = $('#responsable_expense');
                $status_expense = $('#status_expense');

                $center_cost_expense.change(onChangeFilter);
                $form_pay_expense.change(onChangeFilter);
                $status_expense.change(onChangeFilter);
            });
            $('#id_expense,#provider_expense,#nit_expense,#date_expense,#purchase_expense,#value_expense').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#iva_expense,#total_expense,#responsable_expense').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            function onChangeFilter(){
                location.href = '/expenses?id='+$id_expense.val()+
                    '&provider='+$provider_expense.val()+
                    '&nit='+$nit_expense.val()+
                    '&date='+$date_expense.val()+
                    '&purchase='+$purchase_expense.val()+
                    '&form_pay='+$form_pay_expense.val()+
                    '&value='+$value_expense.val()+
                    '&iva='+$iva_expense.val()+
                    '&center_cost='+$center_cost_expense.val()+
                    '&total='+$total_expense.val()+
                    '&responsable='+$responsable_expense.val()+
                    '&status='+$status_expense.val();
            }

            function formatNumberWrite (obj) {
                var n = $(obj).val();
                n = String(n).replace(/\D/g, "");
                $(obj).val(n === '' ? n : Number(n).toLocaleString());
            }
        });
    </script>
@endsection
