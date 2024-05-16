@extends('layouts.template')

@section('content')
    <div class="page-title">
        <h3>Dashboard</h3>
        @if ($pesan)
            <div class="alert alert-danger" role="alert">
                {{ $pesan }}
            </div>
        @endif
    </div>
    <section class="section mt-4">
        <div class="row">
            @if (Auth::user()->role != 'siswa')
                <div class="col-md-4">

                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="card card-statistic">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class="px-3 py-3 d-flex justify-content-between">
                                            <h3 class="card-title">Siswa</h3>
                                            <div class="card-right d-flex align-items-center">
                                                <p>{{ $siswa }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-statistic">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class="px-3 py-3 d-flex justify-content-between">
                                            <h3 class="card-title">Guru</h3>
                                            <div class="card-right d-flex align-items-center">
                                                <p>{{ $guru }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card card-statistic">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class="px-3 py-3 d-flex justify-content-between">
                                            <h3 class="card-title">Kelas</h3>
                                            <div class="card-right d-flex align-items-center">
                                                <p>{{ $kelas }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-{{ Auth::user()->role == 'siswa' ? '12' : '8' }}">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Bar Chart Kehadiran pada {{ date('F Y', strtotime(now())) }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        var ctxBar = document.getElementById("bar").getContext("2d");
        var myBar = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ["Hadir", "Izin", "Sakit", "Tanpa Keterangan"],
                datasets: [{
                    label: 'Jumlah',
                    backgroundColor: [chartColors.green, chartColors.info, chartColors.yellow, chartColors
                        .red
                    ],
                    data: [
                        {{ $absensihadir }},
                        {{ $absensiizin }},
                        {{ $absensisakit }},
                        {{ $absensibolos }},
                    ]
                }]
            },
            options: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: false,
                    text: "Chart.js - Bar Chart with Rounded Tops (drawRoundedTopRectangle Method)"
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }]
                }
            }
        });
    </script>
@endsection
