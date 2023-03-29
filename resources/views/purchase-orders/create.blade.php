@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Orden de compra</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
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


    <form id="formPurchaseOrder" method="POST">
        @csrf
        {{--<div class="separator"></div>--}}
        {{--<p class="title-form">Rellenar</p>--}}
        {{--<div class="line-form"></div>--}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
                <table class="table">
                    <thead>
                        {{--<th>Tipo</th>--}}
                        <th class="fl-ignore">Producto</th>
                        <th class="fl-ignore">Cantidad</th>
                        <th class="fl-ignore"></th>
                    </thead>
                    <tbody id="tableToModify">
                        <tr id="rowToClone-1">
                            {{--<td>
                                <select name="type[]" id="type-1" class="form-control" data-id="1" required>
                                    <option value="P/O">P/O</option>
                                    <option value="A/C">A/C</option>
                                    <option value="PRO">PRO</option>
                                </select>
                            </td>--}}
                            <td>
                                <select name="products[]" id="product-1" class="form-control filter-schedule-1" data-id="1" required>
                                    <option value="">Seleccione</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td width="70">
                                <div class="input-group">
                                    <input type="text" name="qty[]" id="qty-1" placeholder="" class="form-control" onkeypress="return soloNumeros(event);" required>
                                </div>
                            </td>
                            <td><span class="icon-close closeRow" onclick="closeRow(1)"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4 col-md-2"></div>
            <div class="col-xs-12 col-sm-12 col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <label for="validationTooltip" class="c-primary font-weight-bold">Quien recibe</label>
                        <div class="form-group">
                            <select name="receive_id" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach($sellers as $s)
                                    @if (\Illuminate\Support\Facades\Auth::id() === $s->id)
                                        <option selected value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                                    @else
                                        <option value="{{ $s->id }}">{{ $s->name . " " . $s->lastname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationTooltip" class="c-primary font-weight-bold">Proveedor</label>
                        <div class="form-group">
                            <select name="provider_id" id="provider_id" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach($providers as $p)
                                    <option value="{{ $p->id }}">{{ $p->nit . " - " . $p->company }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationTooltip" class="c-primary font-weight-bold">Medio de pago</label>
                        <div class="form-group">
                            <select name="method_of_payment" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="cheque">Cheque</option>
                                <option value="pago online">Pago Online</option>
                                <option value="consignacion">Consignación</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationTooltip" class="c-primary font-weight-bold">Forma de pago</label>
                        <div class="form-group">
                            <select name="way_of_payment" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="contado">Contado</option>
                                <option value="credito">Credito</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <label for="validationTooltip" class="c-primary font-weight-bold">Lugar de entrega</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="delivery" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="c-primary fw5">Observaciones</label>
                        <div class="form-group">
                            <textarea name="comment" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-4 ">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-8 margin-tb">
                        <div class="title-crud" id="cloneRowOrder">
                            <h4><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar producto</h4>
                        </div>
                        <div class="button-new">
                            <button type="submit" class="btn btn-primary">Guardar orden de compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection
@section('script')
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        function closeRow(pos) {
            var eliminar = document.getElementById("rowToClone-" + pos);
            var contenedor= document.getElementById("tableToModify");
            contenedor.removeChild(eliminar);
        }

        function soloNumeros(e)
        {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;
            return /\d/.test(String.fromCharCode(keynum));
        }
        $( ".filter-schedule-1" ).select2({
        });
    </script>
@endsection
