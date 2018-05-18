@extends('layouts.app')

@section('title', 'Registeer')

@section('content')
    <section>
        <div class="body">
            <h1>Registreer een gebruiker</h1>

            <form  class="vue" action="{{ url()->current() }}" method="post" autocomplete="off">
                @csrf

                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Registreer
                            </div>
                        </div>

                        <div class="tr">
                            <div class="td label">
                                <label for="name">Naam</label>
                            </div>
                            <div class="td">
                                <input type="text" name="name" id="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="tr">
                            <div class="td label">
                                <label for="role">Rol</label>
                            </div>
                            <div class="td">
                                @if(count($roles))
                                    <select name="role" id="role" v-on:change="role = $event.target.value">
                                        <option disabled selected>Maak een keuze</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ $role === old('role') ? 'selected' : null }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="disabled">Geen rollen ingevoerd</span>
                                @endif
                            </div>
                        </div>

                        <div class="tr">
                            <div class="td label">
                                <label for="email">Email</label>
                            </div>
                            <div class="td">
                                <input type="email" name="email" id="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="tr">
                            <div class="td label">
                                <label for="password">Wachtwoord</label>
                            </div>
                            <div class="td">
                                <input type="password" name="password" id="password">
                            </div>
                        </div>

                        <div class="tr" v-if="role === 'Gebruiker'">
                            <div class="td label">
                                <label for="practitioner">Huisarts</label>
                            </div>
                            <div class="td">
                                @if(count($practitioners))
                                    <select name="practitioner" id="practitioner">
                                        @foreach($practitioners as $name)
                                            <option value="{{ $name }}" {{ $name === old('practitioner')? 'selected' : null }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" name="practitioner" value>
                                    <span class="disabled">Geen huisartsen ingevoerd</span>
                                @endif
                            </div>
                        </div>

                        <div class="tr">
                            <div class="td label">
                                <label for="group">Groep</label>
                            </div>
                            <div class="td">
                                @if(count($groups))
                                    <select name="group" id="group">
                                        <option selected value>Geen Groep</option>
                                        @foreach($groups as $name)
                                            <option value="{{ $name }}" {{ $name === old('group')? 'selected' : null }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="disabled">Geen Groepen ingevoerd</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group"
                     v-if="role && ['Ziekenhuis', 'Verzekering'].indexOf(role) < 0">
                    <div class="form-table">
                        @include('main.includes.address')
                    </div>
                </div>

                <div class="form-group clearfix">
                    <input type="submit" name="submit" value="Verzenden">
                </div>
            </form>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript" defer>
        var app = new Vue({
            el: '.vue',
            data: {
                role: null,
            }
        });
    </script>
@endsection