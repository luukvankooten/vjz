@extends('layouts.app')

@section('title', 'Behandelingen')

@section('content')
    <section>
        <div class="body">
            <h1>Bij kijk uw behandelingen</h1>
            <div class="table">
                <div class="tr">
                    <div class="th">
                        Uw gegevens
                    </div>
                </div>
                <div class="tr">
                    <div class="td label">
                        Datum
                    </div>
                    <div class="td xs-small">
                        {{ date_format($treatment->created_at, 'd/m/Y') }}
                    </div>
                    <div class="td label">
                        Naam
                    </div>
                    <div class="td">
                        {{ $treatment->user[0]->name }}
                    </div>
                </div>
                <div class="tr">
                    <div class="td label">
                        Behandelaar
                    </div>
                    <div class="td">
                        {{ $treatment->practitioner[0]->name }}
                    </div>
                </div>
                <div class="tr">
                    <div class="td label">
                        Aandoening
                    </div>
                    <div class="td">
                        {{ $treatment->disease[0]->disease }} {{ $treatment->disease[0]->body_part }}
                    </div>
                </div>
                <div class="tr">
                    <div class="td label">
                        Medicijnen
                    </div>
                    <div class="td">
                        {{ $treatment->medicine[0]->factory }} {{ $treatment->medicine[0]->medicine }}
                    </div>
                </div>
                <div class="tr">
                    <div class="td label big">
                        Omschrijving
                    </div>
                    <div class="td big">
                        {{ $treatment->details }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection