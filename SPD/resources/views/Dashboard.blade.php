@extends('layouts.app')
<title>Dashboard</title>
@section('content')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        @media only screen and (max-width: 768px) {
            .chart-container {
                width: 100%;
                height: 300px;
                /* Tinggi disesuaikan untuk ponsel */
            }

            canvas {
                width: 100% !important;
                height: auto !important;
            }
        }
    </style>
    <script>
        let deliveryThisMonth = @json($deliveryThisMonth);
        let overdueThisMonth = @json($overdueThisMonth);

        var deliveryChart = {
            series: [{
                name: 'Delivery',
                data: [deliveryThisMonth]
            }, {
                name: 'Overdue',
                data: [overdueThisMonth]
            }],
            chart: {
                type: 'bar',
                height: 350,
            },
            colors: ['#3498db', '#e74c3c'], // Warna Delivery dan Overdue
            xaxis: {
                categories: ['Today'],
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), deliveryChart);
        chart.render();
    </script>
    @if (isset($closedOrdersData))
        <script>
            var closedOrders = @json($closedOrdersData);
        </script>
    @else
        <script>
            console.error("closedOrdersData is not defined or empty");
        </script>
    @endif
    <div class="container-fluid">
        <div class="col-12">
            {{-- sweetalert --}}
            <script>
            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{!! session('success') !!}',
                // timer: 1500,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__bounceInDown' // Menambahkan animasi muncul
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp' // Menambahkan animasi saat ditutup
                },
            });
         @endif
         </script>
            {{-- end --}}
            {{-- start filter --}}
            @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                <form method="GET" action="{{ route('dashboard') }}" id="filter-form"
                    class="p-3 bg-light rounded shadow-sm bounce-in">
                    <div class="row">
                            <div class="col-md-6">
                                <label for="month" class="form-label fw-bold text-primary">Select Month:</label>
                                <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="year" class="form-label fw-bold text-primary">Select Year:</label>
                                <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                                    @foreach (range(now()->year - 5, now()->year) as $y)
                                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
            </form>
            @endif
            {{-- viewer --}}
            @if (Auth::check() && Auth::user()->role == 'viewer')
                <form method="GET" action="{{ route('dashboard.viewer') }}" id="filter-form"
                    class="p-3 bg-light rounded shadow-sm bounce-in">
                    <div class="row">
                        @if (Auth::check() && Auth::user()->role == 'viewer')
                            <div class="col-md-6">
                                <label for="month" class="form-label fw-bold text-primary">Select Month:</label>
                                <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="year" class="form-label fw-bold text-primary">Select Year:</label>
                                <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                                    @foreach (range(now()->year - 5, now()->year) as $y)
                                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
            @endif
            </form>
            @endif
            {{-- endfilter --}}
            <div class="card bounce-in">
                <div class="card-header bg-primary">
                    Month's Report
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                            <div class="col-6 col-md-6">
                                <div class="stat-box bg-success pulse" onclick="window.location.href='/report/closed'">
                                    <h4 class="text-white"><b>Close</b></h4>
                                    <h3 id="produksiToday" class="stat-number">{{ $deliveryThisMonth }}</h3>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="stat-box bg-danger pulse" onclick="window.location.href='/report/delay'">
                                    <h4 class="text-white"><b>Delay</b></h4>
                                    <h3 id="deliveryToday" class="stat-number">{{ $overdueThisMonth }}</h3>
                                </div>
                            </div>
                    </div>
                    @endif
                    @if (Auth::check() && Auth::user()->role == 'viewer')
                        <div class="col-6 col-md-6">
                            <div class="stat-box bg-success pulse" onclick="window.location.href='/report/closed/viewer'">
                                <h4 class="text-white"><b>Close</b></h4>
                                <h3 id="produksiToday" class="stat-number">{{ $deliveryThisMonth }}</h3>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="stat-box bg-danger pulse" onclick="window.location.href='/report/delay/viewer'">
                                <h4 class="text-white"><b>Delay</b></h4>
                                <h3 id="deliveryToday" class="stat-number">{{ $overdueThisMonth }}</h3>
                            </div>
                        </div>
                </div>
                @endif
            </div>
        </div>
        <!--  Row 1 -->
    </div>
    {{-- report delivery --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Report Delivery</h5>

                <!-- Pie Chart -->
                <div id="pieChart"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        // Data dari controller
                        const closedOrders = {{ $data->sum('total_closed') }};
                        const totalOrders = {{ $data->sum('total_order') }};
                        const delayedOrders = {{ $data->sum('total_delay') }};

                        new ApexCharts(document.querySelector("#pieChart"), {
                            series: [closedOrders, totalOrders - closedOrders - delayedOrders, delayedOrders],
                            chart: {
                                height: 350,
                                type: 'pie',
                                toolbar: {
                                    show: true
                                }
                            },
                            labels: ['Closed Orders', 'In Progress Orders', 'Delayed Orders'],
                            colors: ['#28a745', '#007bff', '#dc3545'], // Warna untuk masing-masing segmen
                            legend: {
                                position: 'bottom',
                                labels: {
                                    colors: ['#000'],
                                    useSeriesColors: false
                                }
                            },
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        width: 300
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        }).render();
                    });
                </script>
                <!-- End Pie Chart -->
            </div>
        </div>
    </div>

    {{-- chart delivery Per-customer --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Report Per-Customer</h5>
                <!-- Bar Chart -->
                <canvas id="customerChart" width="140" height="80"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('customerChart').getContext('2d');

                    // Data dari controller
                    const chartData = @json($data);

                    const labels = chartData.map(item => item.customer);
                    const totalOrders = chartData.map(item => item.total_order);
                    const totalClosed = chartData.map(item => item.total_closed);
                    const totalDelay = chartData.map(item => item.total_delay);

                    // Hitung Achievement dalam persen
                    const achievement = chartData.map(item => {
                        if (item.total_order > 0) {
                            return ((item.total_closed / item.total_order) * 100).toFixed(2);
                        }
                        return 0; // Jika total order 0, achievement juga 0
                    });

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Total Orders',
                                    data: totalOrders,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Biru
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    stack: 'general',
                                },
                                {
                                    label: 'Closed Orders',
                                    data: totalClosed,
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Hijau
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    stack: 'progress',
                                },
                                {
                                    label: 'Delayed Orders',
                                    data: totalDelay,
                                    backgroundColor: 'rgba(255, 99, 132, 0.6)', // Merah
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                    stack: 'progress',
                                },
                                {
                                    label: 'Achievement (%)',
                                    data: achievement,
                                    type: 'line', // Line chart untuk Achievement
                                    borderColor: 'red',
                                    borderWidth: 2,
                                    yAxisID: 'y1', // Arahkan ke y-axis kedua
                                    fill: false,
                                    pointStyle: 'circle',
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        font: {
                                            size: 12, // Ukuran font legend
                                        },
                                    },
                                },
                            },
                            layout: {
                                padding: { // Menambahkan padding
                                    top: 10,
                                    left: 5,
                                    right: 5,
                                    bottom: 10,
                                },
                            },
                            scales: {
                                x: {
                                    stacked: true, // Stacked bar pada skala X
                                    title: {
                                        display: true,
                                        text: 'Customer',
                                        font: {
                                            size: 12,
                                            weight: 'bold',
                                        },
                                    },
                                    ticks: {
                                        font: {
                                            size: 10,
                                        },
                                        maxRotation: 0,
                                        autoSkip: false,
                                        callback: function(value, index, values) {
                                            let label = this.getLabelForValue(value);
                                            return label.length > 15 ? label.substring(0, 12) + '...' : label;
                                        },
                                    },
                                },
                                y: {
                                    beginAtZero: true,
                                    stacked: true,
                                    max: 100,
                                    ticks: {
                                        stepSize: 5, // Kelipatan 5
                                        callback: function(value) {
                                            return value % 5 === 0 ? value :
                                                ''; // Pastikan hanya nilai kelipatan 5 yang muncul
                                        },
                                    },
                                    title: {
                                        display: true,
                                        text: 'Order Count',
                                        font: {
                                            size: 12,
                                            weight: 'bold',
                                        },
                                    },
                                },
                                y1: {
                                    beginAtZero: true,
                                    position: 'right',
                                    max: 100,
                                    ticks: {
                                        stepSize: 10, // Kelipatan 5 untuk Achievement
                                        callback: function(value) {
                                            return value % 5 === 0 ? value :
                                                ''; // Pastikan hanya nilai kelipatan 10 yang muncul
                                        },
                                    },
                                    title: {
                                        display: true,
                                        text: 'Achievement (%)',
                                        font: {
                                            size: 12,
                                            weight: 'bold',
                                        },
                                    },
                                    grid: {
                                        drawOnChartArea: false, // Hilangkan garis untuk y1 agar tidak mengganggu
                                    },
                                },
                            },
                        },
                    });
                });
            </script>
        </div>
    </div>
    </div>
@endsection
