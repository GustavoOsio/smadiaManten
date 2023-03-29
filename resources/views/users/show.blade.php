@extends('layouts.show')

@section('content')
    <div class="cont-show d-flex justify-content-between">
        <div class="cont-show__left">
            <div class="cont-show__content">
                <div class="cont-show__img">
                    <img src="{{ asset("img/show-02.png") }}" alt="profile">
                </div>
                <h3>{{ $user->title . " " . $user->name . " " . $user->lastname }}</h3>
                <div class="cont-show__rol">{{ $user->role->name }}</div>
                <div class="cont-show__info">
                    <div>C.C:</div><div>{{ $user->identy }}</div>
                    <div>F. Nacimiento</div><div>{{ $user->birthday }}</div>
                    <div>Ciudad</div><div>{{ $user->city->name }}</div>
                    <div>Dirección</div><div>{{ $user->address }}</div>
                    <div>Barrio</div><div>{{ $user->urbanization }}</div>
                    <div>E-mail</div><div>{{ $user->email }}</div>
                    <div>T. Sangre</div>{{ $user->blood->name }}
                    <div>ARP</div><div>{{ $user->arp_text }}</div>
                    <div>Pension</div><div>{{ $user->pension_text }}</div>
                    <div>Activo</div><div></div>
                </div>
            </div>
        </div>
        <div class="cont-show__right"></div>
    </div>
@endsection