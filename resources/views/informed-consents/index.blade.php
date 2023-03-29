@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Consentimientos Informados</h2>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Contrato</th>
            <th>Servicio</th>
            <th>Responsable</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th width="100px">VER</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $i)
            <tr>
                <td>CI-{{ $i->id }}</td>
                <td>C-{{ $i->contract->id }}</td>
                <td>{{ $i->service->name }}</td>
                <td>{{ $i->responsable->name . " " . $i->responsable->lastname }}</td>
                <td>{{ ucfirst($i->type) }}</td>
                <td>{{ $i->status }}</td>
                <td>{{ date("Y-m-d", strtotime($i->created_at)) }}</td>
                <td>
                    @if($i->type == 'firma')
                        @if($i->status == 'CONFIRMADO')
                            <a id="{{$i->id}}" target="_blank" href="{{url('/informed_consents/pdf/'.$i->id)}}">
                                <span class="icon-eye ml-2"></span>
                            </a>
                        @else
                            <a id="{{$i->id}}" href="{{$i->link}}">
                                <span class="icon-eye ml-2"></span>
                            </a>
                        @endif
                    @else
                        <a id="{{$i->id}}" target="_blank" href="{{url($i->file)}}">
                            <span class="icon-eye ml-2"></span>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
