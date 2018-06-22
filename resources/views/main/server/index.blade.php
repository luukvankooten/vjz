@extends('layouts.app')

@section('title', 'Oauth2')

@section('content')
    <section>
        <div class="body">
            <h1>Oauth2</h1>
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/O2auth.js') }}" defer></script>
@endsection