@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Orden de pedido</h2>
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


    <form id="formOrderPurchase" method="POST">
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
                                <select name="products[]" id="product-1" class="form-control filter-schedule" data-id="1" required>
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

            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <label class="c-primary fw5">Recibe</label>
                        <div class="form-group">
                            <select name="receive_id" required class="form-control">
                                <option value="">Seleccionar</option>
                                @foreach($users as $u)
                                    <option value="{{$u->id}}">{{ucfirst($u->name .' '.$u->lastname)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <label class="c-primary fw5">Area</label>
                        <div class="form-group">
                            <select name="area" required class="form-control">
                                @foreach($areas as $a)
                                    <option value="{{str_replace(' ','-',$a->name)}}">{{ucfirst($a->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-5">
                <div class="row">
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
                            <button type="submit" class="btn btn-primary">Guardar orden de pedido</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection
@section('script')
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
    </script>
    <style>
        .select2{
            width: 100% !important;
        }
    </style>
@endsection
