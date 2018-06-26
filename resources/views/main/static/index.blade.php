@extends('layouts.app')

@section('title', 'Statistieken')
@section('stylesheets')
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
@section('content')
    <section>
        <div class="body">
            <h1>Statistieken</h1>
            <statics inline-template>
                <div>
                    <div class="group">
                        <div class="table">
                            <div class="tr">
                                <div class="th">
                                    Filters
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="chart-container">
                            <canvas id="chart"></canvas>
                        </div>
                    </div>
                </div>
            </statics>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
    <script type="text/javascript">
        window.addEventListener("load", function() {
            let chart = new Chart('chart', {
                type: 'line',

                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                        label: "My First dataset",
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [],
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });

        Vue.component('statics', {
            data() {
                return {
                    data: null,
                }
            },

            methods: {

            },

            mounted() {
            }
        });
    </script>
@endsection