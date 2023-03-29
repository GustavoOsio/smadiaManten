<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
    @yield('style')
</head>
<body>
@component('components.header')
@endcomponent
@component('components.slide')
@endcomponent
<div class="content-dash">
    @yield('content')
</div>
<script src="{{ url(mix("js/app.js")) }}"></script>
@yield('script')
</body>
</html>
