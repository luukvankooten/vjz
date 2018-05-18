@extends('layouts.app')

@section('title', 'Medicijnen')

@section('content')
    <section>
        <div class="body">
            <h1>Medicijnen toevoegen</h1>
            <form action="{{ url()->current() }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Medicijn toevoegen
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Frabrikant
                            </div>
                            <div class="td">
                                <input type="text" name="factory">
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Model
                            </div>
                            <div class="td">
                                <input type="text" name="medicine">
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