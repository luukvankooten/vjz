@extends('layouts.app')

@section('title', 'Agenda')

@section('stylesheets')
    <style>
        @media only screen and (max-width: 600px) {
            .agenda-head
        }

        .appointment {
            overflow-y: scroll;
            max-height: 66px;
        }

        .appointment::-webkit-scrollbar {
            display: none;
        }

        .appointment > div {
            height: 15px;
            box-sizing: border-box;
            padding: 0 5px;
            background-color: #67E2FF;
            font-size: .8em;
            color: white;
            border-radius: 2px;
            line-height: 15px;
            cursor: pointer;
            margin-bottom: 2px;
        }
    </style>
@endsection
@section('content')
    <section>
        <div class="body">
            <h1>Agenda</h1>
            <div class="group">
                <calender inline-template>
                    <div class="table">
                        <div class="tr">
                            <div class="th">
                                Agenda @{{ year }} @{{ month }}

                                <i class="fa fa-chevron-circle-right" @click="add"></i>
                                <i class="fa fa-circle" @click="current"></i>
                                <i class="fa fa-chevron-circle-left" @click="remove"></i>
                            </div>
                        </div>
                        <div class="tr agenda-head">
                            <div class="td" v-for="day of days">
                                @{{ day }}
                            </div>
                        </div>
                        <div class="tr" v-if="dates.length > 1">
                            <div class="td agenda-item" v-for="date of dates" :class="[date.class]">
                                    <span class="date"
                                          :class="(date.date.getFullYear() == cDate.getFullYear() &&
                                          date.date.getMonth() == cDate.getMonth() &&
                                          date.date.getDate() == cDate.getDate()) ? 'now' : null">
                                        @{{ date.date.getDate() }}
                                    </span>
                                    <div class="appointment" v-if="date.appointments != null" v-for="app in date.appointments">
                                        <div v-for="a in app"  @click="modal(a)">@{{ a.title }}</div>
                                    </div>
                            </div>
                        </div>
                        <div class="modal" :class="[open ? 'is-active' : '']" v-if="appointment">
                            <div class="modal-dialog">
                                <div class="table clean">
                                    <div class="tr">
                                        <div class="th">
                                            @{{ appointment.title }}
                                            <i class="fa fa-close" @click.prevent="close"></i>
                                        </div>
                                    </div>
                                    <div class="tr">
                                        <div class="td label">
                                            Behandelaar
                                        </div>
                                        <div class="td">
                                            @{{ appointment.creator }}
                                        </div>
                                    </div>
                                    <div class="tr">
                                        <div class="td label" v-if="appointment.place">
                                            Plaats
                                        </div>
                                        <div class="td" v-if="appointment.place">
                                            @{{ appointment.place.establishment }}
                                            @{{ appointment.place.zip }}
                                            @{{ appointment.place.street }}
                                            @{{ appointment.place.number }}
                                            @{{ (appointment.place.addition) ? appointment.place.addition : null }}
                                        </div>
                                        <div class="td" v-else>
                                            Geen plaats ingevoerd. Neem contact op met uw de behandelaar.
                                        </div>
                                    </div>
                                    <div class="tr">
                                        <div class="td label">
                                            Datum
                                        </div>
                                        <div class="td">
                                            @{{ appointment.date }}
                                        </div>
                                        <div class="td label">
                                            Tijdstip
                                        </div>
                                        <div class="td">
                                            @{{ appointment.time }}
                                        </div>
                                    </div>
                                    <div class="tr">
                                        <div class="td label big">
                                            Omschrijving
                                        </div>
                                        <div class="td big auto-height">
                                            @{{ appointment.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </calender>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        Vue.component('calender', {
            data() {
                return {
                    error: false,
                    errors: null,
                    cDate: null,
                    count: null,
                    open: false,
                    appointment: null,
                    dates: [],
                    months: ['januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
                    days: ['ZO', 'MA', 'DI', 'WO', 'DO', 'VR', 'ZA'],
                }
            },
            methods: {
                calender() {
                    let month = new Date(this.cDate.getFullYear(), this.cDate.getMonth() + 1 + this.count, 0);

                    this.month = this.months[month.getMonth()];
                    this.year = month.getFullYear();

                    for (let days = 1; days < month.getDate() + 1; days++) {
                        let day = new Date(month.getFullYear(), month.getMonth(), days);

                        if (days == 1 && day.getDay() != 0) {
                            let pMonth = new Date(day.getFullYear(), day.getMonth(), 0);
                            for (let prev = pMonth.getDate() - day.getDay() + 1; prev < pMonth.getDate() + 1; prev++) {
                                this.dates.push({date: new Date(day.getFullYear(), pMonth.getMonth(), prev), class: 'prev', appointments: null});
                            }
                        }

                        this.dates.push({ date: day, class: 'current', appointments: this.get(day) });

                        if (days == month.getDate() && day.getDay() != 6) {
                            for (let next = 1; next < 6 - day.getDay() + 1; next++) {
                                this.dates.push({date: new Date(day.getFullYear(), day.getMonth() + 1, next), class: 'next', appointments: null});
                            }
                        }
                    }
                    console.log(this.dates[28].appointments);
                },

                current() {
                    if (this.count == null) { return; }
                    this.count = null;
                    this.reset();
                },

                add() {
                    this.count++;
                    this.reset();
                },

                remove() {
                    this.count--;
                    this.reset();
                },

                reset() {
                    this.dates = [];
                    this.calender();
                },

                modal(appointment) {
                    this.open = !this.open;
                    this.appointment = appointment;
                },

                close() {
                    this.open = !this.open;
                    this.appointment = null;
                },

                get(date) {
                    let month = date.getMonth() + 1;
                    let time =  date.getFullYear() + '-' + month + '-' + date.getDate();
                    let data = [];
                    axios.get('/ajax/agenda', {
                        params : {
                            date: time.toString(),
                        }
                    }).then(response => {
                        if (response.data !== "")  {
                            data.push(response.data);
                        }
                    }).catch(error => {
                        this.error = true;
                        this.errors = error;
                    });

                    return (data.length <= 1)? data : null;
                }
            },

            beforeMount() {
                this.cDate = new Date();
                this.calender();
            }
        });
    </script>
@endsection