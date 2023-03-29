@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Requisiciones</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Requisitions::class)
                    <a class="btn btn-primary" href="{{ route('requisitions.create') }}">Nueva requisición</a>
                @endcan
            </div>
            <div class="button-new">
                @can('create', \App\Models\RequisitionsCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions-category.index') }}">Categorias</a>
                @endcan
            </div>
            <div class="button-new">
                @can('create', \App\Models\RequisitionsProductCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions-product-category.index') }}">Productos</a>
                @endcan
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
                <th>Observaciones</th>
                <th>Cant. productos</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requisitions as $requi)
                @php
                 $pro = \App\Models\RequisitionsProducts::where('requisition_id',$requi->id)->count();
                @endphp
                <tr>
                    <td>REQ-{{$requi->id}}</td>
                    <td>{{$requi->observations}}</td>
                    <td>{{$pro}}</td>
                    <td>{{$requi->status}}</td>
                    <td>{{date("Y-m-d", strtotime($requi->created_at))}}</td>
                    <td>
                        <form id="form-{{ $requi->id }}" action="{{ route('requisitions.destroy',$requi->id) }}" method="POST">
                            @can('update', \App\Models\Requisitions::class)
                                <a class="" href="{{ route('requisitions.edit',$requi->id) }}"><span class="icon-icon-11"></span></a>
                            @endcan
                            @can('delete', \App\Models\Requisitions::class)
                                @csrf
                                @method('DELETE')
                                <a href="#" class="form-submit" data-id="form-{{ $requi->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
