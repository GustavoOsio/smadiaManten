@extends('layouts.app')

@section('content')
@component("components.exportComisiones", ["url"=>url("exports/exportComisiones")]) @endcomponent
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Metas por linea de servicio</h2>
            </div>
            <div class="button-new">
                                    <a class="btn btn-primary" href="{{ url('/metaServiceCreate') }}"> Crear</a>
            
            </div>
            
            <div class="button-new">
                
                    <button id="BotonExportar" class="btn btn-primary" data-toggle="modal" data-target="#ModalExport" disabled> Exportar</button>

            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Escoger servicio:</strong>
                    <select type="text" name="servicio" id="servicio" class="form-control" required> 
                    <option value="" selected>Seleccione Servicio</option>
                    @foreach ($servicios as $servicio)
                    <option value="{{$servicio->id}}">{{$servicio->name}}</option>
                   @endforeach
                    </select>
                </div>
            </div>










<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$('#medico').on('change', function() {
    var medico = this.value;

    $('#BotonExportar').prop('disabled', false);
    $('#idMedico').val(medico);

});




</script>

@endsection
