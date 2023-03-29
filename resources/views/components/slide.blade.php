@php
$menus = \App\Models\Role::find(\Illuminate\Support\Facades\Auth::user()->role_id)->menus;
$route = \Request::route()->getName();
$active = '';
$swi = false;
$sw = false;
@endphp
<div class="slide-menu">
    <div id="menu">
        <ul>
            <li><a title="" href="/home"><div><span class="icon-icon-02"></span></div>Dashboard</a></li>
            @foreach($menus as $menu)
                @if ($menu->type === "dashboard")
                    @php
                        $array = [
                            $menu->slug . '.index',
                            $menu->slug . '.create',
                            $menu->slug . '.show',
                            $menu->slug . '.edit',
                            ];
                    @endphp
                    @if (in_array($route, $array))
                        @php $active = 'active'; @endphp
                    @else
                        @php $active = ''; @endphp
                    @endif
                    <li class="has-sub {{ $active }}"><a title="" href="{{ url($menu->slug) }}"><div><span class="{{ $menu->icon }}"></span></div>{{ $menu->name }}</a></li>
                @endif
            @endforeach
            <li class="has-sub"><a title="" href=""><div><span class="icon-icon-05"></span></div>Reportes</a>
                <ul>
                    @foreach($menus as $menu)
                        @if ($menu->type === "report")
                            <li><a title="" href="{{ url($menu->slug) }}">{{ $menu->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="has-sub"><a title="" href=""><div><span class="icon-icon-06"></span></div>Pagos</a>
                <ul>
                    @foreach($menus as $menu)
                        @if ($menu->type === "pay")
                            <li><a title="" href="{{ url($menu->slug) }}">{{ $menu->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="has-sub"><a title="" href=""><div><span class="icon-icon-07"></span></div>Caja</a>
                <ul>
                    @foreach($menus as $menu)
                        @if ($menu->type === "box")
                            <li><a title="" href="{{ url($menu->slug) }}">{{ $menu->name }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @foreach($menus as $menu)
                @if ($menu->type === "inventory")
                    @php
                        $active = '';
                        $swi = true;
                        $array = [
                            $menu->slug . '.index',
                            $menu->slug . '.create',
                            $menu->slug . '.show',
                            $menu->slug . '.edit',
                            ];
                    @endphp
                    @if (in_array($route, $array))
                        @php $active = 'active'; @endphp
                        @break
                    @endif
                @endif
            @endforeach
            @if ($swi)
                <li class="has-sub {{ $active }}"><a title="" href=""><div><span class="icon-icon-08"></span></div>Inventario</a>
                    <ul>
                        @foreach($menus as $menu)
                            @if ($menu->type === "inventory")
                                <li><a title="" href="{{ url($menu->slug) }}">{{ $menu->name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif

            @foreach($menus as $menu)
                @if ($menu->type === "comisiones")
                    @php
                        $active = '';
                        $swi = true;
                        $array = [
                            $menu->slug . '.index',
                            $menu->slug . '.create',
                            $menu->slug . '.show',
                            $menu->slug . '.edit',
                            ];
                    @endphp
                    @if (in_array($route, $array))
                        @php $active = 'active'; @endphp
                        @break
                    @endif
                @endif
            @endforeach
            <li class="has-sub {{ $active }}"><a title="" href=""><div><span class="icon-icon-08"></span></div>Comisiones</a>
                    <ul>
                       @foreach($menus as $menu)
                            @if ($menu->type == "comisiones")
                                <li><a title="" href="{{ url($menu->slug) }}">{{ $menu->name }}</a></li>
                            @endif
                        @endforeach
                        <li><a title="" href="{{url('comision')}}">Comision</a></li>

                    </ul>
                </li>



            @foreach($menus as $menu)
                @if ($menu->type === "config")
                    @php
                        $active = '';
                        $sw = true;
                        $array = [
                            $menu->slug . '.index',
                            $menu->slug . '.create',
                            $menu->slug . '.show',
                            $menu->slug . '.edit',
                            ];
                    @endphp
                    @if (in_array($route, $array))
                        @php $active = 'active'; @endphp
                        @break
                    @endif
                @endif
            @endforeach
            @if ($sw)
                <li class="has-sub {{ $active }}"><a title="" href=""><div><span class="icon-icon-09"></span></div>Configuración</a>
                    <ul class="menu-configuration">
                        <li><a title="" href="{{ route('index.parametro') }}">Parametro</a></li>
                        @foreach($menus as $menu)
                            @if ($menu->type === "config")
                                <li><a title="" href="{{ url($menu->slug) }}">{{ $menu->name }}</a></li>

                                @endif
                        @endforeach
                    </ul>
                </li>

            @endif




        </ul>
    </div>
</div>

<style>
    .menu-configuration li
    {
        padding: 0% !important
    }
    .menu-configuration li a
    {
        padding: 3% 0% !important
    }
</style>
