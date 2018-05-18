@extends('layouts.app')

@section('title', 'Rapportages')

@section('content')
    <section>
        <div class="body">
            <h1>Maak een rapportage</h1>
            <form action="{{ url()->current() }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Rapportage's
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Bedden
                            </div>
                            <div class="td">
                                <input type="text" name="bed[from]" placeholder="van">
                            </div>
                            <div class="td">
                                <input type="text" name="bed[to]" placeholder="tot">
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                Datum
                            </div>
                            <div class="td">
                                <input type="date" name="date[from]" placeholder="van">
                            </div>
                            <div class="td">
                                <input type="date" name="date[to]" placeholder="tot">
                            </div>
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