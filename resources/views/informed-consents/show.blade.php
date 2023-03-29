@extends('layouts.app')

@section('content')
    <form id="frmApproved">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="row mb-4">
            <div class="col-lg-12 margin-tb">
                <div class="title-crud">
                    <h2>Consentimiento Informado CI-{{ $data->id }} {{ ucfirst($data->status) }}</h2>
                </div>
                <div class="button-new">
                    <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
                </div>
                @php
                    $cont = 0;
                @endphp
            </div>
        </div>

        <div class="separator"></div>
        <p class="title-form">Datos</p>
        <div class="line-form"></div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Paciente</th>
                <th class="fl-ignore">Cédula</th>
                <th class="fl-ignore">Celular</th>
                <th class="fl-ignore">Contrato</th>
                <th class="fl-ignore">Servicio</th>
                <th class="fl-ignore">Responsable</th>
                <th class="fl-ignore">Fecha</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="openPatientdDC" id="{{$data->patient_id}}">{{ ucwords(mb_strtolower($data->patient->name . " " . $data->patient->lastname, "UTF-8")) }}</td>
                <td>{{ $data->patient->identy }}</td>
                <td>{{ $data->patient->cellphone }}</td>
                <td>C-{{ $data->contract->id }}</td>
                <td>{{ $data->service->name }}</td>
                <td>{{ $data->responsable->name . " " . $data->responsable->lastname }}</td>
                <td>{{ date("Y-m-d", strtotime($data->created_at)) }}</td>
            </tr>
            </tbody>
        </table>
        @php
            $user = \App\User::find(\Illuminate\Support\Facades\Auth::id());
            $signature = \App\Models\InformedConsents::find($data->id);
            $url_signature = 'https://contract.smadiaclinic.com/';
            //$url_signature = 'http://127.0.0.1:4000/';
        @endphp
        @if($user->role_id == 1 || $user->role_id == 12)
            <div class="separator"></div>
            <p class="title-form">Firma de contrato</p>
            <div class="line-form"></div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="fl-ignore">FIRMA</th>
                    <th class="fl-ignore">Link</th>
                    <th class="fl-ignore">Usuario</th>
                    <th class="fl-ignore">Contraseña</th>
                    <th class="fl-ignore">Estado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 20%">
                        @if($signature->signatureBase64 != '')
                            <img style="width: 100%" src="{{ 'data:image/jpeg;charset=utf-8;base64, '.$signature->signatureBase64 }}" alt="">
                        @endif
                    </td>
                    <td>
                        <a href="{{$signature->link}}" target="_blank">ABRIR</a>
                    </td>
                    <td>{{$signature->user}}</td>
                    <td>{{$signature->password}}</td>
                    <td>{{$signature->status}}</td>
                </tr>
                </tbody>
            </table>
        @endif
    </form>
@endsection
@section('script')
@endsection
