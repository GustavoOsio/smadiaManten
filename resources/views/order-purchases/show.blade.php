@extends('layouts.app')

@section('content')
    <form id="frmApprovedPurchaseOrder">
        @csrf
        <input type="hidden" name="id" value="{{ $purchase->id }}">
        <!--
        <div class="modal fade" id="ModalOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalOrderTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalOrderTitle">Convertir a orden de compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Recibe:</strong>
                                    <select class="form-control" required name="receive_id">
                                        @foreach($sellers as $user)
                                            @if ($user->id == $purchase->receive_id)
                                                <option selected value="{{ $user->id }}">{{ ucwords(mb_strtolower($user->name . " " . $user->lastname, "UTF-8")) }}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{ ucwords(mb_strtolower($user->name . " " . $user->lastname, "UTF-8")) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Proveedor:</strong>
                                    <select class="form-control" required name="provider_id">
                                        <option value="">Seleccione</option>
                                        @foreach($providers as $p)
                                            <option value="{{ $p->id }}">{{ ucwords(mb_strtolower($p->company, "UTF-8")) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="delivery" class="form-control" minlength="3" maxlength="80" placeholder="Lugar de entrega" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="comment" class="form-control" minlength="10" rows="5" required>{{ $purchase->comment }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" >Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        -->
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Orden de pedido OP-{{ $purchase->id_order }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            {{--<div class="float-right">--}}
                {{--<a target="_blank" href="{{ url("/purchase/pdf/" . $purchase->id) }}"><div class="btn btn-primary" style="background: #FB8E8E;"><span class="icon-print-02"></span> Imprimir</div></a>--}}
            {{--</div>--}}
        </div>
    </div>

    <div class="separator"></div>
    <p class="title-form">Datos</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="fl-ignore">ID</th>
                <th class="fl-ignore">Estado</th>
                <th class="fl-ignore">Fecha</th>
                <th class="fl-ignore">Elaborado por</th>
                <th class="fl-ignore">Recibe</th>
                <th class="fl-ignore">Area</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>OP-{{ $purchase->id_order }}</td>
                <td>{{ ucfirst($purchase->status) }} </td>
                <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->receive->name . " " . $purchase->receive->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->area)) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Observaciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $purchase->comment }}</td>
        </tr>
        </tbody>
    </table>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Tipo</th>
            <th class="fl-ignore">Producto</th>
            <th class="fl-ignore">Cantidad</th>
            <th class="fl-ignore">Restante</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchase->products as $p)
            <tr>
                <td>{{ $p->type }}</td>
                <td>{{ $p->product->name }}</td>
                <td>{{ intval($p->qty) }}</td>
                <td>{{ $p->qty - $p->missing }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!--
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-5">
                @if ($purchase->status == "pedido")
                    @can('create', \App\Models\PurchaseOrder::class)
                        <div class="convertPurchaseOrder" data-toggle="modal" data-target="#ModalOrder" data-id="{{ $purchase->id }}"><button class="btn btn-primary" type="button" style="background: #23c876;">Convertir en orden de compra</button></div>
                    @endcan
                @endif
            </div>
        </div>
    -->
    </form>
@endsection
