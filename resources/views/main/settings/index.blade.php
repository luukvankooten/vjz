@extends('layouts.app')

@section('title', 'Instellingen')
@section('stylesheets')
    <style>
        .profile-picture {
            margin: 0 auto;
            cursor: pointer;
        }

        .profile-picture .edit {
            display: none;
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
        }

        .edit i.fa {
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 2em;
            color: white;
        }

        .edit input[type=file] {
            opacity: 0;
            width: 100%;
            height: 100%;
            transform: translateY(-46px);
        }

        .profile-picture:hover .edit {
            display: block;
        }
    </style>
@endsection
@section('content')
    <section>
        <div class="body">
            <h1>Instellingen</h1>
            <div class="group">
                <settings inline-template>
                    <form method="POST" action="{{ url()->current() }}" ref="settings" enctype="multipart/form-data">
                        @csrf
                        <div class="table">
                            <div class="tr">
                                <div class="th">
                                    Gegevens
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td auto-height">

                                    <div class="profile-picture">
                                        <img v-if="!image" src="{{ $picture }}">
                                        <img v-else :src="image">
                                        <div class="edit">
                                            <i class="fa fa-pencil"></i>
                                            <input type="file" accept="image/png, image/jpeg" @change="fileUpload">
                                        </div>
                                        <div class="loading" v-if="uploading">
                                           <div class="loader">
                                               <div class="spinner"></div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td label">
                                    Naam
                                </div>
                                <div class="td">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="tr">
                                <div class="td label">
                                    <label for="password">Wachtwoord</label>
                                </div>
                                <div class="td">
                                    <span v-if="!password">*********</span>
                                    <input type="password" name="password" id="password" v-if="password">
                                </div>
                                <div class="td auto-width">
                                    <i class="fa fa-pencil" v-if="!password" @click="edit"></i>
                                    <i class="fa fa-save" v-if="password" @click="$refs.settings.submit()"></i>
                                    <i class="fa fa-remove" v-if="password" @click="edit"></i>
                                </div>
                            </div>
                            <div class="tr" v-if="password">
                                <div class="td label">
                                    <label for="repeat">Heraal wachtwoord</label>
                                </div>
                                <div class="td">
                                    <input type="password" name="password_confirmation" id="repeat">
                                </div>
                            </div>
                            <div class="tr" v-if="password">
                                <div class="td label">
                                    <label for="old">Oude wachtwoord</label>
                                </div>
                                <div class="td">
                                    <input type="password" name="password_old" id="old">
                                </div>
                            </div>
                        </div>
                        <div class="modal" :class="[errors.length ? 'is-active' : '']">
                            <div class="modal-dialog">
                                <div class="table clean">
                                    <div class="tr">
                                        <div class="th">
                                            Fout melding
                                            <i class="fa fa-close" @click.prevent="close"></i>
                                        </div>
                                    </div>
                                    <div class="tr" v-for="error of errors">
                                        <div class="td" v-if="typeof error === 'object'" v-for="err of error">
                                            @{{ String(err) }}
                                        </div>
                                        <div class="td" v-if="typeof error === 'array'" v-for="err of error">
                                            @{{ err }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Verzenden">
                    </form>
                </settings>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        Vue.component('settings', {
            data() {
                return {
                    password: false,
                    image: null,
                    uploading: false,
                    errors: [],
                }
            },

            methods: {
                edit() {
                    this.password = !this.password;
                },

                close() {
                    this.errors = [];
                },

                fileUpload(e) {
                    let file = files = e.target.files || e.dataTransfer.files;
                    if (!file.length)
                        return;

                    this.uploading = !this.uploading;
                    this.createImage(file[0]);

                    let data = new FormData();
                    data.append('picture', file[0]);

                    axios.post('/instellingen', data).then(res => {
                        if (this.uploading && Array.isArray(res.data) && res.data.includes('success')) {
                            this.uploading = !this.uploading;
                        } else {
                            this.uploading = !this.uploading;
                            this.errors.push(res.data);
                        }
                    }).catch(err => {
                        this.errors.push(err);
                    });
                },

                createImage(file) {
                    let reader = new FileReader();

                    reader.onload = (e) => {
                        this.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
            }
        });
    </script>
@endsection