@extends('layouts.show')

@section('content')
    <div class="cont-show d-flex justify-content-between">
        <div class="cont-show__left">
            <div class="cont-show__content">
                <div id="calendar-date-schedules-view"></div>
            </div>
            <div class="mt-4"></div>
            <div class="cont-show__content">
                <div class="title-schedule">Ver citas</div>
                <select name="professional_id" id="professionals-view" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione profesional</option>
                    @foreach($professionals as $pro)--}}
                        <option value="{{ $pro->id }}">{{ $pro->name . " " . $pro->lastname }}</option>--}}
                    @endforeach
                </select>
                <select name="roles_id" id="roles-view" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="cont-show__right">
            <div class="cont-show__content">
                <div id="calendar-view"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection
