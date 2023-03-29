@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Detalle comisión servicio </h2>
            </div>

            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionServicio') }}"> Atrás</a>
            </div>
            <div class="button-new">

                @if ( isset($token) )
                <a class="btn btn-primary" href="{{ route('comision.pagarServ', ['id' => $id,
                    'fechaIni'=>'0', 'fechaFin'=>'0']) }}">Pagar comisión</a>
                @else
                <a class="btn btn-primary" href="{{ route('comision.pagarServ', ['id' => $id,
                    'fechaIni'=>$fechaIni, 'fechaFin'=>$fechaFin]) }}">Pagar comisión</a>
                @endif


            </div>

            <div class="button-new">
                @if ( isset($token) )
                <a class="btn btn-primary" href="{{ route('comision.descartarServ', ['id' => $id,
                    'fechaIni'=>'0', 'fechaFin'=>'0']) }}">Descartar comisión</a>
                @else
                <a class="btn btn-primary" href="{{ route('comision.descartarServ', ['id' => $id,
                    'fechaIni'=>$fechaIni, 'fechaFin'=>$fechaFin]) }}">Descartar comisión</a>
                @endif
            </div>

            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionServicio') }}">Descargar excel</a>
            </div>
        </div>
    </div>
    <!--Aqi se elige el tipo de medico a consultar-->
    <form id="typesService" action="{{ route('comisionBuscar') }}" method="POST">
        @csrf




    </form>
    <!--aqui termina el formulario-->

    <div >
        <div class="form-group">
            <!--Aqi va el contenido a mostrar-->
            <DIV>
              <h2>Total comisión: ${{number_format($total)}}</h2>
            </DIV>


<div>
    <table class="table-striped text-center table-bordered" style="width: 100%;">
        <thead style="text-align: left;">

            <tr>
                <th>Fecha</th>
                <th>Profesional</th>
                 <th>Cargo</th>
                <th>Paciente</th>
                <th>Contrato</th>
                <th>Servicio</th>
                <th>Capital</th>
                <th>Abono</th>
                <th>Medio pago</th>
                <th>% Descuento tarjeta</th>
                <th>% Comisión</th>
                <th>Descuento</th>

                <th>Valor base comisionable</th>

            </tr>
        </thead>
        <tbody style="text-align: left;" >
            @foreach ($detalle as $item)
            <tr>
                <td>{{$item->fecha_cita}}</td>
                <td>{{$item->medico}} {{$item->medico_apellido}} </td>
                 <td>{{$item->cargo}}</td>
                <td>{{$item->paciente}} {{$item->paciente_apellido}}</td>
                <td>{{$item->contrato}}</td>
                <td>{{$item->servicio}}</td>
                <td>{{number_format($item->capital)}}</td>
                <td>{{number_format($item->abono)}}</td>
                <td>{{$item->medio_pago}}</td>
                <th>{{$item->p_tarjeta*100}}</th>
                <th>{{$item->p_comision*100}}</th>
                <th>${{number_format($item->insumo + $item->obsequio+$item->otro )}}</th>
                  <td>${{number_format($item->valor_base_comisionable)}}</td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>

            <!--Aqui finaliza-->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script></script>
@endsection
