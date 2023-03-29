@extends('layouts.show')

@section('content')
    @if ($errors->any())
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <div class="content-his mt-3">
        <form id="typesService" action="{{ route('reservation-date.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <p class="title-form">Editar Bloqueo de cita</p>
            <div class="line-form"></div>
            <input type="hidden" id="user_id" name="user_id" value="{{$value->user_id}}">
            <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="row justify-content-md-center">
                            <div class="col-lg-3 col-md-5 margin-tb">
                                <div class="form-group">
                                    <strong>Personal:</strong>
                                    <select name="responsable_id" id="responsable_id" class="form-control filter-schedule" required>
                                        <option value="">Seleccione</option>
                                        @foreach($user as $u)
                                            <option value="{{$u->id}}" {{($value->responsable_id == $u->id)?'selected':''}}>{{$u->name}} {{$u->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-5 margin-tb">
                                <div class="form-group">
                                    <strong>Opcion de bloqueo:</strong>
                                    <select name="option" id="option" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="horas" {{($value->option == 'horas')?'selected':''}}>Horas</option>
                                        <option value="dias" {{($value->option == 'dias')?'selected':''}}>Dias</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-9 margin-tb date_start_div">
                            <div class="form-group">
                                <strong>Fecha Inicio:</strong>
                                <input type="text" id="date_start" name="date_start" class="form-control datetimepicker" value="{{$value->date_start}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-9 margin-tb date_end_div">
                            <div class="form-group">
                                <strong>Fecha Fin:</strong>
                                <input type="text" id="date_end" name="date_end" class="form-control datetimepicker" value="{{$value->date_end}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-9 margin-tb hour_start_div">
                                <div class="form-group">
                                    <strong>Hora Inicio:</strong>
                                    <select name="hour_start" id="hour_start" class="form-control">
                                        @for($i=6;$i<=12;$i++)
                                            @for($j=0;$j<=55;$j=$j+5)
                                                @php
                                                    $selected = (($i<=9)?'0':'').$i.':'.(($j<=9)?'0':'').$j.':00';
                                                @endphp
                                                <option value="{{$selected}}" {{($selected == $value->hour_start)?'selected':''}}>{{($i<=9)?'0':''}}{{$i}}:{{($j<=9)?'0':''}}{{$j}} {{($i==12)?'PM':'AM'}}</option>
                                            @endfor
                                        @endfor
                                        @php
                                            $cont = 12
                                        @endphp
                                        @for($i=1;$i<=8;$i++)
                                            @php
                                                $cont = $cont + 1
                                            @endphp
                                            @for($j=0;$j<=55;$j=$j+5)
                                                @if($i == 8 and $j>0)
                                                @else
                                                    @php
                                                        $selected = $cont.':'.(($j<=9)?'0':'').$j.':00';
                                                    @endphp
                                                    <option value="{{$selected}}" {{($selected == $value->hour_start)?'selected':''}}>{{($i<=9)?'0':''}}{{$i}}:{{($j<=9)?'0':''}}{{$j}} PM</option>
                                                @endif
                                            @endfor
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-9 margin-tb hour_end_div">
                                <div class="form-group">
                                    <strong>Hora Fin:</strong>
                                    <select name="hour_end" id="hour_end" class="form-control">
                                        @for($i=6;$i<=12;$i++)
                                            @for($j=0;$j<=55;$j=$j+5)
                                                @php
                                                    $selected = (($i<=9)?'0':'').$i.':'.(($j<=9)?'0':'').$j.':00';
                                                @endphp
                                                <option value="{{$selected}}" {{($selected == $value->hour_end)?'selected':''}}>{{($i<=9)?'0':''}}{{$i}}:{{($j<=9)?'0':''}}{{$j}} {{($i==12)?'PM':'AM'}}</option>
                                            @endfor
                                        @endfor
                                        @php
                                            $cont = 12
                                        @endphp
                                        @for($i=1;$i<=8;$i++)
                                            @php
                                                $cont = $cont + 1
                                            @endphp
                                            @for($j=0;$j<=55;$j=$j+5)
                                                @if($i == 8 and $j>0)
                                                @else
                                                    @php
                                                        $selected = $cont.':'.(($j<=9)?'0':'').$j.':00';
                                                    @endphp
                                                    <option value="{{$selected}}" {{($selected == $value->hour_end)?'selected':''}}>{{($i<=9)?'0':''}}{{$i}}:{{($j<=9)?'0':''}}{{$j}} PM</option>
                                                @endif
                                            @endfor
                                        @endfor
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-4 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Motivo:</strong>
                                <textarea class="form-control" name="motiv" rows="3" required>{{$value->motiv}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Observacion:</strong>
                                <textarea class="form-control" name="observation" rows="3">{{$value->observation}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <button type="submit" class="btn btn-primary w-100">Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        setTimeout(function(){
            change();
        },100);
        function change(){
            if($('#option').val() == 'horas'){
                $('.date_end_div').hide();
                $('.date_start_div,.hour_start_div,.hour_end_div').show();
                $('#date_start,#hour_start,#hour_end').attr('required',true);
                $('#date_end').removeAttr('required');
                $('#date_end').val('');
            }else{
                $('.hour_start_div,.hour_end_div').hide();
                $('.date_start_div,.date_end_div').show();
                $('#date_start,#date_end').attr('required',true);
                $('#hour_start,#hour_end').removeAttr('required');
                $('#hour_start,#hour_end').val(0);
            }
        }
        $('.date_start_div,.date_end_div,.hour_start_div,.hour_end_div').hide();
        $('#option').change(()=>{
            if($('#option').val() == 'horas'){
                $('.date_end_div').hide();
                $('.date_start_div,.hour_start_div,.hour_end_div').show();
                $('#date_start,#hour_start,#hour_end').attr('required',true);
                $('#date_end').removeAttr('required');
            }else{
                $('.hour_start_div,.hour_end_div').hide();
                $('.date_start_div,.date_end_div').show();
                $('#date_start,#date_end').attr('required',true);
                $('#hour_start,#hour_end').removeAttr('required');
            }
        })
    </script>
@endsection
