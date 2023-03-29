@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Asignar parametro</h2>
            </div>
            <div class="button-new">

              <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>

            </div>
        </div>
    </div>
    <!--Aqi se elige el tipo de medico a consultar-->
<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
    <!--Componente con el listado de servicios -->
    <!--Campos agregados-->
    <form id="adicional" method="POST" action="{{route('editar.parametro')}}">
        @csrf
        <div class="col-xs-12 col-sm-12 col-md-6 ">

            <label class="c-primary fw5">Parametros</label>
            <div class="form-group">
                <select name="parametro" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="tarjeta">% Pagos tarjeta</option>
                    <option value="online">% Pagos online</option>

                  </select>

                <div class="input-group" style="margin-top: 50px">
                    <input type="number" name="valor" class="form-control" id="valor"
                    placeholder="Valor" required>

                </div>

            </div>

            <div class="button-new">
                <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
    </form>
    <!--Fin obsequios-->

    <!--Aqi va la tabla de servicios asignados a comisionar-->
    <div style="margin-top: 80px">
        <table class="table-striped text-center table-bordered" style="width: 100%; text-align: left; ">
            <thead style="text-align: left;">

                <tr>

                    <th>Tipo</th>
                    <th>Porcentaje</th>
                    <th>Concepto</th>
                    <th>Etado</th>
                </tr>
            </thead>

            <tbody style="text-align: left;">

               @foreach ( $parametro as $item )
               <tr>
                <td>{{$item->tipo}}</td>
                <td>{{$item->porcentaje *100}}%</td>
                <td>{{$item->concepto}}</td>
                <td>{{$item->estado}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <!--Aqui finaliza-->
    </div>


    </div>


    <!--aqui termina el formulario-->

    <div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script></script>
@endsection
