@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Detalle comisión producto</h2>
            </div>

            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionIndex') }}"> Atrás</a>
            </div>


            <div class="button-new">

                @if ( isset($token) )
                <a class="btn btn-primary" href="{{ route('comision.pago', ['id' => $id,
                    'fechaIni'=>'0', 'fechaFin'=>'0']) }}">Pagar comisión</a>
                @else
                <a class="btn btn-primary" href="{{ route('comision.pago', ['id' => $id,
                    'fechaIni'=>$fechaIni, 'fechaFin'=>$fechaFin]) }}">Pagar comisión</a>
                @endif

            </div>

            <div class="button-new">
                @if ( isset($token) )
                <a class="btn btn-primary" href="{{ route('comision.descartar', ['id' => $id,
                    'fechaIni'=>'0', 'fechaFin'=>'0']) }}">Descartar comisión</a>
                @else
                <a class="btn btn-primary" href="{{ route('comision.descartar', ['id' => $id,
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
                <th>Vendedor</th>
                <th>Cargo</th>
                <th>Paciente</th>
                <th>Linea</th>
                <th>Producto</th>
                <th>Valor producto</th>
                <th>Tipo pago</th>
                <th>% No deducible</th>
                <th>% Descuento por targeta</th>
                <th>% De comision</th>
                <th>Valor base comisionable</th>
                <th>Valor comisión</th>
            </tr>
        </thead>
        <tbody style="text-align: left;">
            @foreach ($detalle as $item)
            <tr>
                <td>{{$item->fecha}}</td>
                <td>{{$item->vendedor}} {{$item->apellido}}</td>

                <td>{{$item->rol}}</td>
                <td>{{$item->paciente}}</td>
                <td>{{$item->linea}}</td>
                <td>{{$item->producto}}</td>
                <td>{{number_format($item->valor)}}</td>
                <td>{{$item->method_payment}}</td>
                <td>{{$item->no_deducible*100}}</td>
                <td>{{$item->p_tarjeta*100}}</td>
                <td>{{$item->p_comision*100}}</td>
                <td>${{number_format($item->valor_base_comisionable)}}</td>
                <td>${{number_format($item->valor_comision)}}</td>

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
