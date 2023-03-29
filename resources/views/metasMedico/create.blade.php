@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Comisiones</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comisionesMedicas.index') }}"> Atrás</a>
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

        <form id="typesService" action="{{ route('comisionesMedicas.store') }}" method="POST">
            @csrf

            <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Escoger medico:</strong>
                    <select type="text" name="medico" id="medico" class="form-control" required> 
                    <option value="" selected>Seleccione medico</option>
                    @foreach ($medicos as $medicos)
                    <option value="{{$medicos->id}}">{{$medicos->title}} {{$medicos->name}} {{$medicos->lastname}}</option>
                   @endforeach
                    </select>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Meta mensual:</strong>
                    <input value="" type="number" value="0" name="metaMensual" id="metaMensual" class="form-control" required>
                </div>
            </div>



            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="activo">
                    <strong>Activo</strong> <button type="button" class="btn btn-sm btn-toggle status active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            
        </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong></strong>
                                <input type="hidden" name="numberList" id="numberList" class="form-control" readonly required>
                                <input type="hidden" name="numberList1" id="numberList1" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        
       

            <div class="expenses-add1">
                <div class="form-expensesProd">
                    <div class="row">
                    <div class="separator"></div>
        <p class="title-form">Tabla de comisiones</p>
        <div class="line-form"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                               <table>
                                   <thead>
                                       <tr>
                                           <th>emcabezado</th>
                                       </tr>
                                   </thead>
                               </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>


      
       
       
        </form>
    </div>
    <style>
        .expenses-add{
            width: 100%;
        }
        .expenses-add1{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
        .deleteNew1 i{
            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        var optionProduct = ''
    </script>
    @foreach ($services as $services => $pro)
        <script>
            optionProduct = optionProduct + '<option value="{{$pro->id}}">{{$pro->name}}</option>'
        </script>
    @endforeach
    <script>
        var numberList = 1,idDelete= 1,arv=1,numberList1 = 1;
        $('#numberList').val(numberList);        
        $('#numberList1').val(numberList);
        function deleteNew(id){
            idDelete = id;
            $('.form-expenses'+idDelete).remove(); 
            var numberList = $('#numberList').val();
            numberList = numberList - 1;            
            $('#numberList').val(numberList);
        }
        function deleteNew1(id){
            idDelete = id;
            $('.form-expensesProd'+idDelete).remove(); 
            var numberList = $('#numberList1').val();
            numberList = numberList - 1;            
            $('#numberList1').val(numberList);
        }
        $( document ).ready(function() {
            $('.deleteNew').click(function () {

            });

            $('.deleteNew1').click(function () {

            });

            $('#add-new').click(function () {
                var numberList = $('#numberList').val();
                numberList = parseInt(numberList) + 1;
                $('#numberList').val(numberList);
                $('.expenses-add').append('' +
                    '               <div class="form-expenses'+numberList+'">\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-4 col-md-3 margin-tb">\n' +
                    '                                    <div class="title-crud" style="border: 0; text-align: center; float: none">\n' +
                    '                                        <h4 class="deleteNew" onclick="deleteNew('+numberList+');" id="'+numberList+'"><i class="fas fa-trash-alt"></i> Eliminar</h4>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-12 col-md-12 margin-tb"></div>'+
                    '                                <div class="col-lg-3 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Seleccione procedimiento:</strong>\n' +
                    '                                        <select onchange="changeVector('+numberList+');" name="Ventaservice'+numberList+'" id="Ventaservice'+numberList+'" class="form-control filter-schedule mt-3" >\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProduct +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Porcentaje desde:</strong>\n' +
                    '                                        <input value="" type="number" name="ventasPorcentajeDesde'+numberList+'" id="ventasPorcentajeDesde'+numberList+'" class="form-control" >\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Porcentaje Hasta:</strong>\n' +
                    '                                        <input value="" type="number" name="ventasPorcentajeHasta'+numberList+'" id="ventasPorcentajeHasta'+numberList+'" class="form-control" >\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Porcentaje de comision:</strong>\n' +
                    '                                        <input type="number" name="ventasPorcentajeComision'+numberList+'" id="ventasPorcentajeComision'+numberList+'" class="form-control" >\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');
                   
            });
        
        
            $('#add-new1').click(function () {
                
                var numberList = $('#numberList1').val();
                numberList = parseInt(numberList) + 1;
                $('#numberList1').val(numberList);
                $('.expenses-add1').append('' +
                    '               <div class="form-expensesProd'+numberList+'">\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-4 col-md-3 margin-tb">\n' +
                    '                                    <div class="title-crud" style="border: 0; text-align: center; float: none">\n' +
                    '                                        <h4 class="deleteNew1" onclick="deleteNew1('+numberList+');" id="'+numberList+'"><i class="fas fa-trash-alt"></i> Eliminar</h4>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-12 col-md-12 margin-tb"></div>'+
                    '                                <div class="col-lg-3 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Seleccione procedimiento:</strong>\n' +
                    '                                        <select onchange="changeVector1('+numberList+');" name="prodService'+numberList+'" id="prodService'+numberList+'" class="form-control filter-schedule" >\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProduct +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Porcentaje desde:</strong>\n' +
                    '                                        <input value="" type="number" name="prodPorcentajeDesde'+numberList+'" id="prodPorcentajeDesde'+numberList+'" class="form-control" >\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Porcentaje Hasta:</strong>\n' +
                    '                                        <input value="" type="number" name="prodPorcentajeHasta'+numberList+'" id="prodPorcentajeHasta'+numberList+'" class="form-control" >\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Porcentaje de comision:</strong>\n' +
                    '                                        <input type="number" name="prodPorcentajeComision'+numberList+'" id="prodPorcentajeComision'+numberList+'" class="form-control">\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Comision Meta:</strong>\n' +
                    '                                        <input type="number" name="prodComisionMeta'+numberList+'" id="prodComisionMeta'+numberList+'" class="form-control">\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');
            });
        
        });

        
    </script>
@endsection