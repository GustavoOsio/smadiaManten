@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Comisión producto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionServicio') }}">Comisión servicio</a>

            </div>

            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionesMedicas.create') }}">Comisión cita</a>

            </div>

            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionesMedicas.create') }}">Comisión profesional</a>
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

    <form id="typesService" action="{{ route('comisionBuscar') }}" method="POST">
        @csrf
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3" style=" display: -webkit-box; " >
            <div class="form-group" style=" margin-right: 10px; " >
                <input type="text" class="form-control"  name="date_start" value="{{$fechaIni}}" placeholder="Fecha inicial" >
            </div>
            <div class="form-group" style=" margin-right: 10px; ">
                <input type="text" class="form-control" name="date_end" value="{{$fechaFin}}" placeholder="Fecha final" >
            </div>
        <div class="form-group" style=" margin-right: 10px; ">

            <select type="text" name="empleado" id="empleado" class="form-control" >
            <option value="" selected>Seleccione vendedor</option>
            @if(isset($medico))
            @foreach ($medico as $medicos)
            <option value="{{$medicos->id_user}}">{{$medicos->title}} {{$medicos->vendedor}} {{$medicos->apellido}}</option>
           @endforeach
           @else
           @foreach ($salesProducto as $medicos)
           <option value="{{$medicos->id_user}}"> {{$medicos->title}} {{$medicos->vendedor}} {{$medicos->apellido}}</option>
          @endforeach

           @endif
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </div>
    </div>


    </form>
    <!--aqui termina el formulario-->

    <div >
        <div class="form-group">
            <!--Aqi va el contenido a mostrar-->
<div>
    <table class="table-striped text-center table-bordered" style="width: 100%; text-align: left; ">
        <thead style="text-align: left;">

            <tr>
                <th>N° cedula</th>
                <th>Vendedor</th>
                <th>Cargo</th>
                <th>Concepto comisión</th>
                <th>Valor comisión</th>

                <th>Acciones</th>
            </tr>
        </thead>
        <tbody style="text-align: left;">
            @foreach ($salesProducto as $item)
            <tr>
                <td>{{$item->cedula}}</td>
                <td>{{$item->vendedor}} {{$item->apellido}}</td>
                <td>{{$item->rol}}</td>
                <td>Comisiones Producto</td>
                <td>${{number_format($item->total)}}</td>

                <td>
                    @if (isset($fechaIni) and isset($fechaFin) and isset($token))
                    <a href="{{ route('comisionDetalle', ['id' => $item->id_user,
                        'fechaIni' => $fechaIni, 'fechaFin' => $fechaFin, 'total'=>$item->total] ) }}">
                                   Ver detalle
                                   </a>
                    @else
                    <a href="{{ route('comisionDetalle2', ['id' => $item->id_user,
                        'total'=>$item->total] ) }}">
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
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script></script>
@endsection
