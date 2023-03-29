<br>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="title-crud mb-3">
            <h2>Bloqueo de agenda</h2>
        </div>
        <div class="button-new">
            @can('view', \App\Models\ReservationDate::class)
                <a href="{{url('reservation-date')}}">
                    <button class="btn btn-primary"> Bloqueo de citas</button>
                </a>
            @endcan
        </div>
    </div>
</div>

<table id="table-soft-schedules_3" class="table-patients table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>C.C</th>
        <th>Celular</th>
        <th>Contrato</th>
        <th>Profesional</th>
        <th>Servicio</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Hora Fin</th>
        <th>Estado</th>
        <th>Actualizada por</th>
        <th>Comentarios</th>
        <th>Observaciones</th>
        <th width="120px">Acciones</th>
        <th>creacion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reservation as $key => $r)
        @php
            $validate = true;
            $name = $r->responsable->name.' '.$r->responsable->lastname;
            if($request->professional != ''){
                if(stripos($name,$request->professional) > 0 || stripos($name,$request->professional) === 0){
                    $validate = true;
                }else{
                    $validate = false;
                }
            }
            if($request->date != ''){
                if(stripos($r->date_start, $request->date) > 0 || stripos($r->date_start, $request->date) === 0){
                    $validate = true;
                }else{
                    $validate = false;
                }
            }
            if($request->date != '' and $request->professional != ''){
                if((stripos($r->date_start, $request->date) > 0 and stripos($name,$request->professional) > 0) || (stripos($r->date_start, $request->date) === 0 and stripos($name,$request->professional) === 0 )){
                    $validate = true;
                }else{
                    $validate = false;
                }
            }
        @endphp
        @if( $validate == true)
            @if($r->option == 'horas')
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>Agenda Bloqueada</td>
                    <td>Reservado</td>
                    <td>Reservado</td>
                    <td></td>
                    <td>{{$r->responsable->name}} {{$r->responsable->lastname}}</td>
                    <td>Reservado</td>
                    <td>{{$r->date_start}}</td>
                    @php
                        if(date("a", strtotime($r->hour_start)) == 'am'){
                            $firstA = 'M';
                        }else{
                            if(date("H", strtotime($r->hour_start)) == '12'){
                                $firstA = 'R';
                            }else{
                                $firstA = 'T';
                            }
                        }
                        if(date("a", strtotime($r->hour_end)) == 'am'){
                            $firstB = 'M';
                        }else{
                            $firstB = 'T';
                        }
                    @endphp
                    <td>
                        <div style="visibility: hidden">{{$firstA}}</div>
                        {{date("h:i a", strtotime($r->hour_start)) }}
                    </td>
                    <td>
                        <div style="visibility: hidden">{{$firstB}}</div>
                        {{ date("h:i a", strtotime($r->hour_end)) }}
                    </td>
                    <td>Reservado</td>
                    <td>{{$r->user->name}} {{$r->user->lastname}}</td>
                    <td>Reservado</td>
                    <td>Reservado</td>
                    <td></td>
                    <td>
                        {{ date("Y-m-d", strtotime($r->created_at)) }}
                    </td>
                </tr>
            @endif
        @endif
        @if($r->option == 'dias')
            @php
                $fecha1= \Carbon\Carbon::parse($r->date_start);
                $fecha2= \Carbon\Carbon::parse($r->date_end);
                $diff = $fecha1->diffInDays($fecha2)+ 1;
                $date = $r->date_start;
            @endphp
            @for($i=1;$i<=$diff;$i++)
                @php
                    if($i == 1){
                        $date = $date;
                    }else{
                        $date = date("Y-m-d",strtotime( $date."+ 1 days"));
                    }
                @endphp
                @php
                    $validate = true;
                    $name = $r->responsable->name.' '.$r->responsable->lastname;
                    if($request->professional != ''){
                        if(stripos($name,$request->professional) > 0 || stripos($name,$request->professional) === 0){
                            $validate = true;
                        }else{
                            $validate = false;
                        }
                    }
                    if($request->date != ''){
                        if(stripos($date, $request->date) > 0 || stripos($date, $request->date) === 0){
                            $validate = true;
                        }else{
                            $validate = false;
                        }
                    }
                    if($request->date != '' and $request->professional != ''){
                        if((stripos($date, $request->date) > 0 and stripos($name,$request->professional) > 0) || (stripos($date, $request->date) === 0 and stripos($name,$request->professional) === 0 )){
                            $validate = true;
                        }else{
                            $validate = false;
                        }
                    }
                @endphp
                @if( $validate == true )
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>Agenda Bloqueada</td>
                        <td>Reservado</td>
                        <td>Reservado</td>
                        <td></td>
                        <td>{{$r->responsable->name}} {{$r->responsable->lastname}}</td>
                        <td>Reservado</td>
                        <td>{{$date}}</td>
                        <td>
                            <div style="visibility: hidden">M</div>
                            06:00 am</td>
                        <td>
                            <div style="visibility: hidden">T</div>
                            06:00 pm
                        </td>
                        <td>Reservado</td>
                        <td>{{$r->user->name}} {{$r->user->lastname}}</td>
                        <td>Reservado</td>
                        <td>Reservado</td>
                        <td></td>
                        <td>
                            {{ date("Y-m-d", strtotime($r->created_at)) }}
                        </td>
                    </tr>
                @endif
            @endfor
        @endif
    @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>

