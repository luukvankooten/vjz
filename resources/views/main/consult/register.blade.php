@extends('layouts.app')

@section('title', 'Consult')

@section('content')
    <section>
        <div class="body">
            <h1>Consult toevoegen</h1>
            <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">Algemen gevens</div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="names">Naam</label>
                            </div>
                            <div class="td">
                                @if(count($users))
                                    <select name="names" id="names">
                                        @foreach($users as $key => $user)
                                            <option value="{{ $user->name }} {{ $user->name === old('names') ? 'selected' : null }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="disabled">Geen patiënten ingevoerd</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(!auth()->user()->hasRole('Huisarts'))
                    <div class="form-group">
                        <div class="form-table">
                            <div class="tr">
                                <div class="th">
                                    Kamer
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td label">
                                    <label for="hospital">Ziekenhuis</label>
                                </div>
                                <div class="td">
                                    @if(count($hospitals))
                                        <select name="info[hospital]" id="hospital">
                                            @foreach($hospitals as $key => $hospital)
                                                <option
                                                    value="{{ $key }}" {{ $hospital === old('info.hospital')? 'selected' : null }}>{{ $hospital }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="disabled">Geen ziekenhuizen ingevoerd</span>
                                    @endif
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td label">
                                    <label for="room">Kamer</label>
                                </div>
                                <div class="td">
                                    <input type="text" name="info[room]" id="room" value="{{ old('info.room') }}">
                                </div>
                                <div class="td label">
                                    <label for="bed">Bed</label>
                                </div>
                                <div class="td">
                                    <input type="text" name="info[bed]" id="bed" value="{{ old('info.bed') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <file inline-template>
                    <div class="form-group">
                        <div class="form-table">
                            <div class="tr">
                                <div class="th">
                                    Beeldbank
                                    <i @click="add()" class="fa fa-plus-circle"></i>
                                </div>
                            </div>
                            <div class="tr" v-for="(row, i) in rows">
                                <div class="td label big">
                                    Upload bestand
                                    <i v-if="rows.length > 1" @click="remove(i)" class="fa fa-minus-circle"></i>
                                </div>
                                <div class="td">
                                    <div class="upload-box">
                                        <label :for="'image_'+i">
                                            <div class="btn"><i class="fa fa-upload"></i></div>
                                            <input type="hidden" :value="(row.file === '') ? row.file : null">
                                            <input type="file" :id="'image_'+ i" name="images[]" accept="image/*"
                                                   @change="row.file = $event.target.value">
                                            <span>@{{ (row.file !== null)? file(row.file) : "Geen bestand gekozen" }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </file>
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Consult
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="disease">Aandoening</label>
                            </div>
                            <div class="td">
                                @if(count($diseases))
                                    <select name="disease" id="disease">
                                        @foreach($diseases as $disease)
                                            <option value="{{ $disease->id }} {{ $disease === old('disease') ? 'selected' : null }}">{{ $disease->disease . ' ' .  $disease->body_part }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="disabled">Geen aandoeningen ingevoerd</span>
                                @endif
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td big label">
                                <label for="details">Bijzonderheden</label>
                            </div>
                            <div class="td big auto-height">
                                <textarea rows="3" name="details" id="details">{{ old('details') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Medicijnen
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label">
                                <label for="medicine">Medicijnen</label>
                            </div>
                            <div class="td">
                                @if(count($medicines))
                                    <select name="medicine" id="medicine">
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}"  {{ $medicine === old('medicine') ? 'selected' : null }}>{{ $medicine->factory . ' ' .  $medicine->medicine }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="disabled">Geen medicijnen ingevoerd</span>
                                @endif
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

@section('scripts')
<script type="text/javascript">
    Vue.component('file', {
        data() {
            return {
                rows: [{"file": null }]
            }
        },

        methods: {
            file: function(path) {
                return path.replace(/^.+[\\\\\\/]/, '');
            },

            add: function () {
                if (this.rows.length < 10) this.rows.push({"file": null});
            },

            remove: function(row) {
                this.rows.splice(row, 1);
            },
        },

        mounted() {
            console.log(this.rows);
        }
    });
</script>
@endsection