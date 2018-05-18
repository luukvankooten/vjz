@extends('layouts.app')

@section('title', 'Aandoening')

@section('content')
    <section>
        <div class="body">
            <h1>Aandoening toevoegen</h1>
            <form action="{{ url()->current() }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Aandoening
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Lichaamsdeel
                            </div>
                            <div class="td">
                                <input type="text" name="body_part">
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Aandoening
                            </div>
                            <div class="td">
                                <input type="text" name="disease">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Verzenden">
                </div>
            </form>
        </div>
    </section>
@endsection