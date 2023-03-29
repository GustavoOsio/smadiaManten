@extends('layouts.app')

@section('content')
    @component('components.exportComisiones', ['url' => url('exports/exportComisiones')])
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Asignar adicionales</h2>
            </div>
            <div class="button-new">
              <!--  <a class="btn btn-primary" href="{{ route('users.index') }}">Atrás</a>-->
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
    <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
        <h2>Adicionales</h2>
        <div>
            @if (isset($estado))
                <h1>{{ $estado }}</h1>
            @endif

        </div>
    </div>


    <!--Componente con el listado de servicios-->
    <!--Campos agregados-->
    <form id="adicional" method="POST" action="{{ route('comision.adicional') }}">
        @csrf
        <div class="col-xs-12 col-sm-12 col-md-6 ">
               <div class="form-group">
                <select name="concepto" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="Obsequio">Obsequio</option>
                    <option value="Deducible">Deducible porcentaje</option>
                    <option value="Deducible_valor">Deducible valor</option>
                    <option value="Otro">Otro</option>
                </select>
                <input type="hidden" value="{{ $budget_id }}" id="budget_id" name="budget_id">
                <div class="input-group">
                    <input type="number" name="valor" class="form-control" id="valor" placeholder="Valor" required>
                </div>

                <div class="form-group">
                    <textarea name="coment" rows="4" class="form-control" placeholder="Descripción"></textarea>
                </div>
            </div>

            <div class="button-new">
                <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        </div>
    </form>
    <!--Fin obsequios-->

    <!--Aqi va la tabla de servicios asignados a comisionar-->
    <div style="margin-top: 80px">
        <table class="table-striped text-center table-bordered" style="width: 100%; text-align: left; ">
            <thead style="text-align: left;">

                <tr>

                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody style="text-align: left;">

                @foreach ($adicional as $item)
                    <tr>

                        <td>{{$item->concepto }}</td>
                        <td>{{$item->valor }}</td>
                        <td>{{$item->comentario }}</td>
                        <td>
                         <a href=" {{route('comision.deleteForm',['id'=>$item->id, 'id_date=>'=> $budget_id])}} " >Eliminar</a>
                        </td>
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
