@extends('layouts.app')

@section('title', 'Verzekering')

@section('content')
    <section>
        <div class="body">
            <h1>Groepen toevoegen</h1>
            <form action="{{ url()->current() }}" method="POST">
                @csrf

                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Groep aanmaken
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Soort groep
                            </div>
                            <div class="td">
                                <select name="type">
                                    @foreach($roles as $id => $role)
                                        <option value="{{ $id }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Naam
                            </div>
                            <div class="td">
                                <input type="text" name="name">
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td big label">
                                Omschrijving
                            </div>
                            <div class="td big auto-height">
                                <textarea type="text" name="description" id="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-table">
                        @include('main.includes.address')
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="verzenden">
                </div>
            </form>
        </div>
    </section>
@endsection