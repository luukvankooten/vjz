@extends('layouts.app')

@section('title', 'Rollen')

@section('content')
    <section>
        <div class="body">
            <h1>Maak een rol aan</h1>
            <form action="{{ url()->current() }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">Rol toevoegen</div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="name">Naam</label>
                            </div>
                            <div class="td"><input type="text" name="name" id="name"></div>
                        </div>
                        <div class="tr">
                            <div class="td big">
                                <label for="description">
                                    Beschrijving
                                </label>
                            </div>
                            <div class="td big">
                            <textarea type="text" name="description" id="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Permissies toekennen
                            </div>
                        </div>
                        <div class="tr">
                            @foreach($permissions as $permission)
                                <div class="td label">
                                    <label for="{{ $permission }}">{{ $permission }}</label>
                                </div>
                                <div class="td">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission }}" id="{{ $permission }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <input type="submit" name="submit" value="Verzenden">
                </div>
            </form>
        </div>
    </section>
@endsection