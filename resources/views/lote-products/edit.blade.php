@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Lote de Producto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('lote-products.index') }}"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form id="typesService" action="{{ route('lote-products.update',$purchase) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Editar</p>
        <div class="line-form"></div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Compra:</strong>
                    <input type="text" class="form-control" disabled required value="CP-{{$purchase->id}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Factura:</strong>
                    <input type="text" class="form-control" disabled required value="{{$purchase->bill}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Cantidad Total:</strong>
                    <input type="number" class="form-control" disabled required value="{{collect($product)->sum("qty")}}">
                </div>
            </div>
            @php
                $sumVal=0;
            @endphp
            @foreach ($product as $prod2)
                @php
                    $sumVal=$sumVal+($prod2->full_amount=='0'||$prod2->full_amount==''?$prod2->qty:$prod2->full_amount);
                @endphp
            @endforeach
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Cantidad Total Encargados:</strong>
                    <input type="number"  class="form-control" disabled required value="{{$sumVal}}">
                </div>
            </div>
        </div>

        @php
           $conRow=1;
        @endphp
        @foreach ($product as $prod)
    <p class="title-prod">Producto # {{$conRow}}</p>
            @php
                $interspersed=" row-interspersed";
                if($conRow%2==0){
                    $interspersed=" ";
                }
                $conRow++;
            @endphp

            <div class="row{{$interspersed}}">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <strong>Nombre del producto:</strong>
                        <input type="hidden" name="purchase_products_id[]" class="form-control" required value="{{$prod->id}}">
                        <input type="text"  class="form-control" disabled value="{{$prod->product->name}}">
                    </div>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <strong>Lote:</strong>
                        <input type="text" name="lote[]" class="form-control" required value="{{$prod->lote}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <strong>Fecha de vencimiento:</strong>
                        <input type="text" name="expiration[]" class="form-control datetimepicker" required value="{{$prod->expiration}}">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <strong>Cantidad:</strong>
                        <input type="hidden" name="qty[]" class="form-control" required value="{{number_format($prod->qty,'.00')}}">
                        <input type="number" class="form-control" disabled value="{{number_format($prod->qty,'.00')}}">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <strong>Cantidad faltante:</strong>
                        <input type="text" name="missing[]" class="form-control{{$prod->missing==0?"":" purchase_missing"}}"  required value="{{$prod->missing}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="form-group">
                        <strong>Cantidad Encargada:</strong>
                        <input type="hidden" name="full_amount[]" class="form-control" required value="{{number_format($prod->full_amount=='0'||$prod2->full_amount==''?$prod->qty:$prod->full_amount,'.00')}}">
                        <input type="text" class="form-control" disabled value="{{number_format($prod->full_amount=='0'||$prod2->full_amount==''?$prod->qty:$prod->full_amount,'.00')}}">
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <button type="submit" class="btn btn-primary">Editar</button>
        </div>
    </form>

@endsection



{{-- @extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Lote de Producto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('lote-products.index') }}"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form id="typesService" action="{{ route('lote-products.update',$product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre del producto:</strong>
                    <input type="hidden" name="purchase_products_id" class="form-control" required value="{{$product->id}}">
                    <input type="text"  class="form-control" disabled value="{{$products->name}}">
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Lote:</strong>
                    <input type="text" name="lote" class="form-control" required value="{{$product->lote}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Fecha de vencimiento:</strong>
                    <input type="text" name="expiration" class="form-control datetimepicker" required value="{{$product->expiration}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Compra:</strong>
                    <input type="text" class="form-control" disabled required value="CP-{{$product->purchase->id}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Factura:</strong>
                    <input type="text" class="form-control" disabled required value="CP-{{$product->purchase->bill}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Cantidad:</strong>
                    <input type="number" name="qty" class="form-control" disabled required value="{{$product->qty}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Cantidad faltante:</strong>
                    <input type="hidden" name="full_amount" class="form-control" required value="{{$product->full_amount=='0'?$product->qty:$product->full_amount}}">
                    <input type="text" name="missing" class="form-control" required value="{{$product->missing}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>


    </form>

@endsection --}}
