@extends('layouts.app')

@section('title', 'Beeldbank')

@section('stylesheets')
    <style>
        .search-dock {
            display: none;
            float: right;
            height: 35px;
        }

        .search-dock.is-active {
            display: block;
        }

        .search-dock input[type=search] {
            width: 250px;
            margin-right: 10px;
        }

        .td.normal.file {
            max-height: unset;
            height: 150px;
        }

        .td.normal.file.disabled {
            background: url(/images/stripe.png) repeat;
        }

        .td.normal.file img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            max-height: 150px;
            cursor: pointer;
        }

        .td.normal.file a {
            display: block;
            position: relative;
            height: 100%;
            color: #2C2C2C;
        }

        .td.normal.file a i.fa {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 30px;
        }

        .td.normal.file a:hover {
            color: #4ADDB9;
        }

        .modal .table .tr .td img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            max-height: 500px;
        }

    </style>
@endsection
@section('content')
    <section>
        <div class="body">
            <h1>Beeldbank</h1>

            <div class="group">
                <files inline-template>
                    <div>
                        <div class="table">
                            <div class="tr">
                                <div class="th">
                                    Bestanden
                                    <i class="fa fa-search" @click="sOpen"></i>
                                    <div class="search-dock" :class="[finder? 'is-active' : null]">
                                        <input type="search" @input="search" v-model="sString" placeholder="Zoeken..">
                                    </div>
                                </div>
                            </div>
                            @foreach($dirs as $key => $dir)
                                <div class="tr" v-if="!finder">
                                    <div class="td label big">
                                        <a href="/behandelingen/{{ $key }}">Bekijken behandeling</a>
                                    </div>
                                    @foreach($dir as $file)
                                        @php
                                            $extension = pathinfo($file, PATHINFO_EXTENSION);
                                            $filename = basename($file);
                                        @endphp
                                        <div class="td normal file">
                                            @switch($extension)
                                                @case('jpg')
                                                @case('jpeg')
                                                @case('png')
                                                <img src="{{ asset('bestanden/'.$file) }}" data-search="{{ $filename }}" @click="modal">
                                                @break
                                                @case('doc')
                                                @case('docx')
                                                @case('docb')
                                                <a href="{{ asset('bestanden/'.$file) }}" data-search="{{ $filename }}">
                                                    <i class="fa fa-file-word-o"></i>
                                                </a>
                                                @break
                                                @case('pdf')
                                                <a href="{{ asset('bestanden/'.$file) }}" data-search="{{ $filename }}">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                @break
                                            @endswitch
                                        </div>
                                    @endforeach
                                    @if(count($dir) % 4)
                                        @for($row = 0; $row < 4 - (count($dir) % 4); ++$row)
                                            <div class="td normal file disabled">
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            @endforeach
                            <div class="tr" v-if="finder">
                                <div class="td normal file" v-if="hasResult" v-for="result of results">
                                    <img v-if="result.tagName === 'IMG'" :src="result.src" @click="modal">
                                    <a v-else :href="result.href">
                                        <i :class="result.children['0'].className"></i>
                                    </a>
                                </div>
                                <div class="td big" v-if="!hasResult">
                                    Geen resultaaten.
                                </div>
                            </div>
                        </div>
                        <div class="modal" :class="[open ? 'is-active' : null]" v-if="src">
                            <div class="modal-dialog">
                                <div class="table clean">
                                    <div class="tr">
                                        <div class="th">
                                            Afbeelding
                                            <i class="fa fa-close" @click.prevent="open = !open"></i>
                                        </div>
                                    </div>
                                    <div class="tr">
                                        <div class="td auto-height">
                                            <img :src="src"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </files>
            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script type="application/javascript">
        Vue.component('files', {
            data() {
                return {
                    finder: false,
                    open: false,
                    src: null,
                    hasResult: false,
                    results: [],
                    sString: null,
                    elements: [],
                }
            },

            methods: {
                modal(event) {
                    this.src = event.path[0].src;
                    this.open = !this.open;
                },

                search() {
                    this.hasResult = false;
                    this.results = [];
                    if (this.sString == null || this.sString == '') { return; }

                    let query = this.sString.toLowerCase();
                    for (element of this.elements) {
                        let file = element.getAttribute('data-search').toLowerCase();
                        if (file && file.indexOf(query) > -1) {
                            this.hasResult = true;
                            this.results.push(element);
                        }
                    }
                },

                sOpen() {
                    this.finder = !this.finder;
                }
            },

            beforeMount() {
                let els = document.querySelectorAll('.file:not(#results)');
                for(el of els) {
                    if(!el.classList.contains('disabled') &&
                    el.childElementCount <= 1) {
                        this.elements.push(el.children[0]);
                    }
                }
            }
        });
    </script>
@endsection