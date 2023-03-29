@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Historial Ajuste de Inventario</h2>
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
            <th>Nombre</th>
            <th>Lote</th>
            <th>Fecha de expiracion</th>
            <th>Cantidad</th>
            <th>Cantidad en inventario</th>
            <th>Observacion</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($inventory as $i)
            <tr>
                <td>P-{{$i->id}}</td>
                <td>{{$i->product->name}}</td>
                <td>{{$i->lote}}</td>
                <td>{{ date("Y-m-d", strtotime($i->expiration)) }}</td>
                <td>{{number_format($i->qty,0)}}</td>
                <td>{{number_format($i->qty_inventory,0)}}</td>
                <td>
                    @php
                        $observation = \App\Models\InventoryAdjustmentObservation::where('purchase_product_id',$i->id)->first();
                    @endphp
                    @if(!empty($observation))
                        {{$observation->observations}}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('script')
@endsection
