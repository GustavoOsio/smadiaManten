@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Asignar servicios comisionar</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('users.index') }}">Atrás</a>

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

    <form id="typesService" action="{{ route('comision.storeServ') }}" method="POST">
        @csrf

        <!--Componente con el listado de servicios-->
        <input type="hidden" name="id" value="{{$id}}">
        <div class="form-group" style=" margin-right: 10px; ">
            <select type="text" name="servicio" id="servicio" class="form-control" >
            <option value="" selected>Seleccione servicio</option>
           @foreach ($servicio as $item)
           <option value="{{$item->id}}"> {{$item->servicio}} valor:({{$item->valor}}) Por_hacer:({{$item->contrato}})</option>
          @endforeach
            </select>
        </div>

        <div class="form-group" style=" margin-right: 10px; ">
            <select type="text" name="tipo" id="tipo" class="form-control" >
            <option value="" selected>Tipo bono</option>
           <option value="por_hacer">Por hacer</option>
           <option value="por_vender">Por vender</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </div>

        <div class="form-group">
            <!--Aqi va la tabla de servicios asignados a comisionar-->
<div>
    <table class="table-striped text-center table-bordered" style="width: 100%; text-align: left; ">
        <thead style="text-align: left;">

            <tr>
                <th>Item</th>
                <th>Profesional</th>
                <th>Servicio</th></th>
                <th>Precio</th>
                <th>Concepto comisión</th>
                <th>contrato</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody style="text-align: left;">


                @foreach ($lista as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->nombre}} {{$item->apellido}}</td>
                <td>{{$item->servicio}}</td>
                <td>{{number_format($item->precio)}}</td>
                <td>{{$item->tipo}}</td>
                <td>{{$item->contrato}}</td>
               <td>{{$item->estado}}</td>
               <td><a class="btn btn-primary" href="{{ route('delete.servicio',['id'=>$id, 'id_d'=>$item->id]) }}">
                Eliminar
            </a>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

            <!--Aqui finaliza-->
        </div>


    </div>


    </form>
    <!--aqui termina el formulario-->

    <div >

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script></script>
@endsection



