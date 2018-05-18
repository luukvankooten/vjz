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
<body class="loggedin">

@include('layouts.panel')
@include('layouts.header')
<main id="main">
    @include('errors.errors')
    @yield('content')
</main>

<!-- Scripts -->
<script type="text/javascript" src="{{ asset('js/Vue.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jQuery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('js/components.js') }}"></script>
@yield('scripts')
</body>
</html>
