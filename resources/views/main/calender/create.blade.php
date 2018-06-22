@extends('layouts.app')

@section('title', 'Afspraak')

@section('stylesheets')
<style>
    #warning {
        position: relative;
        color: #FC7474;
        overflow: visible;
    }

    #warning:hover .message{
        display: block;
    }

    .message {
        position: absolute;
        display: none;
        width: 105px;
        height: 70px;
        bottom: -90px;
        right: 0;
        border-radius: 5px;
        background-color: white;
        padding: 5px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.31);
        color: black;
        line-height: normal;
        user-select: none;
    }

    .message::before {
        content: '▲';
        position: absolute;
        top: -15px;
        right: 10px;
        color: white;
        font-size: 15px;
        text-shadow: 0 -2px 3px rgba(0, 0, 0, .2);
    }
</style>
@endsection

@section('content')
    <section>
        <div class="body">
            <h1>Afspraak aanmaken</h1>
            <date-time inline-template>
                <form action="{{ url()->current() }}" method="POST">
                    <div class="form-group">
                        <div class="form-table">
                            <div class="tr">
                                <div class="th">
                                    Afspraak toevoegen
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td label">
                                    <label for="users">Patieënt</label>
                                </div>
                                <div class="td">
                                    <select name="users" id="users" @change="check">
                                        @if(count($users))
                                            <option disabled selected>Maak een keuze</option>
                                            @foreach($users as $user)
                                                <option
                                                    value="{{ $user->name }}" {{ $user->name === old('names') ? 'selected' : null }}>{{ $user->name }}</option>
                                            @endforeach
                                        @else
                                            <option selected disabled>Er zijn geen patieënten ingevoerd.</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="td label">
                                    <label for="date">Datum</label>
                                </div>
                                <div class="td">
                                    <input type="date" name="date" id="date" v-model="date">
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td label">
                                    <label for="time">Tijdstip</label>
                                </div>
                                <div class="td">
                                    <input type="time" name="time" id="time" v-model="time">
                                </div>
                                <div class="td auto-width" id="warning" v-if="error">
                                    <i class="fa fa-warning"></i>
                                    <div class="message">
                                        Dit tijdstip is niet beschikbaar. Kies een ander tijd stip.
                                    </div>
                                </div>
                            </div>

                            <div class="tr">
                                <div class="td big label">
                                    <label for="description">Omschrijving</label>
                                </div>
                                <div class="td big auto-height">
                                    <textarea rows="5" name="description" id="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input v-if="!error" type="submit" name="submit" value="verzenden">
                </form>
            </date-time>
        </div>

    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        Vue.component('date-time', {
            data() {
                return {
                    error: false,
                    user: null,
                    date: null,
                    time: null,
                }
            },

            methods: {
                check(event) {
                    this.user = event.target.value;

                }
            }
        });
    </script>
@endsection


