@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Comisión servicio</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionIndex') }}">Comisión producto</a>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionesMedicas.create') }}">Comisión cita</a>
            </div>
        </div>
    </div>
    <!--Aqi se elige el tipo de medico a consultar-->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error}}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form id="typesService" action="{{ route('servicioBuscar') }}" method="POST">
        @csrf
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3" style=" display: -webkit-box; ">
            <div class="form-group" style=" margin-right: 10px; ">
                <input type="text" class="form-control"  name="date_start" value="{{$fechaIni}}" placeholder="Fecha inicial" >
            </div>
            <div class="form-group" style=" margin-right: 10px; ">
                <input type="text" class="form-control" name="date_end" value="{{$fechaFin}}" placeholder="Fecha final" >
            </div>

            <div class="form-group" style=" margin-right: 10px; " >
                <select type="text" name="tipo_comision" id="tipo_comision" class="form-control"  >
                    <option value="" selected>Seleccione tipo comisión</option>
                <option value="por_hacer" >Por hacer</option>
                <option value="por_vender" >Por vender</option>
                </select>
            </div>


            <div class="form-group" style=" margin-right: 10px; " >
            <select type="text" name="empleado" id="empleado" class="form-control"  >
            <option value="" selected>Seleccione profesional</option>
            @if(isset($medico))
            @foreach ($medico as $medicos)
            <option value="{{$medicos->usuario_id}}"> {{$medicos->usuario_id}} {{$medicos->medico}} {{$medicos->medico_apellido}}</option>
           @endforeach
            @else
            @foreach ($comisionContrato as $medicos)
            <option value="{{$medicos->usuario_id}}"> {{$medicos->usuario_id}} {{$medicos->medico}} {{$medicos->medico_apellido}}</option>
            @endforeach
             @endif
            </select>
        </div>
        <div >
            <button type="submit" class="btn btn-primary">Consultar</button>
        </div>

    </div>


    </form>
    <!--aqui termina el formulario-->

    <div >
        <div class="form-group">
            <!--Aqi va el contenido a mostrar-->
<div>
    <table class="table-striped text-center table-bordered" style="width: 100%;">
        <thead style="text-align: left;">

            <tr>
                <th>N° cedula</th>
                <th>Profesional</th>
                <th>Cargo</th>
                <th>Concepto comisión</th>
                <th>Valor comisión</th>

                <th>Acción</th>
            </tr>
        </thead>
        <tbody style="text-align: left;">
            @foreach ($comisionContrato as $item)
            <tr>
                <td>{{$item->cedula}} </td>
                <td>{{$item->medico}} {{$item->medico_apellido}}</td>
                <td>{{$item->cargo}}</td>
                <td>{{$item->tipo_comision}}</td>
                <td>
                    @php
                function calcular_comision($metaHacer, $pComision, $ventaReal) {

                    $p_pago=0;
                    $meta_hacer=$metaHacer;
                    $p_hacer=$pComision;
                    $ventas_reales=$ventaReal;
                    $p_pago=($ventas_reales/$meta_hacer)*$p_hacer;
                    if($p_pago>$p_hacer){
                        $p_pago=$p_hacer;
                    }
                    $comision=$ventas_reales* $p_pago;
                        return $comision;
                    }
                  @endphp

                    ${{number_format(calcular_comision($item->meta_hacer, $item->p_comision, $item->total ))}}
                 </td>

                <td>
                @if(isset($fechaIni) and isset($fechaFin) and isset($token))
                <a href="{{ route('detalle.servicio', ['id' => $item->usuario_id,
                    'fechaIni' => $fechaIni, 'fechaFin' => $fechaFin, 'total'=>
                    calcular_comision($item->meta_hacer, $item->p_comision, $item->total )
                    ] ) }}">
                      Ver detalle
                    </a>
                @else
                <a href="{{ route('detalle.servicio2', ['id' => $item->usuario_id,
                     'total'=>
                     calcular_comision($item->meta_hacer, $item->p_comision, $item->total )
                     ] ) }}">
                      Ver detalle
                    </a>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
            <!--Aqui finaliza-->
      <!--tabla-->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script></script>
@endsection
