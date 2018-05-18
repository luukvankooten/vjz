@extends('layouts.app')

@section('title', 'Koppelen')

@section('content')
    <section>
        <div class="body">
            <h1>Groepen koppelen aan personen</h1>
            <form action="{{ url()->current() }}" method="POST" class="vue">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Selecteer groep
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="insurance">Groepen</label>
                            </div>
                            <div class="td">
                                @if(count($insurances))
                                    <select name="insurance" id="insurance"
                                            v-on:change="insurance = $event.target.value">
                                        @foreach($insurances as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="disabled">Geen Groepen ingevoerd</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" v-show="insurance">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Naam
                            </div>
                            <div class="th xs-small">
                                Koppel
                            </div>
                        </div>
                        @if(count($users))
                            @foreach($users as $id => $name)
                                <div class="tr">
                                    <div class="td">
                                        <label for="{{ $name }}">{{ $name }}</label>
                                    </div>
                                    <div class="td xs-small">
                                        <input type="checkbox" name="{{ $name }}" value="{{ $id }}">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span class="disabled">Geen gebruikers ingevoerd</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="verzenden">
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
                insurance: null,
            }
        });
    </script>
@endsection