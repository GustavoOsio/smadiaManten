
@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Detalle comisión pagada</h2>
            </div>

            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionIndex') }}"> Atrás</a>
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
            @if (isset($pagoComision))
            <div>{{$pagoComision}}</div>
            @endif



            <!--Aqui finaliza-->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script></script>
@endsection

