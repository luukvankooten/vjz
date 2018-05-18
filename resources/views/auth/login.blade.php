<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>VJZ | Login</title>

    @include('includes.favicons')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">

</head>
<body>

<!-- Background -->
<img class="background" src="{{ asset('/images/background-epd.png') }}">
<form class="login" method="post" action="/login">
    
    <div class="form-group">
        <img src="{{ asset('/images/logo.svg') }}" height="25">
    </div>

    @if(count($errors) > 0)
        <div class="form-group">
            <div class="login-error">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
            </div>
        </div>
    @endif

    @csrf

    <div class="form-group">

        <label for="name">{{ __('Gebruikersnaam:') }}</label>
        <input type="text" id="name" name="name" placeholder="{{ __('Gebruikersnaam') }}">

    </div>

    <div class="form-group">

        <label for="password">{{ __('Wachtwoord:') }}</label>
        <input type="password" id="password" name="password" placeholder="{{ __('Wachtwoord') }}">

    </div>

    <div class="form-group clearfix">

        <input type="submit" name="submit" value="{{ __('Verzenden') }}">

    </div>

    <div class="form-group">

        <a class="link" href="#">
            {{ __('Wachtwoord vergeten?') }}
        </a>

    </div>
</form>
<img class="background" src="/images/background-epd.png">
<!-- Scripts -->
<script type="text/javascript" src="{{ asset('js/jQuery.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
