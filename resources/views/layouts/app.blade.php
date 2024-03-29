<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VJZ') }} | @yield('title')</title>

    @include('includes.favicons')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    @yield('stylesheets')

</head>
<body class="{{ auth()->check()? 'loggedin' : ''}}">
<div id="container">
    @include('layouts.panel')
    @include('layouts.header')
    <main id="main">
        @include('errors.errors')
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}" async></script>
@yield('scripts')
</body>
</html>
