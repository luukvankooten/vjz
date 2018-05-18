@extends('layouts.app')

@section('title', 'Behandelingen')

@section('content')
    <section>
        <div class="body">
            <h1>Bij kijk uw behandelingen</h1>

                <div class="table">
                    <div class="tr">
                        <div class="th xs-small">
                            Id
                        </div>
                        <div class="th">
                            Omschrijving
                        </div>
                        <div class="th normal">
                            Behandelaar
                        </div>
                        <div class="th normal">
                            Acties's
                        </div>
                    </div>
                    @if(count($treatments))
                        @foreach($treatments as $treatment)
                            <div class="tr">
                                <div class="td xs-small">
                                    {{ $treatment->id }}
                                </div>
                                <div class="td">
                                    {{ $treatment->details }}
                                </div>
                                <div class="td normal">
                                    @foreach($treatment->practitioner as $practitioner)
                                        {{ $practitioner->name }}
                                    @endforeach
                                </div>
                                <div class="td normal center">
                                    <a href="/behandelingen/{{ $treatment->id }}" class="btn">
                                        Bekijken
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="tr">
                            <div class="td">
                                Er zijn geen behandelingen ingevoerd.
                            </div>
                        </div>
                    @endif
                </div>
                @if($treatments->links())
                    <div class="pagination">
                        {{ $treatments->links() }}
                    </div>
                @endif
        </div>

    </section>
@endsection