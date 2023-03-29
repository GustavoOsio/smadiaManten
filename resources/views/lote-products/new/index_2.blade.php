@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Lista de Recepcion de pedido</h2>
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
            <th>Creado por</th>
            <th>Observaciones</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th width="100px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orderReceipt as $key => $o)
            <tr>
                <td>RP-{{ $o->id }}</td>
                <td>{{ ucwords(mb_strtolower($o->user->name . " " . $o->user->lastname)) }}</td>
                <td>{{ $o->observations }}</td>
                <td>{{ ucfirst($o->status) }}</td>
                <td>{{ date("Y-m-d", strtotime($o->created_at)) }}</td>
                <td>
                    @can('view', \App\Models\LoteProducts::class)
                        <a href="{{ route('order-receipt.show',$o->id) }}"><span class="icon-eye"></span></a>
                    @endif
                    @if($o->status == 'creada')
                        @can('update', \App\Models\LoteProducts::class)
                            <a class="" href="{{ url('order-receipt/edit_2/'.$o->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
