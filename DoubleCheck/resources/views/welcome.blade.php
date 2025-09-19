<!DOCTYPE html>
<html>
    <head>
        <base target="_top" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- AG Grid CSS (v32, aman) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-grid.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-alpine.css">

        <!-- AG Grid JS (v32) -->
        <script src="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/dist/ag-grid-community.min.js"></script>


        <meta http-equiv="refresh" content="15">
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}?v=1.1.0" />

        <title>Sistem Double Check Delivery</title>
    </head>
    <body>
        <header class="main-header">
            <div class="header-title-container">
                <img
                    src="https://jajaleun.com/monitortruck/logo.svg"
                    alt="Logo"
                    class="header-logo"
                />
                <h1>
                    Delivery Monitoring Dashboard
                    <span id="customer-title-display"></span>
                </h1>
            </div>
            <form class="controls-container" id="filterForm">
                <div class="filter-group">
                    <select id="customerSelect">
                        <option value="all">Semua Customer</option>
                        <option value="HPM" {{ request()->
                            get('customer') == 'HPM' ? 'selected' : '' }}>HPM
                        </option>
                        <option value="ADM" {{ request()->
                            get('customer') == 'ADM' ? 'selected' : '' }}>ADM
                        </option>
                        <option value="HINO" {{ request()->
                            get('customer') == 'HINO' ? 'selected' : ''}}>HINO
                        </option>
                        <option value="MMKI" {{ request()->
                            get('customer') == 'MMKI' ? 'selected' : ''}}>MMKI
                        </option>
                        <option value="SUZUKI" {{ request()->
                            get('customer') == 'SUZUKI' ? 'selected' :
                            ''}}>SUZUKI
                        </option>
                        <option value="TMMIN" {{ request()->
                            get('customer') == 'TMMIN' ? 'selected' : ''}}>TMMIN
                        </option>
                    </select>
                </div>
                <div class="filter-group">
                    <input
                        type="date"
                        id="dateFilter"
                        value="{{ request()->get('date') ?? date('Y-m-d') }}"
                    />
                </div>
                <div class="login-theme-group">
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch" for="checkbox">
                            <input type="checkbox" id="checkbox" />
                            <div class="slider round"></div>
                        </label>
                    </div>
                    <a class="button" href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </header>

        <div id="loader">Loading data...</div>

        <div class="dashboard-container" id="mainDashboard">
            <div class="card card-order">
                <div>
                    <div class="kpi-title">📦 Order (Manifest/DN)</div>
                        <div id="order-value" class="kpi-value">
                            <span id="order-actual" class="actual-value completed">...</span>
                            <span class="plan-divider">/</span>
                            <span id="order-plan" class="plan-value">...</span>
                        </div>
                    <div id="order-pending" class="kpi-pending">...</div>
                </div>
                <div class="chart-container">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
            <div class="card card-prepare">
                <div>
                    <div class="kpi-title">🔧 Prepare (Pcs)</div>
                    <div id="prepare-value" class="kpi-value">
                            <span id="prepare-actual" class="actual-value">...</span>
                            <span class="plan-divider">/</span>
                            <span id="prepare-plan" class="plan-value">...</span>
                    </div>
                    <div id="prepare-pending" class="kpi-pending">...</div>
                </div>
                <div class="chart-container">
                    <canvas id="prepareChart"></canvas>
                </div>
            </div>
            <div class="card card-leader-check">
                <div>
                    <div class="kpi-title">👨‍💼 Leader Check (Pcs)</div>
                    <div id="leader-value" class="kpi-value">
                        <span id="leader-actual" class="actual-value">...</span>
                        <span class="plan-divider">/</span>
                        <span id="leader-plan" class="plan-value">...</span>
                    </div>
                    <div id="leader-pending" class="kpi-pending">...</div>
                </div>
                <div class="chart-container">
                    <canvas id="leaderCheckChart"></canvas>
                </div>
            </div>
            <div class="card card-doc-check">
                <div>
                    <div class="kpi-title">📋 Document Loading</div>
                    <div id="docCheck-value" class="kpi-value">
                        <span id="docCheck-actual" class="actual-value">...</span>
                        <span class="plan-divider">/</span>
                        <span id="docCheck-plan" class="plan-value">...</span>
                    </div>
                    <div id="docCheck-pending" class="kpi-pending">...</div>
                </div>
                <div class="chart-container">
                    <canvas id="docCheckChart"></canvas>
                </div>
            </div>
            <div class="card card-loading">
                <div>
                    <div class="kpi-title">📦 Pcs Loading</div>
                    <div id="loading-value" class="kpi-value">
                        <span id="loading-actual" class="actual-value">...</span>
                        <span class="plan-divider">/</span>
                        <span id="loading-plan" class="plan-value">...</span>
                    </div>
                    <div id="loading-pending" class="kpi-pending">...</div>
                </div>
                <div class="chart-container">
                    <canvas id="loadingChart"></canvas>
                </div>
            </div>
        </div>

        @livewire('running-text')
        <!-- Modal Simple -->
        @include('partials.modal.modal')

        <footer>
            <div class="text-sm text-gray-500 mt-2">
                Last updated {{ $lastUpdate->diffForHumans() }}
            </div>
            <p>
                © <span id="footer-year"></span> - Delivery KBI | v{{ config('app.version') }}
            </p>
        </footer>
    </body>

    <script>
        window.chartData = @json($charts);
        window.dataActual = @json($dataActual);
        window.dataPlan = @json($dataPlan);

        window.g_heroRoute = "{{ route('hero') }}";
        window.g_modalTable = "{{ route('modalTable') }}";
    </script>
    @vite('resources/js/app.js')

</html>
