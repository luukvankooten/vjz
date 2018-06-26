@extends('layouts.app')

@section('title', 'Allergieeën')

@section('content')
    <section>
        <div class="body">
            <h1>Allergieeën</h1>

            <div class="group">
                <form action="{{ url()->current() }}" method="POST">
                    @csrf
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Koppelen
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="user">Gebruiker</label>
                            </div>
                            <div class="td">
                                <select name="user" id="user">
                                    @if(count($users))
                                        <option disabled selected>selecteer een patiënt</option>
                                        @foreach($users as $user)
                                            <option name="{{ $user->name }}">{{ $user->name }}</option>
                                        @endforeach
                                    @else
                                        <option disabled selected>Geen patieënten ingevoerd</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="allergy">Allergieeën</label>
                            </div>
                            <div class="td">
                                <input type="text" name="allergy" id="allergy" list="list">
                                @if(count($allergies))
                                    <datalist id="list">
                                        @foreach($allergies as $allergy)
                                            <option value="{{ $allergy }}">
                                        @endforeach
                                    </datalist>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <input type="submit" name="submit" value="Verzenden">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
