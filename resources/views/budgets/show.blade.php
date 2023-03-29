@extends('layouts.app')

@section('content')
    <form id="frmConvertContract">
        @csrf
        <input type="hidden" name="id" value="{{ $budget->id }}">
        <div class="row mb-4">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud">
                    <h2>Presupuesto P-{{ $budget->id }}</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary" href="{{ url("/patients/" . $budget->patient_id) }}"> Atrás</a>
                </div>
                <div class="float-right">
                    <a target="_blank" href="{{ url("/budget/pdf/" . $budget->id) }}"><div class="btn btn-primary" style="background: #FB8E8E;"><span class="icon-print-02"></span> Imprimir</div></a>
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
                <th class="fl-ignore">Total</th>
                <th class="fl-ignore">Estado</th>
                <th class="fl-ignore">Fecha</th>
                <th class="fl-ignore">Elaborado por</th>
                <th class="fl-ignore">Vendido por</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ ucwords(mb_strtolower($budget->patient->name . " " . $budget->patient->lastname, "UTF-8")) }}</td>
                <td>{{ $budget->patient->identy }}</td>
                <td>{{ $budget->patient->cellphone }}</td>
                <td>$ {{ number_format($budget->amount, 2) }}</td>
                <td>{{ ucfirst($budget->status) }} {!! ($budget->status == "activo") ? '<span class="icon-act-03"></span>' : '' !!}</td>
                <td>{{ date("Y-m-d", strtotime($budget->created_at)) }}</td>
                <td>{{ $budget->user->name . " " . $budget->user->lastname }}</td>
                <td>{{ $budget->seller->name . " " . $budget->seller->lastname }}</td>
            </tr>
            </tbody>
        </table>

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Observaciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $budget->comment }}</td>
            </tr>
            </tbody>
        </table>

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Fecha</th>
                <th class="fl-ignore">Servicio</th>
                <th class="fl-ignore">Sessiones</th>
                <th class="fl-ignore">Vlr x sessión</th>
                <th class="fl-ignore">Dscto %</th>
                <th class="fl-ignore">Valor descontado</th>
                <th class="fl-ignore">Valor total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($budget->items as $s)
                <tr>
                    <td>{{ date("Y-m-d", strtotime($budget->created_at)) }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->qty }}</td>
                    <td>$ {{ number_format($s->price, 0,',','.') }}</td>
                    <td>{{ number_format($s->percent, 0,',','.') }}%</td>
                    <td>$ {{ number_format($s->discount_value, 0,',','.') }}</td>
                    <td>$ {{ number_format($s->total, 0,',','.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div>
            <h1>Adicionales</h1>
            <hr>
            <table class="table-striped text-center table-bordered" style="width: 100%; text-align: left; ">
                <thead style="text-align: left;">

                    <tr>
                        <th>Item</th>
                        <th>Concepto</th>
                        <th>Valor</th>
                        <th>Comentario</th>

                    </tr>
                </thead>

                <tbody style="text-align: left;">

                    @foreach ($adicional as $item)
                        <tr>
                            <td>1</td>
                            <td>{{$item->concepto }}</td>
                            <td>{{$item->valor }}</td>
                            <td>{{$item->comentario }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            </div>


        <div class="row justify-content-md-center mt-5">
            <div class="col-md-2">
                @if ($budget->status == "activo")
                    @can('update', \App\Models\Contract::class)
                        <button class="btn btn-primary convertirContract" style="background: #23c876;">Convertir a contrato</button>
                    @endcan
                @endif
            </div>
        </div>
    </form>
@endsection



@section('script')
    <script>
        $('.convertirContract').click(function () {
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea convertir a contrato?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $('#frmConvertContract').submit();
                    }
                });
            return false;
        });
    </script>
@endsection
