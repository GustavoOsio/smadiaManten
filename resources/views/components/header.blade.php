@php
$user = \Illuminate\Support\Facades\Auth::user();
@endphp
<header>
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo"><img src="{{ asset("img/logo2-02.png") }}" alt="logo"></div>
            <div class="d-title d-flex align-items-center justify-content-center"><div>Smadiasoft</div><div>Barranquilla</div></div>
            <div class="profile d-flex align-items-center justify-content-end">
                <div class="profile__photo"><img src="{{ asset(($user->photo) ? $user->photo : "") }}" alt=""></div>
                <div class="profile__name">{{ $user->name . " " . $user->lastname }} <span>({{ $user->role->name }})</span></div>
                <div class="profile__logout">
                    <a onclick="location.href = '{{url('account')}}'">
                        &ensp;Mi cuenta&ensp;
                    </a>
                </div>
                <div class="profile__logout"><a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="#"><span class="icon-back-11"></span>Cerrar sesión</a></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <!--
                <div class="profile__notify"><span class="icon-icon-10"></span></div>
                -->
            </div>
        </div>
    </div>
</header>
