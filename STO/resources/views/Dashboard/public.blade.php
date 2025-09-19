<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Inventory - STO KBI</title>
    <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px 0;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            margin: 10px 0;
            min-height: calc(100vh - 20px);
            display: flex;
            flex-direction: column;
        }

        .header-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 20px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 10;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1.5" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.2"/><circle cx="90" cy="40" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="80" r="1.2" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            position: relative;
            z-index: 2;
            flex: 1;
            text-align: left;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .header-title-container {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .selects-container {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
        }

        .logo-section {
            margin-bottom: 5px;
        }

        .dashboard-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            filter: brightness(1.1) drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
        }

        .dashboard-logo:hover {
            transform: scale(1.05);
        }

        .dashboard-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .auto-refresh-control {
            margin-top: 12px;
            opacity: 0.9;
        }

        .auto-refresh-control button {
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        .auto-refresh-control button:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.8);
        }

        #refreshIcon {
            animation: none;
        }

        #refreshIcon.spinning {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .dashboard-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .stats-row {
            margin-top: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 15px 10px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 85px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-top: 3px;
        }

        .content-section {
            padding: 20px 30px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .charts-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            gap: 20px;
            min-height: 0;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 300px;
        }

        .chart-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .chart-title i {
            color: #667eea;
            font-size: 1.1rem;
        }

        .filter-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 10px 14px;
            transition: all 0.3s ease;
            background: white;
            font-size: 0.9rem;
            height: 40px;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.4);
        }

        .no-data {
            text-align: center;
            padding: 40px 15px;
            color: #64748b;
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .badge {
            border-radius: 4px;
            font-weight: 500;
            padding: 4px 8px;
        }

        .footer-section {
            background: #1a202c;
            color: white;
            padding: 10px 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .footer-section p {
            margin: 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Slide indicators */
        .slide-indicators {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .slide-indicator {
            width: 10px;
            height: 10px;
            background-color: rgba(165, 158, 158, 0.4);
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
        }

        .slide-indicator.active {
            background-color: #656262;
            transform: scale(1.2);
        }

        /* Countdown Timer */
        .countdown-timer {
            position: fixed;
            bottom: 10px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
            z-index: 9999;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .countdown-timer:hover {
            transform: scale(1.1);
            background: rgba(0, 0, 0, 0.9);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        /* Enhanced Table Styles for Professional Look */
        .table-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 300px;
            overflow: auto;
        }

        .inventory-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 0 1px #e2e8f0;
        }

        .inventory-table th {
            background-color: #1e3c72;
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
            padding: 12px;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            border-bottom: 2px solid #2a5298;
        }

        .inventory-table td {
            padding: 12px 10px;
            border: none;
            text-align: center;
            vertical-align: middle;
            font-size: 0.9rem;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .inventory-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .inventory-table tr:hover {
            background-color: #edf2f7;
        }

        .inventory-table tr:last-child td {
            border-bottom: none;
        }

        /* Highlight cells with warnings */
        .warning-cell {
            color: #ef4444 !important;
            font-weight: 600;
        }

        .good-cell {
            color: #10b981 !important;
            font-weight: 600;
        }

        .medium-cell {
            color: #f59e0b !important;
            font-weight: 600;
        }

        /* Customer badge styling */
        .customer-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.75rem;
            margin-left: 8px;
            display: inline-block;
            vertical-align: middle;
        }

        /* Logo kecil di pojok kanan atas */
        .dashboard-logo-small {
            width: 40px;
            height: 40px;
            object-fit: contain;
            filter: brightness(1.1) drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
            margin-left: 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 11;
            pointer-events: auto;
        }

        .dashboard-title-small {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0;
            margin-left: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        }

        /* Improved header layout and selects positioning */
        .header-content {
            position: relative;
            z-index: 2;
            flex: 1;
            text-align: left;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .header-title-container {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .selects-container {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
        }

        /* Make selects more compact */
        .compact-select {
            min-width: 140px;
            width: auto;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 4px 8px;
            font-size: 0.9rem;
            height: 36px;
            transition: all 0.3s ease;
        }

        .compact-select option {
            background-color: #2a5298;
            color: white;
            padding: 4px 8px;
        }

        /* Select2 custom styling for more compact appearance */
        .select2-container--bootstrap-5.select2-compact .select2-selection {
            height: 36px;
            min-height: 36px;
            padding: 4px 8px;
            font-size: 0.9rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
        }

        /* Make the remove/clear button (x) white and more visible */
        .select2-container--bootstrap-5.select2-compact .select2-selection__clear {
            color: white !important;
            opacity: 1 !important;
            margin-right: 5px;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 0 5px;
            line-height: 1;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 20px;
            width: 20px;
        }

        .select2-container--bootstrap-5.select2-compact .select2-selection__clear:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.1);
        }

        /* Adjust positioning of the clear button */
        .select2-container--bootstrap-5.select2-compact .select2-selection--single {
            padding-right: 30px;
            /* Make room for the clear button */
        }

        /* Fix clear button position for single selection */
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Make sure the clear button doesn't overlap with the dropdown arrow */
        .select2-container--bootstrap-5.select2-compact .select2-selection__arrow {
            right: 5px;
        }

        .select2-container--bootstrap-5.select2-compact {
            width: auto !important;
            min-width: 159px !important;
        }

        .select2-container--bootstrap-5.select2-compact .select2-selection__rendered {
            color: white !important;
        }

        .select2-container--bootstrap-5.select2-compact .select2-selection__placeholder {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .select2-container--bootstrap-5.select2-compact .select2-selection__arrow b {
            border-color: white transparent transparent transparent;
        }

        .select2-container--bootstrap-5.select2-compact.select2-container--open .select2-selection__arrow b {
            border-color: transparent transparent white transparent;
        }

        /* Improve dropdown styling */
        .select2-dropdown {
            background-color: #2a5298 !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }

        .select2-container--bootstrap-5 .select2-dropdown .select2-results__option {
            color: white;
            padding: 6px 12px;
        }

        .select2-container--bootstrap-5 .select2-results__option--selected {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-title-container {
                margin-bottom: 10px;
                width: 100%;
            }

            .selects-container {
                width: 100%;
                justify-content: space-between;
            }

            .compact-select,
            .select2-container--bootstrap-5.select2-compact {
                width: 48% !important;
                min-width: unset !important;
            }
        }

        .dashboard-title-small {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0;
            margin-left: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-12">
                <div class="dashboard-container">
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="header-content">
                            <!-- Logo and Title -->
                            <div class="header-title-container">
                                <img src="{{ asset('assets/img/icon-kbi.png') }}" alt="KBI Logo"
                                    class="dashboard-logo-small">
                                <span class="dashboard-title-small">Dashboard Inventory</span>
                            </div>

                            <!-- Selects Container for side-by-side placement -->
                            <div class="selects-container">
                                <!-- Select Kategori -->
                                <select id="categorySelect" class="compact-select" tabindex="0"></select>

                                <!-- Select Customer -->
                                <select id="customerSelect" class="compact-select" tabindex="0">
                                    <option value="" selected>All Customers</option>
                                </select>

                                <!-- Date Picker -->
                                <input type="date" id="dateSelect" class="compact-select" style="min-width:130px;" />
                                <!-- Reset Button -->
                                <button id="resetDateBtn" type="button" class="btn btn-light btn-sm ms-1"
                                    title="Reset ke hari ini">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </button>
                            </div>
                        </div>

                        <div class="header-right mt-1" style="z-index:11; pointer-events:auto;">
                            {{-- <span class="badge bg-primary fs-6" id="currentCategoryDisplay">Loading...</span> --}}
                            <span class="badge bg-light text-primary px-2 py-1" id="dataDateDisplay">
                                <i class="bi bi-calendar3"></i> Loading...
                            </span>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="content-section">
                        <!-- Content slideshow container -->
                        <div class="slideshow-container">
                            <!-- Slide 1: Charts Container -->
                            <div class="slide charts-container" id="chartSlide">
                                <!-- Stock Overview Chart -->
                                <div class="chart-card fade-in">
                                    {{-- <div class="data-type-indicator" id="actualChartType"></div> --}}
                                    <h3 class="chart-title">
                                        <i class="bi bi-bar-chart"></i>
                                        Actual Stock
                                    </h3>
                                    <div id="stockOverviewChart" style="height: 280px; flex: 1;"></div>
                                </div>

                                <!-- Daily Stock Classification Chart -->
                                <div class="chart-card fade-in mt-1">
                                    <h3 class="chart-title">
                                        <i class="bi bi-calendar-check"></i>
                                        Day's Stock
                                    </h3>
                                    <div id="dailyStockChart" style="height: 280px; flex: 1;"></div>
                                </div>
                            </div>

                            <!-- Slide 2: Data Table -->
                            <div class="slide table-card" id="tableSlide" style="display: none;">
                                <div class="data-type-indicator" id="tableDataType"></div>
                                <h3 class="chart-title">
                                    <i class="bi bi-table"></i>
                                    <span id="tableTitle">Inventory Detail</span>
                                </h3>
                                <div class="text-muted small mb-1"
                                    style="font-style: italic; font-size: 0.8rem; opacity: 0.8;">
                                    <i class="bi bi-info-circle-fill me-1"></i>
                                    Note: Customer yang di tampilkan hanya:ADM,MMKI,HPM,ITSP,TMMIN
                                </div>
                                <div class="table-responsive">
                                    <table class="inventory-table">
                                        <thead>
                                            <tr>
                                                <th>INV ID</th>
                                                <th>PART NAME</th>
                                                <th>PART NO</th>
                                                <th>CUSTOMER</th>
                                                <th>MIN STOCK</th>
                                                <th>MAX STOCK</th>
                                                <th>ACTUAL QTY</th>
                                                <th>DAYS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="inventoryTableBody">
                                            <tr>
                                                <td colspan="8" class="text-center">Loading data...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination info -->
                                <div class="pagination-info">
                                    <span class="page-indicator" id="pageIndicator">Page 1 of 1</span>
                                </div>
                                <!-- Manual Pagination Bootstrap -->
                                <nav>
                                    <ul class="pagination justify-content-center" id="tablePagination"></ul>
                                </nav>
                            </div>

                            <!-- Slide indicators -->
                            <div class="slide-indicators">
                                <span class="slide-indicator active" data-slide="0"></span>
                                <span class="slide-indicator" data-slide="1"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    {{-- <div class="footer-section">
                        <p>&copy;2025. Sto Management System</p>
                    </div> --}}
                    <div class="countdown-timer" id="countdownTimer">10</div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        class PublicDashboard {
            constructor() {
                this.stockChart = null;
                this.dailyChart = null;
                this.customers = [];
                this.categories = [];
                this.categoryStats = {};
                this.autoRefreshInterval = null;
                this.categoryRotationInterval = null;
                this.slideInterval = null;
                this.countdownInterval = null;
                this.tablePageInterval = null;
                this.autoRefreshEnabled = true;
                this.lastUserActivity = Date.now();
                this.currentCategory = null;
                this.categoryIndex = 0;
                this.currentSlide = 0;
                this.countdown = 10;
                this.pageCountdown = 5;
                this.isHistoricalMode = false;
                this.tableData = [];
                this.currentPage = 1;
                this.itemsPerPage = 10;
                this.isPaused = false; // New property to track pause state

                // Set default category to Finished Good (assuming ID = 1)
                this.finishedGoodCategoryId = 1;
                this.currentCategory = this.finishedGoodCategoryId;

                this.rotationState = 'chart';
                this.allCategoriesOption = {
                    id: "0",
                    name: 'Semua Kategori'
                };
                this.manualCategorySelected = false;

                this.selectedCustomer = '';
                // --- Pastikan default date adalah hari ini (YYYY-MM-DD) ---
                this.selectedDate = new Date().toISOString().split('T')[0];

                this.init();
            }

            init() {
                this.bindEvents();
                // --- Set default date picker value ke hari ini ---
                document.getElementById('dateSelect').value = this.selectedDate;
                this.loadInitialData();
                this.startAutoRefresh();
                this.startCategoryRotation();
                this.startCountdown();
                this.startSlideshow();
                this.startTablePagination();
                this.initializeSelect2();
                this.loadCustomerOptions();
                this.setupPauseEvents();

                // Cleanup on page unload
                window.addEventListener('beforeunload', () => {
                    this.stopAutoRefresh();
                    this.stopCategoryRotation();
                    this.stopCountdown();
                    this.stopSlideshow();
                    this.stopTablePagination();
                });
            }

            initializeSelect2() {
                // Initialize Select2 for customer dropdown with compact styling and improved templates
                $('#customerSelect').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'All Customers',
                    allowClear: true,
                    width: 'resolve',
                    dropdownCssClass: 'select2-dropdown-customer',
                    minimumResultsForSearch: 5, // Show search only if many options
                    templateResult: (state) => {
                        if (!state.id) return state.text;
                        return $(
                            `<span class="customer-option"><span class="customer-badge customer">${state.text}</span></span>`
                        );
                    },
                    templateSelection: (state) => {
                        if (!state.id) return state.text;
                        // Plain white text for selected item
                        return $(`<span style="color: white;">${state.text}</span>`);
                    }
                }).data('select2').$container.addClass('select2-compact');

                // Add pause/resume events for the dropdown
                $('#customerSelect').on('select2:open', () => {
                    this.pause();
                });

                $('#customerSelect').on('select2:close', () => {
                    this.resume();
                });
            }

            loadCustomerOptions() {
                // Ambil data customer dari API dan populate select
                fetch('api/public/dashboard/customers')
                    .then(res => res.json())
                    .then(data => {
                        const select = document.getElementById('customerSelect');
                        if (!select) return;
                        // Clear existing options but keep the "All Customers" option
                        select.innerHTML = '<option value="" selected>All Customers</option>';
                        data.forEach(cust => {
                            const opt = document.createElement('option');
                            opt.value = cust.username;
                            opt.textContent = cust.username;
                            select.appendChild(opt);
                        });
                        // Refresh Select2 to update the options
                        $('#customerSelect').trigger('change');
                    })
                    .catch(error => {
                        console.error('Error loading customer options:', error);
                    });
            }

            bindEvents() {
                // Track user activity
                const trackActivity = () => {
                    this.lastUserActivity = Date.now();
                };

                document.addEventListener('mousemove', trackActivity);
                document.addEventListener('click', trackActivity);

                // Current/Historical toggle
                document.querySelectorAll('.data-toggle-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.data-toggle-btn').forEach(b => b.classList.remove(
                            'active'));
                        btn.classList.add('active');

                        this.isHistoricalMode = btn.dataset.type === 'historical';
                        this.refreshAll();
                        this.updateDataTypeIndicators();
                    });
                });

                // Slide indicators
                document.querySelectorAll('.slide-indicator').forEach(indicator => {
                    indicator.addEventListener('click', () => {
                        const slideIndex = parseInt(indicator.dataset.slide);
                        this.changeSlide(slideIndex);
                    });
                });

                // Pasang event listener satu kali di sini
                const categorySelect = document.getElementById('categorySelect');
                if (categorySelect) {
                    categorySelect.addEventListener('change', (e) => {
                        const val = e.target.value;
                        this.manualCategorySelected = true;
                        this.currentCategory = val;
                        this.categoryIndex = val === "0" ? 0 : this.categories.findIndex(c => c.id === val) + 1;
                        this.refreshAll();
                        this.changeSlide(0);
                        document.getElementById('currentCategoryDisplay').textContent = this
                            .getCategoryNameById(val);
                    });
                }

                // Event handler untuk select customer dengan Select2
                $('#customerSelect').on('change', (e) => {
                    this.selectedCustomer = e.target.value;
                    this.refreshChartsOnly();
                    // Tambahkan ini agar table ikut filter customer
                    this.loadInventoryTableData();
                });

                // Date picker event
                const dateSelect = document.getElementById('dateSelect');
                if (dateSelect) {
                    dateSelect.addEventListener('change', (e) => {
                        this.selectedDate = e.target.value;
                        this.refreshAll();
                    });
                }
                // Reset button event
                const resetBtn = document.getElementById('resetDateBtn');
                if (resetBtn && dateSelect) {
                    resetBtn.addEventListener('click', () => {
                        // --- Reset ke hari ini ---
                        const today = new Date().toISOString().split('T')[0];
                        this.selectedDate = today;
                        dateSelect.value = today;
                        this.refreshAll();
                    });
                }
            }

            startAutoRefresh() {
                // Auto refresh every 30 seconds
                this.autoRefreshInterval = setInterval(() => {
                    // Only auto-refresh if user hasn't been active in the last 30 seconds
                    const timeSinceLastActivity = Date.now() - this.lastUserActivity;
                    if (timeSinceLastActivity > 30000 && this.autoRefreshEnabled) {
                        console.log('Auto-refreshing dashboard data...');
                        this.refreshAll();
                    }
                }, 30000); // 30 seconds
            }

            startCategoryRotation() {
                // Stop existing rotation if any
                if (this.categoryRotationInterval) {
                    clearInterval(this.categoryRotationInterval);
                }

                this.categoryRotationInterval = setInterval(() => {
                    if (this.isPaused) return; // Skip rotation if paused

                    // Jika user pilih manual kategori (bukan "Semua Kategori"), rotasi chart/table pada kategori itu saja
                    if (this.manualCategorySelected && this.currentCategory !== "0") {
                        if (this.rotationState === 'chart') {
                            this.changeSlide(1);
                            this.rotationState = 'table';
                            this.tablePageCounter = 1;
                            this.currentPage = 1;
                        } else {
                            const totalPages = Math.ceil(this.tableData.length / this.itemsPerPage);
                            if (!this.tablePageCounter) this.tablePageCounter = 1;
                            if (this.tablePageCounter < totalPages) {
                                this.currentPage = this.tablePageCounter + 1;
                                this.renderTablePage();
                                this.tablePageCounter++;
                            } else {
                                this.tablePageCounter = 0;
                                this.currentPage = 1;
                                this.refreshAll();
                                this.changeSlide(0);
                                this.rotationState = 'chart';
                            }
                        }
                        return;
                    }
                    // Jika "Semua Kategori" atau belum melakukan select kategori, rotasi hanya chart/table pada kategori itu saja, tidak pindah kategori
                    if (!this.manualCategorySelected || this.currentCategory === "0") {
                        if (this.rotationState === 'chart') {
                            this.changeSlide(1);
                            this.rotationState = 'table';
                            this.tablePageCounter = 1;
                            this.currentPage = 1;
                        } else {
                            const totalPages = Math.ceil(this.tableData.length / this.itemsPerPage);
                            if (!this.tablePageCounter) this.tablePageCounter = 1;
                            if (this.tablePageCounter < totalPages) {
                                this.currentPage = this.tablePageCounter + 1;
                                this.renderTablePage();
                                this.tablePageCounter++;
                            } else {
                                // Setelah halaman terakhir, balik ke chart awal kategori yang sama
                                this.tablePageCounter = 0;
                                this.currentPage = 1;
                                this.refreshAll();
                                this.changeSlide(0);
                                this.rotationState = 'chart';
                            }
                        }
                        return;
                    }
                    // Jika "Semua Kategori", rotasi ke semua kategori
                    if (this.rotationState === 'chart') {
                        this.changeSlide(1);
                        this.rotationState = 'table';
                        this.tablePageCounter = 1;
                        this.currentPage = 1;
                    } else {
                        const totalPages = Math.ceil(this.tableData.length / this.itemsPerPage);
                        if (!this.tablePageCounter) this.tablePageCounter = 1;
                        if (this.tablePageCounter < totalPages) {
                            this.currentPage = this.tablePageCounter + 1;
                            this.renderTablePage();
                            this.tablePageCounter++;
                        } else {
                            this.tablePageCounter = 0;
                            this.currentPage = 1;
                            this.categoryIndex++;
                            if (this.categoryIndex >= this.categories.length) {
                                this.categoryIndex = 1;
                            }
                            this.currentCategory = this.categories[this.categoryIndex].id;
                            document.getElementById('categorySelect').value = this.currentCategory;
                            document.getElementById('currentCategoryDisplay').textContent = this
                                .getCategoryNameById(this.currentCategory);
                            this.refreshAll();
                            this.changeSlide(0);
                            this.rotationState = 'chart';
                        }
                    }
                }, 10000); // 10 seconds for charts, 5 seconds for table pages handled by table pagination
            }

            rotateCategoryOrTable() {
                // If on chart, switch to table for current category
                if (this.currentSlide === 0) {
                    this.changeSlide(1); // Show table for current category
                } else {
                    // If on table, move to next category and show its chart
                    this.categoryIndex++;
                    if (this.categoryIndex > this.categories.length) {
                        this.categoryIndex = 1; // Loop back to first category
                    }
                    this.currentCategory = this.categories[this.categoryIndex - 1].id;
                    const categoryName = this.categories[this.categoryIndex - 1].name;
                    document.getElementById('currentCategoryDisplay').textContent = categoryName;
                    this.refreshAll();
                    this.changeSlide(0); // Show chart for new category
                }
            }

            startCountdown() {
                // Stop existing countdown if any
                if (this.countdownInterval) {
                    clearInterval(this.countdownInterval);
                }

                // Update countdown timer every second
                this.countdownInterval = setInterval(() => {
                    if (!this.isPaused) {
                        this.updateCountdown();
                    }
                }, 1000); // 1 second
            }

            startSlideshow() {
                // Stop existing slideshow if any
                if (this.slideInterval) {
                    clearInterval(this.slideInterval);
                }

                // Change slides every 20 seconds (2 category rotations)
                this.slideInterval = setInterval(() => {
                    if (!this.isPaused) {
                        this.rotateSlide();
                    }
                }, 20000); // 20 seconds
            }

            startTablePagination() {
                // Auto-rotate table pages every 5 seconds without countdown
                if (this.tablePageInterval) clearInterval(this.tablePageInterval);
                this.tablePageInterval = setInterval(() => {
                    if (!this.isPaused && this.currentSlide === 1 && this.tableData.length > this
                        .itemsPerPage) {
                        this.nextTablePage();
                    }
                }, 5000);
            }

            stopAutoRefresh() {
                if (this.autoRefreshInterval) {
                    clearInterval(this.autoRefreshInterval);
                    this.autoRefreshInterval = null;
                }
            }

            stopCategoryRotation() {
                if (this.categoryRotationInterval) {
                    clearInterval(this.categoryRotationInterval);
                    this.categoryRotationInterval = null;
                }
            }

            stopCountdown() {
                if (this.countdownInterval) {
                    clearInterval(this.countdownInterval);
                    this.countdownInterval = null;
                }
            }

            stopSlideshow() {
                if (this.slideInterval) {
                    clearInterval(this.slideInterval);
                    this.slideInterval = null;
                }
            }

            stopTablePagination() {
                if (this.tablePageInterval) {
                    clearInterval(this.tablePageInterval);
                    this.tablePageInterval = null;
                }
            }

            updateCountdown() {
                // Only update countdown for chart view
                if (this.currentSlide === 0) {
                    this.countdown--;
                    document.getElementById('countdownTimer').textContent = this.countdown;

                    if (this.countdown <= 0) {
                        this.countdown = 10;
                    }
                }
            }

            rotateCategory() {
                if (this.categories && this.categories.length > 0) {
                    this.countdown = 10;

                    // Check if we've gone through all categories
                    const hasCompletedAllCategories = this.categoryIndex >= this.categories.length;

                    // Skip All Categories (index 0) by starting from index 1
                    if (hasCompletedAllCategories || this.categoryIndex === 0) {
                        // Always go back to Finished Good if possible
                        const finishedGoodIndex = this.categories.findIndex(c =>
                            c.id === this.finishedGoodCategoryId ||
                            c.name.toLowerCase().includes('finished') ||
                            c.name.toLowerCase().includes('finish')
                        );

                        this.categoryIndex = (finishedGoodIndex !== -1) ? finishedGoodIndex + 1 : 1;

                        // If we've gone through all categories, switch back to chart view
                        if (hasCompletedAllCategories && this.currentSlide === 1) {
                            this.changeSlide(0);
                        }
                    } else {
                        this.categoryIndex++;
                    }

                    this.currentCategory = this.categories[this.categoryIndex - 1].id;
                    const categoryName = this.categories[this.categoryIndex - 1].name;
                    document.getElementById('currentCategoryDisplay').textContent = categoryName;

                    // Always refresh data for the new category
                    this.refreshAll();

                    // Schedule to show the table view after 10 seconds (1 countdown cycle)
                    // Only if we're currently on chart view
                    if (this.currentSlide === 0) {
                        setTimeout(() => {
                            if (this.currentCategory === this.categories[this.categoryIndex - 1].id) {
                                // Only change if we're still on the same category
                                this.changeSlide(1);
                            }
                        }, 10000);
                    }
                }
            }

            nextTablePage() {
                const totalPages = Math.ceil(this.tableData.length / this.itemsPerPage);
                if (totalPages <= 1) return;

                if (this.currentPage < totalPages) {
                    this.currentPage++;
                    this.renderTablePage();
                    this.tablePageCounter = this.currentPage;
                } else {
                    // If we're on the last page, wait for categoryRotation to handle the category change
                    // The logic in startCategoryRotation will take care of this
                }
            }

            renderTablePage() {
                const tableBody = document.getElementById('inventoryTableBody');
                const pageIndicator = document.getElementById('pageIndicator');
                const totalPages = Math.ceil(this.tableData.length / this.itemsPerPage);

                // Update page indicator
                pageIndicator.textContent = `Page ${this.currentPage} of ${totalPages}`;

                if (this.tableData.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No data available</td></tr>`;
                    return;
                }

                // Calculate slice indexes for current page
                const startIndex = (this.currentPage - 1) * this.itemsPerPage;
                const endIndex = Math.min(startIndex + this.itemsPerPage, this.tableData.length);
                const pageData = this.tableData.slice(startIndex, endIndex);

                let html = '';
                pageData.forEach(item => {
                    // Check if day value is "NOFC" or a number
                    let dayClass = '';
                    let dayDisplay = item.day;

                    if (item.day === "NOFC" || item.day === "NaN") {
                        dayClass = 'warning-cell'; // Red for NOFC
                        dayDisplay = "NOFC";
                    } else {
                        const dayValue = parseFloat(item.day) || 0;
                        // Add color coding based on day value
                        if (dayValue <= 1) {
                            dayClass = 'warning-cell'; // Red for critical
                        } else if (dayValue > 1 && dayValue <= 2.5) {
                            dayClass = 'medium-cell'; // Yellow for warning
                        } else {
                            dayClass = 'good-cell'; // Green for good
                        }
                        dayDisplay = dayValue.toFixed(1);
                    }

                    // Handle min and max stock values
                    let minStockDisplay = item.min_stock;
                    let maxStockDisplay = item.max_stock;

                    // Format min_stock for display
                    if (minStockDisplay === "NOFC" || minStockDisplay === "NaN") {
                        minStockDisplay = `<span class="warning-cell">NOFC</span>`;
                    } else {
                        minStockDisplay = this.formatTableNumber(minStockDisplay || 0);
                    }

                    // Format max_stock for display
                    if (maxStockDisplay === "NOFC" || maxStockDisplay === "NaN") {
                        maxStockDisplay = `<span class="warning-cell">NOFC</span>`;
                    } else {
                        maxStockDisplay = this.formatTableNumber(maxStockDisplay || 0);
                    }

                    // Format numbers with thousand separators
                    const actualQty = this.formatTableNumber(item.qty || 0);

                    html += `
            <tr>
                <td>${item.inv_id || '-'}</td>
                <td style="text-align: left">${item.part_name || '-'}</td>
                <td>${item.part_no || '-'}</td>
                <td><span class="customer-badge customer-${item.customer || 'Unknown'}">${item.customer || '-'}</span></td>
                <td>${minStockDisplay}</td>
                <td>${maxStockDisplay}</td>
                <td>${actualQty}</td>
                <td class="${dayClass}">${dayDisplay}</td>
            </tr>
        `;
                });

                tableBody.innerHTML = html;
                this.renderTablePagination(); // Render pagination setiap kali page berubah
            }

            renderTablePagination() {
                const totalPages = Math.ceil(this.tableData.length / this.itemsPerPage);
                const pagination = document.getElementById('tablePagination');
                if (!pagination) return;
                pagination.innerHTML = '';
                if (totalPages <= 1) return;

                // Previous button
                const prevLi = document.createElement('li');
                prevLi.className = `page-item${this.currentPage === 1 ? ' disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="#" tabindex="-1">&laquo;</a>`;
                prevLi.onclick = (e) => {
                    e.preventDefault();
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.renderTablePage();
                        this.isTablePaused = true;
                        this.stopTablePagination();
                    }
                };
                pagination.appendChild(prevLi);

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item${this.currentPage === i ? ' active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    li.onclick = (e) => {
                        e.preventDefault();
                        this.currentPage = i;
                        this.renderTablePage();
                        this.isTablePaused = true;
                        this.stopTablePagination();
                    };
                    pagination.appendChild(li);
                }

                // Next button
                const nextLi = document.createElement('li');
                nextLi.className = `page-item${this.currentPage === totalPages ? ' disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
                nextLi.onclick = (e) => {
                    e.preventDefault();
                    if (this.currentPage < totalPages) {
                        this.currentPage++;
                        this.renderTablePage();
                        this.isTablePaused = true;
                        this.stopTablePagination();
                    }
                };
                pagination.appendChild(nextLi);
            }

            changeSlide(index) {
                const slides = document.querySelectorAll('.slide');
                const indicators = document.querySelectorAll('.slide-indicator');

                slides.forEach((slide, i) => {
                    if (i === index) {
                        slide.style.display = 'flex';
                    } else {
                        slide.style.display = 'none';
                    }
                });

                indicators.forEach((indicator, i) => {
                    if (i === index) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });

                this.currentSlide = index;

                if (index === 1) {
                    // Table slide: reset to first page
                    this.currentPage = 1;
                    this.renderTablePage();
                    this.loadInventoryTableData();
                    this.rotationState = 'table';

                    // Hide countdown for table view
                    document.getElementById('countdownTimer').style.display = 'none';
                } else {
                    // Chart slide: reset countdown to 10s
                    this.countdown = 10;
                    this.rotationState = 'chart';

                    // Show countdown for chart view
                    document.getElementById('countdownTimer').style.display = 'flex';
                }
            }

            updateDataTypeIndicators() {
                const type = this.isHistoricalMode ? 'historical-data' : 'current-data';
                const text = this.isHistoricalMode ? 'Historical' : 'Current';

                document.getElementById('actualChartType').className = `data-type-indicator ${type}`;
                document.getElementById('actualChartType').textContent = text;

                document.getElementById('dailyChartType').className = `data-type-indicator ${type}`;
                document.getElementById('dailyChartType').textContent = text;

                document.getElementById('tableDataType').className = `data-type-indicator ${type}`;
                document.getElementById('tableDataType').textContent = text;
            }

            async loadInitialData() {
                try {
                    await this.loadCategories();

                    // Skip loading all customers, we're using predefined options
                    this.initializeCustomers();

                    // Make sure we start with Finished Good category
                    this.setInitialCategory();

                    // Load initial data with Finished Good category
                    await this.refreshAll();

                    // Set up initial data type indicators
                    this.updateDataTypeIndicators();
                } catch (error) {
                    console.error('Error loading initial data:', error);
                    this.showError('Failed to load dashboard data');
                }
            }

            // Initialize predefined customers
            initializeCustomers() {
                this.customers = [{
                        username: "HPM"
                    },
                    {
                        username: "ADM"
                    },
                    {
                        username: "MMKI"
                    },
                    {
                        username: "ITSP"
                    },
                    {
                        username: "TMMIN"
                    },
                    {
                        username: "ADM-SPD"
                    },
                ];
                this.populateCustomerSelect();
            }

            // Set initial category to Finished Good
            setInitialCategory() {
                if (this.categories && this.categories.length > 0) {
                    // Jika ada Finished Good, pilih itu, jika tidak pilih Semua Kategori
                    const finishedGoodCategory = this.categories.find(c =>
                        c.id === this.finishedGoodCategoryId ||
                        (c.name && c.name.toLowerCase().includes('finished'))
                    );
                    if (finishedGoodCategory) {
                        this.currentCategory = finishedGoodCategory.id;
                        this.categoryIndex = this.categories.findIndex(c => c.id === finishedGoodCategory.id) + 1;
                        document.getElementById('currentCategoryDisplay').textContent = finishedGoodCategory.name;
                        document.getElementById('categorySelect').value = finishedGoodCategory.id;
                    } else {
                        this.currentCategory = "0";
                        this.categoryIndex = 0;
                        document.getElementById('currentCategoryDisplay').textContent = this.allCategoriesOption.name;
                        document.getElementById('categorySelect').value = "0";
                    }
                }
            }

            async loadCategories() {
                try {
                    const response = await fetch('api/public/dashboard/categories');
                    this.categories = await response.json();
                    // Pastikan semua id kategori adalah string
                    this.categories = this.categories.map(c => ({
                        ...c,
                        id: String(c.id)
                    }));
                    this.categories.unshift(this.allCategoriesOption);
                    this.populateCategorySelect();
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }

            populateCustomerSelect() {
                // We're using predefined customers now, so no need to populate from API
                // Just make sure Select2 is initialized properly
                $('#customerSelect').trigger('change');
            }

            populateCategorySelect() {
                const select = document.getElementById('categorySelect');
                if (!select) return;
                select.innerHTML = '';
                this.categories.forEach(cat => {
                    const opt = document.createElement('option');
                    opt.value = cat.id;
                    opt.textContent = cat.name;
                    select.appendChild(opt);
                });
                select.value = String(this.currentCategory || "0");
                // Tidak pasang event listener di sini!
            }

            async refreshChartsOnly() {
                try {
                    const customer = this.selectedCustomer || '';
                    const category = this.currentCategory;
                    const date = this.selectedDate || new Date().toISOString().split('T')[0];
                    await Promise.all([
                        this.loadStockOverview(customer, category, date),
                        this.loadDailyStockClassification(customer, category, date)
                    ]);
                } catch (error) {
                    console.error('Error during chart refresh:', error);
                }
            }

            async refreshAll() {
                try {
                    // Reset date display to loading state before starting requests
                    if (this.dataDateDisplay) {
                        this.dataDateDisplay.className = "badge bg-secondary fs-6 ms-2";
                        this.dataDateDisplay.innerHTML = `<i class="bi bi-hourglass"></i> Loading...`;
                    }

                    // Gunakan customer dari dropdown untuk grafik, tapi tabel tetap all customer
                    const customer = this.selectedCustomer || '';
                    const category = this.currentCategory;
                    const date = this.selectedDate || new Date().toISOString().split('T')[0];
                    await Promise.all([
                        this.loadStockOverview(customer, category, date),
                        this.loadDailyStockClassification(customer, category, date),
                        this.loadStats(customer, category, date),
                        this.loadInventoryTableData() // Tabel tetap all customer
                    ]);
                } catch (error) {
                    console.error('Error during refresh:', error);
                }
            }

            async loadStockOverview(customer = '', category = null, date = null) {
                const container = document.getElementById('stockOverviewChart');
                const dataInfoContainer = document.getElementById('dataDateDisplay');

                try {
                    if (!date) {
                        date = this.selectedDate || new Date().toISOString().split('T')[0];
                    }

                    const params = new URLSearchParams();

                    params.append('date', date);
                    if (customer) params.append('customer', customer);
                    // Jika kategori 0 (Semua), jangan kirim param kategori
                    if (category && category !== 0) params.append('category', category);

                    const url = `api/public/dashboard/sto-chart-data?${params.toString()}`;
                    console.log("Loading stock overview from URL:", url);

                    const response = await fetch(url);
                    const data = await response.json();
                    console.log("Received stock data:", data);

                    // Update date display with better styling
                    if (dataInfoContainer) {
                        // Check if we have meta data with date information
                        if (data.meta && data.meta.formatted_date) {
                            if (data.meta.is_current) {
                                dataInfoContainer.className = "badge bg-success fs-6 ms-2";
                                dataInfoContainer.innerHTML = `
                                    <i class="bi bi-check-circle"></i>
                                    Current: ${data.meta.formatted_date}
                                `;
                            } else {
                                dataInfoContainer.className = "badge bg-warning text-dark fs-6 ms-2";
                                dataInfoContainer.innerHTML = `
                                    <i class="bi bi-clock-history"></i>
                                    Historical: ${data.meta.formatted_date}
                                `;
                            }
                        }
                        // Fallback to legacy format
                        else if (data.date_used) {
                            const today = new Date().toISOString().split('T')[0];
                            const isToday = data.date_used === today;

                            if (data.is_latest_data || !isToday) {
                                dataInfoContainer.className = "badge bg-warning text-dark fs-6 ms-2";
                                dataInfoContainer.innerHTML = `
                                    <i class="bi bi-clock-history"></i>
                                    Historical: ${data.date_used}
                                `;
                            } else {
                                dataInfoContainer.className = "badge bg-success fs-6 ms-2";
                                dataInfoContainer.innerHTML = `
                                    <i class="bi bi-check-circle"></i>
                                    Current: ${data.date_used}
                                `;
                            }
                        } else {
                            // No date info available
                            dataInfoContainer.className = "badge bg-secondary fs-6 ms-2";
                            dataInfoContainer.innerHTML = `
                                <i class="bi bi-calendar3"></i>
                                No date info
                            `;
                        }
                    }

                    if (this.stockChart) {
                        this.stockChart.destroy();
                    }

                    // Check if data is empty or no series data
                    if (!data.series || data.series.length === 0 ||
                        (data.series.length > 0 && data.series.every(series => !series.data || series.data.length ===
                            0))) {
                        const filterInfo = this.getFilterInfo(date, customer, category);
                        this.showNoData(container, 'Data yang Anda cari tidak ada', filterInfo);
                        return;
                    }

                    this.renderStockChart(container, data);
                } catch (error) {
                    console.error('Error loading stock overview:', error);

                    // Even on error, try to update the date display
                    if (dataInfoContainer) {
                        dataInfoContainer.className = "badge bg-danger fs-6 ms-2";
                        dataInfoContainer.innerHTML = `
                            <i class="bi bi-exclamation-triangle"></i>
                            Error loading data
                        `;
                    }

                    this.showError('Failed to load stock overview');
                    this.showNoData(container, 'Gagal memuat data', 'Terjadi kesalahan saat mengambil data: ' + error
                        .message);
                }
            }

            async loadDailyStockClassification(customer = '', category = null, date = null) {
                if (this._loadingDailyChart) return;
                this._loadingDailyChart = true;
                try {
                    const container = document.getElementById('dailyStockChart');
                    const dataInfoContainer = document.getElementById('dataDateDisplay');

                    if (!date) {
                        date = this.selectedDate || new Date().toISOString().split('T')[0];
                    }

                    const params = new URLSearchParams();

                    params.append('date', date);
                    if (customer) params.append('customer', customer);
                    if (category && category !== 0) params.append('category', category);

                    const url = `api/public/dashboard/daily-stock-classification?${params.toString()}`;

                    const response = await fetch(url);
                    const data = await response.json();

                    if (this.dailyChart) {
                        this.dailyChart.destroy();
                        this.dailyChart = null;
                    }

                    // Check if data is empty or no series data
                    if (!data.series || data.series.length === 0 ||
                        (data.series.length > 0 && data.series[0].data && data.series[0].data.length === 0) ||
                        (data.series.length > 0 && data.series.every(series => !series.data || series.data.length ===
                            0))) {
                        const filterInfo = this.getFilterInfo(date, customer, category);
                        this.showNoData(container, 'Data yang Anda cari tidak ada', filterInfo);
                        return;
                    }

                    // Only update date display if it hasn't been set by loadStockOverview yet
                    if (dataInfoContainer && (!dataInfoContainer.innerHTML || dataInfoContainer.innerHTML.includes(
                            'Loading'))) {
                        // Update date display with better styling - same logic as in loadStockOverview
                        if (data.meta && data.meta.formatted_date) {
                            if (data.meta.is_current) {
                                dataInfoContainer.className = "badge bg-success fs-6 ms-2";
                                dataInfoContainer.innerHTML = `
                                    <i class="bi bi-check-circle"></i>
                                    Current: ${data.meta.formatted_date}
                                `;
                            } else {
                                dataInfoContainer.className = "badge bg-warning text-dark fs-6 ms-2";
                                dataInfoContainer.innerHTML = `
                                    <i class="bi bi-clock-history"></i>
                                    Historical: ${data.meta.formatted_date}
                                `;
                            }
                        } else if (data.last_update) {
                            dataInfoContainer.className = "badge bg-secondary fs-6 ms-2";
                            dataInfoContainer.innerHTML = `
                                <i class="bi bi-calendar3"></i>
                                ${data.last_update}
                            `;
                        }
                    }

                    // Tambahkan pemetaan inv_id untuk tooltip
                    let invIdMap = {};
                    try {
                        const tableParams = new URLSearchParams();
                        tableParams.append('date', date);
                        if (customer) tableParams.append('customer', customer);
                        if (category && category !== 0) tableParams.append('category', category);
                        const tableRes = await fetch(
                            `api/public/dashboard/inventory-table-data?${tableParams.toString()}`);
                        const tableJson = await tableRes.json();
                        const tableData = Array.isArray(tableJson.data) ? tableJson.data : [];
                        invIdMap = {};
                        tableData.forEach(row => {
                            // Key string asli
                            let keyStr = row.day;
                            if (!invIdMap[keyStr]) invIdMap[keyStr] = [];
                            invIdMap[keyStr].push(row.inv_id || '-');
                            // Key angka (tanpa trailing .0 jika bulat)
                            if (!isNaN(row.day) && row.day !== null) {
                                let keyNum = parseFloat(row.day);
                                if (!invIdMap[keyNum]) invIdMap[keyNum] = [];
                                invIdMap[keyNum].push(row.inv_id || '-');
                            }
                        });
                    } catch (e) {
                        invIdMap = {};
                    }
                    data._invIdMap = invIdMap;

                    this.renderDailyChart(container, data);
                } finally {
                    this._loadingDailyChart = false;
                }
            }

            async loadInventoryTableData() {
                try {
                    // Gunakan customer yang dipilih user (bukan selalu all customer)
                    const customer = this.selectedCustomer || '';
                    const category = this.currentCategory;
                    const date = this.selectedDate || new Date().toISOString().split('T')[0];

                    const params = new URLSearchParams();

                    params.append('date', date);
                    if (customer) params.append('customer', customer);
                    if (category && category !== 0) params.append('category', category);

                    const url = `api/public/dashboard/inventory-table-data?${params.toString()}`;
                    console.log("Loading inventory data from URL:", url);

                    const response = await fetch(url);

                    if (!response.ok) {
                        throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                    }

                    const responseData = await response.json();
                    console.log("Received inventory data:", responseData);

                    // Check if responseData contains a 'data' property that is an array
                    if (responseData && Array.isArray(responseData.data)) {
                        this.tableData = responseData.data;
                    }
                    // If responseData itself is an array (backward compatibility)
                    else if (Array.isArray(responseData)) {
                        this.tableData = responseData;
                    }
                    // Initialize as empty array if neither condition is met
                    else {
                        console.error("Unexpected response format:", responseData);
                        this.tableData = [];
                    }

                    this.currentPage = 1;

                    // Render the first page
                    this.renderTablePage();

                    // Update table title with current category and customer info
                    const categoryName = this.getCategoryNameById(category);
                    const customerInfo = customer ? ` - ${customer}` : '';

                    // Add date information to the title
                    let tableTitle = `Inventory Detail - ${categoryName || 'All Categories'}${customerInfo}`;

                    // Show actual data date in the title
                    if (responseData.meta && responseData.meta.tanggal_data) {
                        tableTitle += ` (${responseData.meta.tanggal_data})`;
                    }

                    // Show fallback notification if requested date != actual data date
                    if (
                        responseData.meta &&
                        responseData.meta.tanggal_diminta &&
                        responseData.meta.tanggal_data &&
                        responseData.meta.tanggal_diminta !== responseData.meta.tanggal_data
                    ) {
                        setTimeout(() => {
                            const notification = document.createElement('div');
                            notification.className = 'alert alert-info mt-1 mb-1 py-2';
                            notification.style.fontSize = '0.85rem';
                            notification.innerHTML =
                                `<i class="bi bi-info-circle-fill me-1"></i> Data untuk tanggal ${responseData.meta.tanggal_diminta} tidak tersedia. Menampilkan data dari tanggal ${responseData.meta.tanggal_data}.`;

                            const tableTitleElem = document.getElementById('tableTitle');
                            if (tableTitleElem && tableTitleElem.parentNode) {
                                // Remove any existing notification first
                                const existingNotification = tableTitleElem.parentNode.querySelector('.alert');
                                if (existingNotification) {
                                    existingNotification.remove();
                                }

                                tableTitleElem.parentNode.insertBefore(notification, tableTitleElem
                                    .nextSibling);

                                // Auto-remove after 10 seconds
                                setTimeout(() => {
                                    notification.style.transition = 'opacity 1s ease-out';
                                    notification.style.opacity = 0;
                                    setTimeout(() => notification.remove(), 1000);
                                }, 10000);
                            }
                        }, 100);
                    }

                    document.getElementById('tableTitle').textContent = tableTitle;

                } catch (error) {
                    console.error('Error loading inventory table data:', error);
                    document.getElementById('inventoryTableBody').innerHTML =
                        `<tr><td colspan="8" class="text-center">Failed to load data: ${error.message}</td></tr>`;
                    document.getElementById('pageIndicator').textContent = 'Page 0 of 0';
                    this.tableData = [];
                }
            }


            renderStockChart(container, data) {
                const isStackedChart = data.series.length > 1;
                const isDarkMode = document.body.classList.contains('dark-mode');

                const options = {
                    series: data.series,
                    chart: {
                        type: 'bar',
                        height: 280,
                        stacked: isStackedChart,
                        toolbar: {
                            show: true
                        },
                        fontFamily: 'Inter, sans-serif',
                        background: isDarkMode ? '#2d3748' : '#ffffff'
                    },
                    theme: {
                        mode: isDarkMode ? 'dark' : 'light'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                            columnWidth: '70%',
                            distributed: !isStackedChart
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => val > 0 ? this.formatNumber(val) : '',
                        style: {
                            colors: [isDarkMode ? '#ffffff' : '#000000']
                        }
                    },
                    colors: isStackedChart ? ['#2E8B57', '#FF8C00', '#4682B4', '#9370DB', '#DC143C'] : ['#667eea',
                        '#764ba2', '#f093fb', '#f5576c', '#4facfe'
                    ],
                    xaxis: {
                        categories: data.categories,
                        labels: {
                            style: {
                                fontSize: '12px',
                                colors: isDarkMode ? '#ffffff' : '#374151'
                            },
                            rotate: -45
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: (val) => this.formatNumber(val),
                            style: {
                                colors: isDarkMode ? '#ffffff' : '#374151'
                            }
                        }
                    },
                    legend: {
                        show: isStackedChart,
                        position: 'top',
                        labels: {
                            colors: isDarkMode ? '#ffffff' : '#374151'
                        }
                    },
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                        y: {
                            formatter: (val) => `${this.formatNumber(val)} items`
                        }
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 240
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '85%'
                                }
                            }
                        }
                    }]
                };

                this.stockChart = new ApexCharts(container, options);
                this.stockChart.render();
            }

            renderDailyChart(container, data) {
                const isDarkMode = document.body.classList.contains('dark-mode');
                const invIdMap = data._invIdMap || {};
                const options = {
                    series: data.series,
                    chart: {
                        type: 'bar',
                        height: 280,
                        toolbar: {
                            show: true
                        },
                        fontFamily: 'Inter, sans-serif',
                        background: isDarkMode ? '#2d3748' : '#ffffff'
                    },
                    theme: {
                        mode: isDarkMode ? 'dark' : 'light'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            barHeight: '60%',
                            distributed: true
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => parseInt(val),
                        style: {
                            colors: [isDarkMode ? '#ffffff' : '#000000']
                        }
                    },
                    colors: data.series[0].data.map(d => {
                        const val = parseFloat(d.x);
                        return (val <= 1) ? '#ef4444' : (val > 2.5 || d.x === '3' || d.x === '>3') ?
                            '#1f77b4' : '#facc15';
                    }),
                    xaxis: {
                        title: {
                            text: 'Items',
                            style: {
                                color: isDarkMode ? '#ffffff' : '#374151'
                            }
                        },
                        labels: {
                            formatter: (val) => parseInt(val),
                            style: {
                                colors: isDarkMode ? '#ffffff' : '#374151'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Days',
                            style: {
                                color: isDarkMode ? '#ffffff' : '#374151'
                            }
                        },
                        labels: {
                            style: {
                                colors: isDarkMode ? '#ffffff' : '#374151'
                            }
                        }
                    },
                    legend: {
                        show: false
                    },
                    tooltip: {
                        theme: isDarkMode ? 'dark' : 'light',
                        custom: function({
                            series,
                            seriesIndex,
                            dataPointIndex,
                            w
                        }) {
                            const point = w.config.series[seriesIndex].data[dataPointIndex];
                            // --- Ambil inv_id dari meta jika ada, fallback ke invIdMap ---
                            let invIds = [];
                            if (point.meta && point.meta !== '-' && typeof point.meta === 'string') {
                                invIds = point.meta.split(',').map(s => s.trim()).filter(Boolean);
                            }
                            if ((!invIds || invIds.length === 0) && invIdMap) {
                                let dayKeyStr = point.x;
                                let dayKeyNum = (!isNaN(dayKeyStr) && dayKeyStr !== null) ? parseFloat(
                                    dayKeyStr) : null;
                                invIds = invIdMap[dayKeyStr] || (dayKeyNum !== null ? invIdMap[dayKeyNum] : []);
                                if (!invIds) invIds = [];
                            }
                            // Batasi 10, tampilkan "+N lainnya" jika lebih
                            const maxShow = 10;
                            const shown = invIds.slice(0, maxShow);
                            const hiddenCount = invIds.length - maxShow;
                            let invIdHtml = '';
                            if (shown.length === 0) {
                                invIdHtml = '<li class="text-muted">Tidak ada data inv_id</li>';
                            } else {
                                invIdHtml = shown.map(id => `<li>${id}</li>`).join('');
                            }
                            let moreText = hiddenCount > 0 ? `<li><em>+${hiddenCount} lainnya...</em></li>` :
                                '';
                            return `
                    <div style="
                        background: white;
                        padding: 10px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        border-left: 4px solid #007bff;
                        min-width: 220px;
                        max-width: 320px;
                        font-family: 'Segoe UI';
                    ">
                        <strong>Stock Range: ${point.x} Hari</strong><br/>
                        Jumlah Item: ${point.y}<br/>
                        <strong>Inv ID(s):</strong>
                        <ul style="padding-left: 16px; margin: 6px 0 4px 0; font-size: 13px; max-height: 110px; overflow-y: auto;">
                            ${invIdHtml}
                            ${moreText}
                        </ul>
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #eee; font-size: 11px; color: #666; text-align: center;">
                            <i class="bi bi-hand-index"></i> Klik bar chart untuk cari semua Inv ID ini di halaman detail
                        </div>
                    </div>
                `;
                        }
                    },
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 240
                            },
                            plotOptions: {
                                bar: {
                                    barHeight: '70%'
                                }
                            }
                        }
                    }]
                };

                this.dailyChart = new ApexCharts(container, options);
                this.dailyChart.render();
            }

            showNoData(container, message, filterInfo = '') {
                container.innerHTML = `
                <div class="no-data">
                    <i class="bi bi-inbox"></i>
                    <h5>${message}</h5>
                    <p>${filterInfo}</p>
                    <small class="text-muted">Silakan coba dengan filter yang berbeda atau periksa kembali nanti.</small>
                </div>
                `;
            }

            getFilterInfo(date, customer, category) {
                const filters = [];
                if (date) filters.push(`Tanggal: ${this.formatDate(date)}`);
                if (customer) filters.push(`Customer: ${customer}`);
                if (category) {
                    const categoryName = this.getCategoryNameById(category);
                    filters.push(`Kategori: ${categoryName}`);
                }

                return filters.length > 0 ?
                    `Filter aktif: ${filters.join(' | ')}` :
                    'Tidak ada data untuk ditampilkan';
            }

            getCategoryNameById(categoryId) {
                if (categoryId === "0") return this.allCategoriesOption.name;
                const category = this.categories.find(c => c.id === categoryId);
                return category ? category.name : categoryId;
            }

            formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }

            showError(message) {
                console.error(message);
            }

            formatNumber(num) {
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'K';
                }
                return num.toString();
            }

            // Add helper method to format numbers for table
            formatTableNumber(num) {
                return new Intl.NumberFormat('en-US').format(num);
            }

            // Add a new method to handle pausing all animations
            pause() {
                this.isPaused = true;
                document.getElementById('countdownTimer').style.opacity = '0.5';
            }

            // Add a new method to handle resuming all animations
            resume() {
                this.isPaused = false;
                document.getElementById('countdownTimer').style.opacity = '1';
            }

            // Set up pause events for both chart and table slides
            setupPauseEvents() {
                // Add mouse events to chart slide
                const chartSlide = document.getElementById('chartSlide');
                if (chartSlide) {
                    chartSlide.addEventListener('mouseenter', () => this.pause());
                    chartSlide.addEventListener('mouseleave', () => this.resume());
                }

                // Add mouse events to table slide
                const tableSlide = document.getElementById('tableSlide');
                if (tableSlide) {
                    tableSlide.addEventListener('mouseenter', () => this.pause());
                    tableSlide.addEventListener('mouseleave', () => this.resume());
                }

                // Individual chart cards for more precise control
                document.querySelectorAll('.chart-card').forEach(chart => {
                    chart.addEventListener('mouseenter', () => this.pause());
                    chart.addEventListener('mouseleave', () => this.resume());
                });
            }

            // Replace the old setupTablePauseEvents with our new unified system
            setupTablePauseEvents() {
                this.setupPauseEvents();
            }
        }

        // Initialize dashboard when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            const dataInfoContainer = document.querySelector("#data-info");
            new PublicDashboard();
        });
    </script>
</body>

</html>
