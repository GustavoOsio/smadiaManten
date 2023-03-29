@extends('layouts.app')

@section('content')

    @component("components.export", ["url"=>url("exports/patients")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Pacientes</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Patient::class)
                    <a class="btn btn-primary" href="{{ route('patients.create') }}"> Crear</a>
                @endcan
                @can('view', \App\Models\Contract::class)
                @if($user->id != 26)
                <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @else

                @endif
                    @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table-patients table-striped">
        <thead>
            <tr>
                <th width="70px">#</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>C.C</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Estado</th>
                <!--<th>Fecha creación</th>-->
                <th>Creado por</th>
                <th width="100px">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="search-table-input">
                <th>
                    <input id="id_patient" value="{{$request->id}}">
                </th>
                <th>
                    <input id="name_patient" value="{{$request->name}}">
                </th>
                <th>
                    <input id="lastname_patient" value="{{$request->lastname}}">
                </th>
                <th>
                    <input id="cc_patient" value="{{$request->cc}}">
                </th>
                <th>
                    <input id="mail_patient" value="{{$request->mail}}">
                </th>
                <th>
                    <input type="number" id="phone_patient" value="{{$request->phone}}">
                </th>
                <th>
                    <select id="status_patient">
                        <option value="">Seleccionar</option>
                        <option value="activo" {{$request->status=='activo'?'selected':''}}>Activo</option>
                        <option value="inactivo" {{$request->status=='inactivo'?'selected':''}}>Inactivo</option>
                    </select>
                </th>
                <!--
                <th>
                    <input type="text" id="creator_patient" value="{{$request->creator}}">
                </th>
                -->
            </tr>
            @php
                $user_admin = \App\User::find(\Illuminate\Support\Facades\Auth::id());
            @endphp
        @foreach ($patients as $patient)
            <tr class="tr" id="{{$patient->id}}">
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->lastname }}</td>
                <td>{{ $patient->identy }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->cellphone }}</td>
                <td>{{ ucfirst($patient->status) }} {!! ($patient->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <!--<td>{{ $patient->created_at }}</td>-->
                <td>{{ $patient->creator->name . " " . $patient->creator->lastname }}</td>
                <td>
                    <form id="form-{{ $patient->id }}" action="{{ route('patients.destroy',$patient->id) }}" method="POST">
                        @can('update', \App\Models\Patient::class)
                            <a href="{{ route('patients.edit',$patient->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                        @if($user_admin->role_id == 1 || $user_admin->role_id == 12)
                            @can('delete', \App\Models\Patient::class)
                                @csrf
                                @method('DELETE')
                                <a href="#" class="form-submit" data-id="form-{{ $patient->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$patients->appends([
        'id' => $request->id,
        'name'=>$request->name,
        'lastname' => $request->lastname,
        'cc'=>$request->cc,
        'mail' => $request->mail,
        'phone'=>$request->phone,
        'status'=>$request->status,
    ])->links()}}
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let $id_patient,$name_patient;
            $(function () {
                $id_patient = $('#id_patient');
                $name_patient = $('#name_patient');
                $lastname_patient = $('#lastname_patient');
                $cc_patient = $('#cc_patient');
                $mail_patient = $('#mail_patient');
                $phone_patient = $('#phone_patient');
                $status_patient = $('#status_patient');
                $creator_patient = $('#creator_patient');

                //$id_patient.keypress(keyPress(e));
                //$name_patient.keypress(keyPress(e));

                $status_patient.change(onChangeFilter);
            });
            /*
            function keyPress(e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            }
            */
            $('#id_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#name_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#lastname_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#cc_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#mail_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#phone_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#creator_patient').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            function onChangeFilter(){
                location.href = '/patients?id='+$id_patient.val()+
                    '&name='+$name_patient.val()+
                    '&lastname='+$lastname_patient.val()+
                    '&cc='+$cc_patient.val()+
                    '&mail='+$mail_patient.val()+
                    '&phone='+$phone_patient.val()+
                    '&status='+$status_patient.val();
                    //'&creator='+$creator_patient.val();
            }
            $('table tbody').on('dblclick', '.tr', function () {
                var data = this.id;
                location.href = "patients/" + data;
            } );
            /*
            var table = $('#table-soft').DataTable();
            $('#table-soft tbody').on('dblclick', 'tr', function () {
                var data = table.row( this ).data();
                location.href = "patients/" + data[0];
            } );
             */
        } );
    </script>
@endsection
