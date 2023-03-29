@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Crear requision</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\RequisitionsCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions.index') }}">Atras</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form  action="{{ route('requisitions.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Informacion</p>
        <div class="line-form"></div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-9 margin-tb">
                        <div class="form-group">
                            <strong></strong>
                            <input type="hidden" name="numberList" id="numberList" class="form-control" readonly required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="diagnostics-add">
                <div class="form-diagnostic">
                    <div class="col-xs-12 col-sm-12 col-md-12  col-lg-12 mt-3">
                        <div class="row justify-content-md-center">
                            <div class="col-lg-3 col-md-5 margin-tb">
                                <div class="form-group">
                                    <strong>Categoria:</strong>
                                    <select name="category1" id="category1" id-element="1" class="form-control category" required>
                                        <option value="">Seleccione</option>
                                        @foreach($category as $c)
                                            <option value="{{$c->id}}" id-category="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-5 margin-tb">
                                <div class="form-group">
                                    <strong>Producto:</strong>
                                    <select name="product1" id="product1" class="form-control product" required>
                                        <option value="">Seleccione</option>
                                        @foreach($products as $p)
                                            <option class="id-category{{$p->requisition_category_id}}" value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-md-3 margin-tb">
                        <div class="title-crud" style="border: 0; text-align: center; float: none">
                            <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Producto</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-center">
                    <div class="col-lg-7 col-md-9 margin-tb">
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            <textarea class="form-control" name="observations" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                <div class="row justify-content-md-center">
                    <div class="col-lg-2 col-md-3 margin-tb">
                        <button type="submit" class="btn btn-primary w-100">Crear</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <style>
        .diagnostics-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>
    <script>
        var optionCategorySelect = ''
    </script>
    @foreach($category as $c)
        <script>
            optionCategorySelect = optionCategorySelect + '<option value="{{$c->id}}" id-category="{{$c->id}}">{{$c->name}}</option>';
        </script>
    @endforeach
    <script>
        var optionProductSelect = ''
    </script>
    @foreach($products as $p)
        <script>
            optionProductSelect = optionProductSelect + '<option class="id-category{{$p->requisition_category_id}}" value="{{$p->id}}">{{$p->name}}</option>';
        </script>
    @endforeach
    <script>
        var numberList = 1,idDelete= 1,arv=1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        scriptAr[1] = "si";
        arv = scriptAr.toString();
        $('#numberList').val(arv);
        function deleteNew(id){
            idDelete = id;
            $('.form-diagnostic'+idDelete).remove();
            scriptAr[id] = "no";
            arv = scriptAr.toString();
            $('#numberList').val(arv);
        }

        $( document ).ready(function() {
            $('#add-new').click(function () {
                numberList = numberList + 1;
                scriptAr[numberList] = "si";
                arv = scriptAr.toString();
                $('#numberList').val(arv);
                $('.diagnostics-add').append('' +
                    '<div class="form-diagnostic'+numberList+'">\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-4 col-md-3 margin-tb">\n' +
                    '                                    <div class="title-crud" style="border: 0; text-align: center; float: none">\n' +
                    '                                        <h4 class="deleteNew" onclick="deleteNew('+numberList+');" id="'+numberList+'"><i class="fas fa-trash-alt"></i> Eliminar</h4>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n'+
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Categoria:</strong>\n' +
                    '                                        <select onchange="changeSelect('+numberList+');" name="category'+numberList+'" id="category'+numberList+'" id-element="'+numberList+'" class="form-control category" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +optionCategorySelect+
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Producto:</strong>\n' +
                    '                                        <select name="product'+numberList+'" id="product'+numberList+'" class="form-control product" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +optionProductSelect+
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>');
                $('#product'+numberList+ ' option').hide();
            });
        });
        $('.product option').hide();
        $('.category').change(function () {
            var idelement=$(this).attr('id-element');
            var option = $('#category'+idelement+ ' option:selected').attr('id-category');
            $('#product'+idelement+ ' option').hide();
            $('#product'+idelement+ ' .id-category'+option).show();
        });
        function changeSelect(idelement){
            var option = $('#category'+idelement+ ' option:selected').attr('id-category');
            $('#product'+idelement+ ' option').hide();
            $('#product'+idelement+ ' .id-category'+option).show();
        }
    </script>
@endsection
