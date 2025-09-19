@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="pagetitle animate__animated animate__fadeInLeft">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard Inventory</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <!-- Add Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Select2 Professional Styling */
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 2px solid #e3f2fd;
            border-radius: 12px;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
            transition: all 0.3s ease;
        }

        .select2-container--default .select2-selection--single:hover {
            border-color: #2196f3;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            padding-left: 16px;
            font-weight: 500;
            color: #2c3e50;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            right: 12px;
        }

        .select2-dropdown {
            border-radius: 12px;
            border: 2px solid #e3f2fd;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
        }

        /* Fix Select2 Clear Button */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            cursor: pointer;
            float: right;
            font-weight: bold;
            margin-right: 10px;
            margin-top: 5px;
            position: relative;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #999;
        }


        /* Last Update Info - Professional */
        .last-update-info {
            position: fixed;
            top: 90px;
            right: 25px;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            padding: 12px 16px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            font-size: 13px;
            z-index: 1050;
            border: 2px solid rgba(0, 123, 255, 0.1);
            backdrop-filter: blur(10px);
            min-width: 200px;
            transition: all 0.3s ease;
        }

        .last-update-info.paused {
            background: linear-gradient(145deg, #fff3cd, #ffeaa7);
            border-color: rgba(255, 193, 7, 0.3);
            box-shadow: 0 8px 32px rgba(255, 193, 7, 0.2);
        }

        /* Countdown Professional Animation */
        .countdown-display {
            display: inline-block;
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            animation: pulse-countdown 2s infinite;
            transition: all 0.3s ease;
        }

        .countdown-display.paused {
            background: linear-gradient(145deg, #ffc107, #e0a800);
            animation: none;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
        }

        /* Chart hover overlay effect */
        .chart-paused-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(145deg, #fff3cd, #ffeaa7);
            color: #856404;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
            z-index: 1000;
            border: 2px solid #ffc107;
            display: none;
            animation: fadeInOut 0.5s ease-in-out;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse-countdown {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Category Indicator Professional */
        .category-indicator {
            background: linear-gradient(145deg, rgba(0, 123, 255, 0.1), rgba(0, 123, 255, 0.05));
            border-left: 5px solid #007bff;
            padding: 12px 16px;
            border-radius: 0 12px 12px 0;
            margin-bottom: 20px;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.1);
            font-weight: 500;
        }

        /* Professional Cards */
        .dashboard-card {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border: 2px solid rgba(0, 123, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(0, 123, 255, 0.2);
        }

        .dashboard-card .card-body {
            padding: 24px;
        }

        /* Filter Card Styling */
        .filter-card {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            border: 2px solid #e3f2fd;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 123, 255, 0.08);
        }

        .filter-card .card-body {
            padding: 20px 24px;
        }

        .filter-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Reset Button Professional Styling */
        #resetFilter {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            border: 2px solid #e3f2fd;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        #resetFilter:hover {
            background: linear-gradient(145deg, #007bff, #0056b3);
            color: white;
            border-color: #007bff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
        }

        #resetFilter:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
        }

        #resetFilter:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>

    <!-- Last Update Info - Fixed Position -->
    <div id="globalLastUpdate" class="last-update-info">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <i class="bi bi-clock text-primary"></i>
                <span id="updateText" class="fw-semibold">Loading...</span>
            </div>
            <span id="countdownTimer" class="countdown-display">10s</span>
        </div>
    </div>

    <section class="section dashboard">
        <div class="row">
            {{-- Professional Filter Customer Card --}}
            <div class="col-12 mb-2">
                <div class="card filter-card">
                    <div class="card-body">
                        <h5 class="filter-title">
                            {{-- <i class="bi bi-funnel-fill text-primary"></i> --}}
                            {{-- Customer Filter&nbsp;&nbsp; - --}}
                            <span class="badge bg-light text-primary px-2 py-1" id="data-info">
                                <i class="bi bi-calendar3"></i> Loading...
                            </span>
                        </h5>
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="custForecast" class="form-label fw-semibold text-muted">Select Customer</label>
                                <select name="customer" id="custForecast" class="form-control">
                                    <option value="" selected>All Customers</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->username }}"
                                            {{ request('customer') === $customer->username ? 'selected' : '' }}>
                                            {{ $customer->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="categorySelect" class="form-label fw-semibold text-muted">Select
                                    Category</label>
                                <select name="category" id="categorySelect" class="form-control">
                                    {{-- Populated by JS --}}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="dateFilter" class="form-label fw-semibold text-muted">Select Date</label>
                                <input type="date" id="dateFilter" class="form-control" value="">
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="resetFilter" class="btn btn-outline-secondary w-100"
                                    style="height: 42px; border-radius: 12px; font-weight: 500;">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Filter Card --}}

            {{-- Professional Actual Stock Card --}}
            <div class="col-lg-12 mb-2">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="card-title mb-2 text-primary fw-bold">
                                    <i class="bi bi-graph-up-arrow"></i> Actual Today Stock
                                </h5>
                                {{-- <small class="text-muted fw-semibold">{{ now()->format('F Y') }}</small> --}}
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                {{-- <div id="data-info" class="text-muted" style="font-size: 14px;"></div> --}}
                                <div id="chart-summary" class="text-end"></div>
                            </div>
                        </div>
                        <!-- Professional Chart Container -->
                        <div id="dailychart" style="min-height: 450px;" class="border-0 position-relative">
                            <div class="chart-paused-overlay" id="chartPausedOverlay">
                                <i class="bi bi-pause-circle"></i> Paused - Hover keluar untuk melanjutkan
                            </div>
                            <div class="loading-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                style="background: rgba(255,255,255,0.8); z-index: 10;">
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Loading chart data...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Styles for Professional Chart -->
                        <style>
                            .custom-tooltip {
                                background: rgba(255, 255, 255, 0.98) !important;
                                border: 1px solid #e9ecef !important;
                                border-radius: 8px !important;
                                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
                            }

                            #dailychart .apexcharts-toolbar {
                                background: #f8f9fa !important;
                                border-radius: 6px !important;
                                border: 1px solid #e9ecef !important;
                            }

                            #dailychart .apexcharts-menu {
                                background: white !important;
                                border: 1px solid #e9ecef !important;
                                border-radius: 6px !important;
                                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
                            }

                            #dailychart .apexcharts-legend {
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
                            }

                            .card.shadow-sm {
                                box-shadow: 0 0.125rem 0.375rem rgba(0, 0, 0, 0.08) !important;
                                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                            }

                            .card.shadow-sm:hover {
                                box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.12) !important;
                                transition: box-shadow 0.3s ease-in-out;
                            }
                        </style>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const customerSelect = document.getElementById("custForecast");
                                const categorySelect = document.getElementById("categorySelect");
                                const chartContainer = document.querySelector("#dailychart");
                                const dataInfoContainer = document.querySelector("#data-info");
                                const chartSummaryContainer = document.querySelector("#chart-summary");
                                const globalUpdateElement = document.getElementById("globalLastUpdate");
                                const updateTextElement = document.getElementById("updateText");
                                const countdownElement = document.getElementById("countdownTimer");
                                const loadingOverlay = document.querySelector(".loading-overlay");
                                const chartPausedOverlay = document.getElementById("chartPausedOverlay");
                                const dateFilter = document.getElementById("dateFilter");

                                let chart;
                                let categories = [];
                                let currentCategoryIndex = 0;
                                let rotationInterval;
                                let countdownInterval;
                                let countdown = 10;
                                let isPaused = false;

                                // Debug: Add console logging
                                console.log('Dashboard script initializing...');

                                // Initialize Select2 for customer dropdown with delay to ensure jQuery is loaded
                                setTimeout(() => {
                                    if (typeof $ !== 'undefined' && $.fn.select2) {
                                        $('#custForecast').select2({
                                            placeholder: "Select Customer",
                                            allowClear: false,
                                            width: '100%',
                                            theme: 'default',
                                            escapeMarkup: function(markup) {
                                                return markup;
                                            }
                                        });
                                        console.log('Select2 initialized successfully');
                                    } else {
                                        console.log('jQuery or Select2 not available, retrying...');
                                        setTimeout(() => {
                                            if (typeof $ !== 'undefined' && $.fn.select2) {
                                                $('#custForecast').select2({
                                                    placeholder: "Select Customer",
                                                    allowClear: false,
                                                    width: '100%',
                                                    theme: 'default',
                                                    escapeMarkup: function(markup) {
                                                        return markup;
                                                    }
                                                });
                                                console.log('Select2 initialized on retry');
                                            }
                                        }, 1000);
                                    }
                                }, 500);

                                // Load categories from server and populate select
                                function loadCategories() {
                                    fetch('dashboard/get-categories')
                                        .then(response => response.json())
                                        .then(data => {
                                            categories = data;
                                            // Populate category select
                                            if (categorySelect) {
                                                categorySelect.innerHTML = '';
                                                categories.forEach((cat, idx) => {
                                                    const option = document.createElement('option');
                                                    option.value = cat.id;
                                                    option.textContent = cat.name;
                                                    if (idx === 0) option.selected = true; // default to first (Finish Good)
                                                    categorySelect.appendChild(option);
                                                });
                                            }
                                            currentCategoryIndex = 0;
                                            startCategoryRotation();
                                        })
                                        .catch(error => {
                                            categories = [];
                                            startCategoryRotation();
                                        });
                                }

                                function updateCountdown() {
                                    if (!isPaused) {
                                        countdown--;
                                        if (countdownElement) {
                                            countdownElement.textContent = countdown + 's';
                                        }
                                        console.log('Countdown:', countdown);

                                        if (countdown <= 0) {
                                            console.log('Countdown finished, switching category');
                                            nextCategory();
                                            countdown = 10;
                                        }
                                    }
                                }

                                function nextCategory() {
                                    if (categories.length > 0) {
                                        currentCategoryIndex = (currentCategoryIndex + 1) % categories.length;
                                        console.log('Switching to category:', categories[currentCategoryIndex]?.name);

                                        // Update global variables immediately
                                        window.currentCategoryIndex = currentCategoryIndex;
                                        window.categories = categories;

                                        // Load both charts simultaneously
                                        loadStoChart();
                                        if (window.loadStockPerDayChart) {
                                            console.log('Triggering daily chart update from main chart');
                                            window.loadStockPerDayChart();
                                        }
                                    }
                                }

                                function startCategoryRotation() {
                                    console.log('Starting category rotation...');

                                    // Jika tidak ada kategori, jangan mulai rotasi
                                    if (!categories || categories.length === 0) {
                                        console.log('No categories available for rotation');
                                        return;
                                    }

                                    // Clear any existing intervals
                                    if (countdownInterval) {
                                        clearInterval(countdownInterval);
                                    }

                                    // Start countdown timer hanya jika ada lebih dari satu kategori
                                    if (categories.length > 1) {
                                        countdownInterval = setInterval(updateCountdown, 1000);
                                        console.log('Countdown interval started');
                                    }

                                    // Update global variables immediately
                                    window.categories = categories;
                                    window.currentCategoryIndex = currentCategoryIndex;

                                    // Load initial chart
                                    loadStoChart();
                                }

                                function pauseRotation() {
                                    isPaused = true;
                                    if (countdownElement) {
                                        countdownElement.textContent = 'Paused';
                                        countdownElement.classList.add('paused');
                                    }
                                    if (chartPausedOverlay) {
                                        chartPausedOverlay.style.display = 'block';
                                    }
                                    if (globalUpdateElement) {
                                        globalUpdateElement.classList.add('paused');
                                    }
                                    console.log('Rotation paused');
                                }

                                function resumeRotation() {
                                    isPaused = false;
                                    countdown = 10;
                                    if (countdownElement) {
                                        countdownElement.classList.remove('paused');
                                    }
                                    if (chartPausedOverlay) {
                                        chartPausedOverlay.style.display = 'none';
                                    }
                                    if (globalUpdateElement) {
                                        globalUpdateElement.classList.remove('paused');
                                    }
                                    console.log('Rotation resumed');
                                }

                                function formatNumber(num) {
                                    if (num >= 1000000) {
                                        return (num / 1000000).toFixed(1) + 'M';
                                    } else if (num >= 1000) {
                                        return (num / 1000).toFixed(1) + 'K';
                                    }
                                    return num.toString();
                                }

                                function hideLoadingOverlay() {
                                    if (loadingOverlay) {
                                        loadingOverlay.style.display = 'none';
                                    }
                                }

                                function showLoadingOverlay() {
                                    if (loadingOverlay) {
                                        loadingOverlay.style.display = 'flex';
                                    }
                                }

                                function loadStoChart() {
                                    console.log('Loading STO chart...');
                                    showLoadingOverlay();
                                    const customer = customerSelect ? customerSelect.value : '';
                                    const category = categories[currentCategoryIndex]?.id || '';
                                    const date = dateFilter && dateFilter.value ? dateFilter.value : '';
                                    let url = `dashboard/sto-chart-data?customer=${customer}&category=${category}`;
                                    if (date) url += `&date=${date}`;

                                    console.log('Fetching URL:', url);

                                    // Update last update info
                                    const currentCategory = categories[currentCategoryIndex]?.name || 'Tidak Ada Kategori';
                                    if (updateTextElement) {
                                        updateTextElement.innerHTML = `<strong>Current:</strong> ${currentCategory}`;
                                    }

                                    fetch(url)
                                        .then(response => {
                                            console.log('Response status:', response.status);
                                            if (!response.ok) {
                                                throw new Error(`HTTP error! status: ${response.status}`);
                                            }
                                            return response.json();
                                        })
                                        .then(result => {
                                            console.log('Chart data received:', result);
                                            hideLoadingOverlay();

                                            // Update date badge with data from chart
                                            // const currentDataDateElement = document.getElementById('currentDataDate');
                                            // if (currentDataDateElement && result.date_used) {
                                            //     currentDataDateElement.innerHTML =
                                            //         `<i class="bi bi-calendar3"></i> ${result.date_used}`;
                                            // }

                                            if (!chartContainer) {
                                                console.error('Chart container not found');
                                                return;
                                            }

                                            chartContainer.innerHTML = "";
                                            if (dataInfoContainer) dataInfoContainer.innerHTML = "";
                                            if (chartSummaryContainer) chartSummaryContainer.innerHTML = "";

                                            // Enhanced data validation
                                            if (!result) {
                                                console.log('No result data');
                                                chartContainer.innerHTML = `
                                                    <div class="text-center py-5">
                                                        <div class="mb-3">
                                                            <i class="bi bi-exclamation-triangle" style="font-size: 5rem; color: #ffc107;"></i>
                                                        </div>
                                                        <h6 class="text-warning">No Response Data</h6>
                                                        <p class="text-muted small">Category: ${currentCategory}</p>
                                                    </div>`;
                                                return;
                                            }

                                            // Check if we have valid data
                                            const hasValidData = result.series && result.series.length > 0 &&
                                                result.series.some(s => s.data && s.data.length > 0 && s.data.some(d => d > 0));

                                            if (!hasValidData) {
                                                console.log('No valid chart data');
                                                chartContainer.innerHTML = `
                                                    <div class="text-center py-5">
                                                        <div class="mb-3">
                                                            <i class="bi bi-graph-up" style="font-size: 5rem; color: #dee2e6;"></i>
                                                        </div>
                                                        <h6 class="text-muted">Data Stok Tidak Tersedia-Customer</h6>
                                                        <p class="text-muted small">Kategori: ${currentCategory}</p>
                                                    </div>`;
                                                return;
                                            }

                                            // Update data info with better styling
                                            if (dataInfoContainer) {
                                                if (result.is_latest_data) {
                                                    dataInfoContainer.innerHTML = `
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-clock-history"></i>
                                                        Historical: ${result.date_used}
                                                    </span>`;
                                                } else {
                                                    dataInfoContainer.innerHTML = `
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i>
                                                        Current: ${result.date_used}
                                                    </span>`;
                                                }
                                            }

                                            // Destroy previous chart
                                            if (chart) {
                                                chart.destroy();
                                            }

                                            // Use result.series directly
                                            let series = result.series || [];
                                            const isStackedChart = series.length > 1;

                                            console.log('Chart series:', series);

                                            // Calculate totals for summary
                                            if (isStackedChart && series.length > 1 && chartSummaryContainer) {
                                                const totals = series.reduce((acc, curr) => {
                                                    const seriesTotal = curr.data.reduce((sum, val) => sum + (val || 0), 0);
                                                    acc.push({
                                                        name: curr.name,
                                                        total: seriesTotal
                                                    });
                                                    return acc;
                                                }, []);

                                                const grandTotal = totals.reduce((sum, item) => sum + item.total, 0);

                                                chartSummaryContainer.innerHTML = `
                                                    <div class="text-end">
                                                        <small class="text-muted d-block">Total Stock</small>
                                                        <strong class="h5 text-primary">${formatNumber(grandTotal)}</strong>
                                                    </div>`;
                                            }

                                            // Professional color scheme
                                            const professionalColors = isStackedChart ? [
                                                '#2E8B57', // Sea Green - Finished Good
                                                '#DC143C', // Crimson - Raw Material
                                                '#9370DB', // Medium Purple - Child Part
                                                '#4682B4', // Steel Blue - Packaging
                                                '#FF8C00' // Dark Orange - WIP
                                            ] : ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd'];

                                            console.log('Creating chart with series:', series);

                                            chart = new ApexCharts(chartContainer, {
                                                series: series,
                                                chart: {
                                                    type: 'bar',
                                                    height: 420,
                                                    width: '100%',
                                                    stacked: isStackedChart,
                                                    background: '#ffffff',
                                                    events: {
                                                        mouseEnter: function() {
                                                            pauseRotation();
                                                            if (window.pauseDailyRotation) window
                                                                .pauseDailyRotation(); // Also pause daily chart
                                                        },
                                                        mouseLeave: function() {
                                                            resumeRotation();
                                                            if (window.resumeDailyRotation) window
                                                                .resumeDailyRotation(); // Also resume daily chart
                                                        }
                                                    },
                                                    toolbar: {
                                                        show: true,
                                                        offsetY: -10,
                                                        tools: {
                                                            download: true,
                                                            selection: false,
                                                            zoom: true,
                                                            zoomin: true,
                                                            zoomout: true,
                                                            pan: true,
                                                            reset: true
                                                        },
                                                        export: {
                                                            csv: {
                                                                filename: `Stock_Report_${new Date().toISOString().split('T')[0]}`
                                                            },
                                                            png: {
                                                                filename: `Stock_Chart_${new Date().toISOString().split('T')[0]}`
                                                            }
                                                        }
                                                    },
                                                    animations: {
                                                        enabled: true,
                                                        easing: 'easeinout',
                                                        speed: 800,
                                                        animateGradually: {
                                                            enabled: true,
                                                            delay: 150
                                                        },
                                                        dynamicAnimation: {
                                                            enabled: true,
                                                            speed: 350
                                                        }
                                                    },
                                                    redrawOnParentResize: true,
                                                    redrawOnWindowResize: true,
                                                    fontFamily: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        borderRadius: isStackedChart ? 2 : 6,
                                                        horizontal: false,
                                                        columnWidth: isStackedChart ? '75%' : '60%',
                                                        distributed: !isStackedChart,
                                                        borderRadiusApplication: 'end',
                                                        borderRadiusWhenStacked: 'last',
                                                        dataLabels: {
                                                            total: {
                                                                enabled: isStackedChart,
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontWeight: 600,
                                                                    color: '#373d3f'
                                                                },
                                                                formatter: function(val) {
                                                                    return formatNumber(val);
                                                                }
                                                            }
                                                        }
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: true,
                                                    style: {
                                                        fontSize: '11px',
                                                        fontWeight: '600',
                                                        colors: ['#ffffff']
                                                    },
                                                    formatter: function(val, opts) {
                                                        if (val <= 0) return '';
                                                        return isStackedChart && val < 100 ? '' : formatNumber(val);
                                                    },
                                                    dropShadow: {
                                                        enabled: true,
                                                        color: '#000',
                                                        top: 1,
                                                        left: 1,
                                                        blur: 1,
                                                        opacity: 0.45
                                                    }
                                                },
                                                colors: professionalColors,
                                                fill: {
                                                    type: 'gradient',
                                                    gradient: {
                                                        shade: 'light',
                                                        type: 'vertical',
                                                        shadeIntensity: 0.25,
                                                        gradientToColors: undefined,
                                                        inverseColors: false,
                                                        opacityFrom: 0.95,
                                                        opacityTo: 0.85,
                                                        stops: [0, 100]
                                                    }
                                                },
                                                stroke: {
                                                    show: true,
                                                    width: 1,
                                                    colors: ['rgba(255,255,255,0.3)']
                                                },
                                                xaxis: {
                                                    categories: result.categories || [],
                                                    labels: {
                                                        style: {
                                                            fontSize: '12px',
                                                            fontWeight: '500',
                                                            colors: '#6c757d'
                                                        },
                                                        rotate: -45,
                                                        maxHeight: 120
                                                    },
                                                    axisBorder: {
                                                        show: true,
                                                        color: '#e9ecef'
                                                    },
                                                    axisTicks: {
                                                        show: true,
                                                        color: '#e9ecef'
                                                    },
                                                    title: {
                                                        style: {
                                                            fontSize: '14px',
                                                            fontWeight: '600',
                                                            color: '#495057'
                                                        }
                                                    }
                                                },
                                                yaxis: {
                                                    title: {
                                                        style: {
                                                            fontSize: '14px',
                                                            fontWeight: '600',
                                                            color: '#495057'
                                                        }
                                                    },
                                                    labels: {
                                                        style: {
                                                            fontSize: '12px',
                                                            colors: '#6c757d'
                                                        },
                                                        formatter: function(val) {
                                                            return formatNumber(val);
                                                        }
                                                    },
                                                    axisBorder: {
                                                        show: true,
                                                        color: '#e9ecef'
                                                    }
                                                },
                                                legend: {
                                                    show: isStackedChart,
                                                    position: 'top',
                                                    horizontalAlign: 'center',
                                                    floating: false,
                                                    offsetY: -5,
                                                    offsetX: 0,
                                                    fontSize: '13px',
                                                    fontWeight: '500',
                                                    markers: {
                                                        width: 12,
                                                        height: 12,
                                                        radius: 3
                                                    },
                                                    itemMargin: {
                                                        horizontal: 15,
                                                        vertical: 5
                                                    }
                                                },
                                                tooltip: {
                                                    enabled: true,
                                                    shared: isStackedChart,
                                                    intersect: !isStackedChart,
                                                    style: {
                                                        fontSize: '13px'
                                                    },
                                                    y: {
                                                        formatter: function(val) {
                                                            return `<strong>${formatNumber(val)}</strong> items`;
                                                        }
                                                    }
                                                },
                                                grid: {
                                                    show: true,
                                                    borderColor: '#f1f3f4',
                                                    strokeDashArray: 3,
                                                    position: 'back',
                                                    xaxis: {
                                                        lines: {
                                                            show: false
                                                        }
                                                    },
                                                    yaxis: {
                                                        lines: {
                                                            show: true
                                                        }
                                                    },
                                                    padding: {
                                                        top: 0,
                                                        right: 20,
                                                        bottom: 0,
                                                        left: 20
                                                    }
                                                },
                                                responsive: [{
                                                    breakpoint: 1200,
                                                    options: {
                                                        chart: {
                                                            height: 380
                                                        },
                                                        plotOptions: {
                                                            bar: {
                                                                columnWidth: isStackedChart ? '80%' : '65%'
                                                            }
                                                        }
                                                    }
                                                }, {
                                                    breakpoint: 768,
                                                    options: {
                                                        chart: {
                                                            height: 350
                                                        },
                                                        plotOptions: {
                                                            bar: {
                                                                columnWidth: '85%'
                                                            }
                                                        },
                                                        legend: {
                                                            position: 'bottom',
                                                            offsetY: 10
                                                        },
                                                        xaxis: {
                                                            labels: {
                                                                rotate: -90,
                                                                maxHeight: 80
                                                            }
                                                        }
                                                    }
                                                }, {
                                                    breakpoint: 480,
                                                    options: {
                                                        chart: {
                                                            height: 300
                                                        },
                                                        dataLabels: {
                                                            enabled: false
                                                        },
                                                        plotOptions: {
                                                            bar: {
                                                                columnWidth: '90%'
                                                            }
                                                        }
                                                    }
                                                }]
                                            });

                                            console.log('Rendering chart...');
                                            chart.render().then(() => {
                                                console.log('Chart rendered successfully');
                                            }).catch(error => {
                                                console.error('Error rendering chart:', error);
                                            });
                                        })
                                        .catch(error => {
                                            console.error("Error loading chart:", error);
                                            hideLoadingOverlay();
                                            if (chartContainer) {
                                                chartContainer.innerHTML = `
                                                <div class="text-center py-5">
                                                    <div class="mb-3">
                                                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                                    </div>
                                                    <h6 class="text-danger">Chart Loading Error</h6>
                                                    <p class="text-muted small">Unable to load chart data. Please try again later.</p>
                                                    <p class="text-muted small">Error: ${error.message}</p>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                                                        <i class="bi bi-arrow-clockwise"></i> Reload Page
                                                    </button>
                                                </div>`;
                                            }
                                        });
                                }

                                // Event listeners with better error handling and synchronization
                                if (customerSelect) {
                                    customerSelect.addEventListener('change', function() {
                                        currentCategoryIndex = 0;
                                        countdown = 10;
                                        // Update global variables
                                        window.currentCategoryIndex = 0;
                                        window.categories = categories;

                                        loadStoChart();
                                        // Also reset daily chart
                                        if (window.loadStockPerDayChart) {
                                            window.loadStockPerDayChart();
                                        }
                                    });
                                }

                                // Category select manual change
                                if (categorySelect) {
                                    categorySelect.addEventListener('change', function() {
                                        // Find index of selected category
                                        const selectedCatId = categorySelect.value;
                                        const idx = categories.findIndex(cat => String(cat.id) === String(selectedCatId));
                                        if (idx !== -1) {
                                            currentCategoryIndex = idx;
                                            countdown = 10;
                                            window.currentCategoryIndex = currentCategoryIndex;
                                            window.categories = categories;
                                            loadStoChart();
                                            if (window.loadStockPerDayChart) window.loadStockPerDayChart();
                                        }
                                    });
                                }

                                // Date filter change
                                if (dateFilter) {
                                    dateFilter.addEventListener('change', function() {
                                        countdown = 10;
                                        loadStoChart();
                                        if (window.loadStockPerDayChart) window.loadStockPerDayChart();
                                    });
                                }

                                // Reset filter button event listener
                                const resetFilterButton = document.getElementById('resetFilter');
                                if (resetFilterButton) {
                                    resetFilterButton.addEventListener('click', function() {
                                        // Reset Select2 to "All Customers"
                                        if (typeof $ !== 'undefined' && $('#custForecast').hasClass(
                                                'select2-hidden-accessible')) {
                                            $('#custForecast').val('').trigger('change');
                                        } else if (customerSelect) {
                                            customerSelect.value = '';
                                            customerSelect.dispatchEvent(new Event('change'));
                                        }
                                        // Reset category to first (Finish Good)
                                        if (categorySelect && categorySelect.options.length > 0) {
                                            categorySelect.selectedIndex = 0;
                                            categorySelect.dispatchEvent(new Event('change'));
                                        }
                                        // Reset date filter
                                        if (dateFilter) {
                                            dateFilter.value = '';
                                        }
                                        currentCategoryIndex = 0;
                                        countdown = 10;
                                        window.currentCategoryIndex = 0;
                                        window.categories = categories;

                                        // Show loading state on button
                                        const originalText = resetFilterButton.innerHTML;
                                        resetFilterButton.innerHTML = '<i class="bi bi-arrow-repeat"></i> Resetting...';
                                        resetFilterButton.disabled = true;

                                        // Reload both charts
                                        loadStoChart();
                                        if (window.loadStockPerDayChart) {
                                            window.loadStockPerDayChart();
                                        }

                                        // Reset button state after delay
                                        setTimeout(() => {
                                            resetFilterButton.innerHTML = originalText;
                                            resetFilterButton.disabled = false;
                                        }, 1500);

                                        console.log('Filter reset to All Customers');
                                    });
                                }

                                // Add hover events for chart container
                                if (chartContainer) {
                                    chartContainer.addEventListener('mouseenter', function() {
                                        pauseRotation();
                                        if (window.pauseDailyRotation) window.pauseDailyRotation();
                                    });

                                    chartContainer.addEventListener('mouseleave', function() {
                                        resumeRotation();
                                        if (window.resumeDailyRotation) window.resumeDailyRotation();
                                    });
                                }

                                // Also add jQuery event listener as fallback
                                $(document).on('change', '#custForecast', function() {
                                    console.log('Customer changed via jQuery:', this.value);
                                    currentCategoryIndex = 0;
                                    countdown = 10;
                                    window.currentCategoryIndex = 0;
                                    window.categories = categories;

                                    loadStoChart();
                                    if (window.loadStockPerDayChart) {
                                        window.loadStockPerDayChart();
                                    }
                                });

                                // Also add jQuery event listener as fallback for category
                                $(document).on('change', '#categorySelect', function() {
                                    const selectedCatId = $(this).val();
                                    const idx = categories.findIndex(cat => String(cat.id) === String(selectedCatId));
                                    if (idx !== -1) {
                                        currentCategoryIndex = idx;
                                        countdown = 10;
                                        window.currentCategoryIndex = currentCategoryIndex;
                                        window.categories = categories;
                                        loadStoChart();
                                        if (window.loadStockPerDayChart) window.loadStockPerDayChart();
                                    }
                                });

                                // jQuery fallback for date filter
                                $(document).on('change', '#dateFilter', function() {
                                    countdown = 10;
                                    loadStoChart();
                                    if (window.loadStockPerDayChart) window.loadStockPerDayChart();
                                });

                                // Expose functions to window for global access
                                window.pauseRotation = pauseRotation;
                                window.resumeRotation = resumeRotation;
                                window.categories = categories;
                                window.currentCategoryIndex = currentCategoryIndex;

                                // Update window variables when they change
                                function updateGlobalVariables() {
                                    window.currentCategoryIndex = currentCategoryIndex;
                                    window.categories = categories;
                                }

                                window.resetMainChart = function() {
                                    currentCategoryIndex = 0;
                                    countdown = 10;
                                    updateGlobalVariables();
                                    loadStoChart();
                                    if (window.loadStockPerDayChart) {
                                        window.loadStockPerDayChart();
                                    }
                                };

                                // Initialize after short delay
                                console.log('Initializing dashboard...');
                                setTimeout(() => {
                                    loadCategories();
                                }, 1000);
                            });
                        </script>
                    </div>
                </div>
            </div>


            {{-- Professional Daily Stock Card --}}
            <div class="col-lg-12">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title text-primary fw-bold">
                                <i class="bi bi-calendar-week"></i> Day's Stock
                            </h5>
                        </div>

                        <!-- Current Category Indicator -->
                        <div id="currentCategoryIndicator" class="category-indicator">
                            <i class="bi bi-tag-fill text-primary"></i>
                            <strong>Current Category:</strong>
                            <span id="currentCategoryText" class="text-primary">Loading...</span>
                        </div>

                        <!-- Bar Chart -->
                        <div id="stockPerDayChart" style="height: 500px;" class="position-relative">
                            <div class="chart-paused-overlay" id="dailyChartPausedOverlay">
                                <i class="bi bi-pause-circle"></i> Paused - Hover keluar untuk melanjutkan
                            </div>
                            <div class="daily-loading-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                style="background: rgba(255,255,255,0.8); z-index: 10; display: none;">
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Loading daily stock data...</p>
                                </div>
                            </div>
                        </div>
                        <style>
                            #stockPerDayChart .apexcharts-bar-area {
                                cursor: pointer !important;
                            }

                            #stockPerDayChart .apexcharts-bar-area:hover {
                                opacity: 0.8;
                            }
                        </style>
                        <div class="text-center mt-2">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Klik pada bar chart untuk mencari semua Inv ID dalam range tersebut di halaman Daily Stock.
                                {{-- <strong>Hover untuk pause auto-switch kategori.</strong> --}}
                            </small>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const chartContainer = document.querySelector("#stockPerDayChart");
                                const customerSelect = document.getElementById("custForecast");
                                const currentCategoryText = document.getElementById("currentCategoryText");
                                const dailyLoadingOverlay = document.querySelector(".daily-loading-overlay");
                                const dailyChartPausedOverlay = document.getElementById("dailyChartPausedOverlay");

                                let dailyCategories = [];
                                let dailyCurrentCategoryIndex = 0;
                                let dailyChart;

                                // Sync with main chart categories
                                function syncWithMainChart() {
                                    // Get categories from main chart if available
                                    if (window.categories && window.categories.length > 0) {
                                        dailyCategories = [...window.categories];
                                        dailyCurrentCategoryIndex = window.currentCategoryIndex || 0;
                                    } else {
                                        loadDailyCategories();
                                    }
                                }

                                // Load categories for daily chart
                                function loadDailyCategories() {
                                    fetch('dashboard/get-categories')
                                        .then(response => response.json())
                                        .then(data => {
                                            // Hanya gunakan kategori spesifik untuk daily chart juga
                                            dailyCategories = data;

                                            // Expose to window for synchronization
                                            window.dailyCategories = dailyCategories;
                                            loadStockPerDayChart();
                                        })
                                        .catch(error => {
                                            console.error('Error loading daily categories:', error);
                                            dailyCategories = []; // Kosongkan jika error untuk daily chart juga
                                            loadStockPerDayChart();
                                        });
                                }

                                function pauseDailyRotation() {
                                    // Daily chart now follows main chart, so just show overlay
                                    if (dailyChartPausedOverlay) {
                                        dailyChartPausedOverlay.style.display = 'block';
                                    }
                                }

                                function resumeDailyRotation() {
                                    // Daily chart now follows main chart, so just hide overlay
                                    if (dailyChartPausedOverlay) {
                                        dailyChartPausedOverlay.style.display = 'none';
                                    }
                                }

                                // Expose functions to window for global access
                                window.pauseDailyRotation = pauseDailyRotation;
                                window.resumeDailyRotation = resumeDailyRotation;

                                function showDailyLoading() {
                                    if (dailyLoadingOverlay) {
                                        dailyLoadingOverlay.style.display = 'flex';
                                    }
                                }

                                function hideDailyLoading() {
                                    if (dailyLoadingOverlay) {
                                        dailyLoadingOverlay.style.display = 'none';
                                    }
                                }

                                function loadStockPerDayChart() {
                                    console.log('Loading Daily Stock chart...');
                                    showDailyLoading();

                                    // Always use the current category index from main chart
                                    const mainChartIndex = window.currentCategoryIndex || 0;
                                    const mainChartCategories = window.categories || dailyCategories;
                                    const customer = customerSelect?.value;
                                    const category = mainChartCategories[mainChartIndex]?.id || '';
                                    const categoryName = mainChartCategories[mainChartIndex]?.name || 'Tidak Ada Kategori';

                                    // Ambil nilai date dari filter
                                    const dateFilter = document.getElementById("dateFilter");
                                    const date = dateFilter && dateFilter.value ? dateFilter.value : '';

                                    // Update category indicator
                                    if (currentCategoryText) {
                                        currentCategoryText.textContent = categoryName;
                                    }

                                    // Kirim parameter date jika ada
                                    let url = `dashboard/daily-stock-classification?customer=${customer}&category=${category}`;
                                    if (date) url += `&date=${date}`;

                                    fetch(url)
                                        .then(res => res.json())
                                        .then(result => {
                                            hideDailyLoading();
                                            chartContainer.innerHTML = ''; // clear chart

                                            // Enhanced check for empty/invalid data
                                            if (
                                                !result.series ||
                                                result.series.length === 0 ||
                                                !result.series[0] ||
                                                !Array.isArray(result.series[0].data) ||
                                                result.series[0].data.length === 0 ||
                                                result.series[0].data.every(item => !item || item.y === 0 || isNaN(item.y))
                                            ) {
                                                chartContainer.innerHTML = `
                                                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 400px;">
                                                    <div class="text-center">
                                                        <i class="bi bi-database-exclamation text-muted" style="font-size: 4rem;"></i>
                                                        <h5 class="mt-3 text-muted">No Daily Stock Data Available</h5>
                                                        <p class="text-muted">Category: ${categoryName}</p>
                                                        <div class="badge bg-light text-muted mt-2">
                                                            <i class="bi bi-arrow-clockwise"></i> Auto-switching categories every 10s
                                                        </div>
                                                    </div>
                                                </div>`;
                                                return;
                                            }

                                            // Ambil data dan label kategori dari API (x dan y)
                                            const chartData = result.series[0].data || [];
                                            const xCategories = chartData.map(d => d.x);
                                            const yData = chartData.map(d => d.y);

                                            const chart = new ApexCharts(chartContainer, {
                                                chart: {
                                                    type: 'bar',
                                                    height: 500,
                                                    events: {
                                                        mouseEnter: function() {
                                                            pauseDailyRotation();
                                                            if (window.pauseRotation) window.pauseRotation();
                                                        },
                                                        mouseLeave: function() {
                                                            resumeDailyRotation();
                                                            if (window.resumeRotation) window.resumeRotation();
                                                        },
                                                        dataPointSelection: function(event, chartContext, config) {
                                                            const dataPointIndex = config.dataPointIndex;
                                                            const clickedData = chartData[dataPointIndex];

                                                            // Ambil details kategori yang diklik
                                                            let invIds = [];
                                                            let areas = [];
                                                            let plants = [];
                                                            if (clickedData.details && Array.isArray(clickedData
                                                                    .details)) {
                                                                invIds = [...new Set(clickedData.details.map(d => d
                                                                    .inv_id).filter(Boolean))];
                                                                areas = [...new Set(clickedData.details.map(d => d.area)
                                                                    .filter(Boolean))];
                                                                plants = [...new Set(clickedData.details.map(d => d
                                                                    .plant).filter(Boolean))];
                                                            }

                                                            // Parse date for URL parameter
                                                            let parsedDate = '';
                                                            const rawDate = result.last_update;
                                                            if (rawDate) {
                                                                const match = rawDate.match(
                                                                    /(\d{1,2}) (\w{3}), (\d{4})/
                                                                );
                                                                if (match) {
                                                                    const day = match[1].padStart(2, '0');
                                                                    const monthMap = {
                                                                        'Jan': '01',
                                                                        'Feb': '02',
                                                                        'Mar': '03',
                                                                        'Apr': '04',
                                                                        'May': '05',
                                                                        'Jun': '06',
                                                                        'Jul': '07',
                                                                        'Aug': '08',
                                                                        'Sep': '09',
                                                                        'Oct': '10',
                                                                        'Nov': '11',
                                                                        'Dec': '12'
                                                                    };
                                                                    const month = monthMap[match[2]];
                                                                    const year = match[3];
                                                                    parsedDate = `${year}-${month}-${day}`;
                                                                }
                                                            }
                                                            if (!parsedDate) {
                                                                if (result.meta && result.meta.actual_date) {
                                                                    parsedDate = result.meta.actual_date;
                                                                } else {
                                                                    const today = new Date();
                                                                    parsedDate = today.toISOString().slice(0, 10);
                                                                }
                                                            }

                                                            // Build URL dengan parameter area, plant, inv_id terpisah
                                                            let url = '/daily-stock?from_dashboard=1';
                                                            if (parsedDate) {
                                                                url += `&date=${encodeURIComponent(parsedDate)}`;
                                                            }
                                                            if (invIds.length > 0) {
                                                                url +=
                                                                    `&inv_id=${encodeURIComponent(invIds.join(','))}`;
                                                            }
                                                            if (areas.length > 0) {
                                                                url += `&area=${encodeURIComponent(areas.join(','))}`;
                                                            }
                                                            if (plants.length > 0) {
                                                                url += `&plant=${encodeURIComponent(plants.join(','))}`;
                                                            }
                                                            // Tambahkan stock_category sesuai kategori yang diklik
                                                            if (clickedData.x) {
                                                                url +=
                                                                    `&stock_category=${encodeURIComponent(clickedData.x)}`;
                                                            }
                                                            window.open(url, '_blank');
                                                        }
                                                    },
                                                    toolbar: {
                                                        show: true
                                                    }
                                                },
                                                legend: {
                                                    show: false
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        horizontal: true,
                                                        barHeight: '60%',
                                                        distributed: true
                                                    }
                                                },
                                                states: {
                                                    hover: {
                                                        filter: {
                                                            type: 'lighten',
                                                            value: 0.15
                                                        }
                                                    },
                                                    active: {
                                                        allowMultipleDataPointsSelection: false,
                                                        filter: {
                                                            type: 'darken',
                                                            value: 0.35
                                                        }
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: true,
                                                    formatter: val => parseInt(val)
                                                },
                                                stroke: {
                                                    show: true,
                                                    width: 1,
                                                    colors: ['transparent']
                                                },
                                                series: [{
                                                    name: result.series[0].name,
                                                    data: yData
                                                }],
                                                xaxis: {
                                                    categories: xCategories,
                                                    title: {
                                                        text: 'Item',
                                                        style: {
                                                            fontWeight: 600
                                                        }
                                                    },
                                                    labels: {
                                                        style: {
                                                            fontSize: '10px'
                                                        },
                                                        formatter: val => val
                                                    }
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Day',
                                                        style: {
                                                            fontWeight: 600
                                                        }
                                                    },
                                                    labels: {
                                                        style: {
                                                            fontSize: '10px'
                                                        }
                                                    },
                                                    categories: xCategories
                                                },
                                                tooltip: {
                                                    shared: false,
                                                    custom: function({
                                                        series,
                                                        seriesIndex,
                                                        dataPointIndex,
                                                        w
                                                    }) {
                                                        const point = chartData[dataPointIndex];
                                                        const metaArray = point.meta.split(',').map(s => s.trim());
                                                        const maxShow = 10;
                                                        const shownItems = metaArray.slice(0, maxShow);
                                                        const hiddenCount = metaArray.length - maxShow;
                                                        const metaList = shownItems.map(item => `<li>${item}</li>`)
                                                            .join('');
                                                        const moreText = hiddenCount > 0 ?
                                                            `<li><em>+${hiddenCount} lainnya...</em></li>` : '';
                                                        return `
                                                <div style="
                                                    background: white;
                                                    padding: 10px;
                                                    border-radius: 8px;
                                                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                                                    border-left: 4px solid #007bff;
                                                    min-width: 240px;
                                                    max-width: 300px;
                                                    font-family: 'Segoe UI';
                                                ">
                                                    <strong>Stock Range: ${point.x} Hari</strong><br/>
                                                    Jumlah Item: ${point.y}<br/>
                                                    <strong>Inv ID(s):</strong>
                                                    <ul style="padding-left: 16px; margin: 6px 0 4px 0; font-size: 13px;">
                                                        ${metaList}
                                                        ${moreText}
                                                    </ul>
                                                    <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #eee; font-size: 11px; color: #666; text-align: center;">
                                                        <i class="bi bi-hand-index"></i> Klik untuk cari semua Inv ID ini di Daily Stock
                                                    </div>
                                                </div>`;
                                                    }
                                                },
                                                colors: xCategories.map(val => {
                                                    const v = parseFloat(val);
                                                    return (v <= 1) ? '#ef4444' : (v > 2.5 || val === '3' || val ===
                                                        '>3') ? '#1f77b4' : '#facc15';
                                                })
                                            });

                                            chart.render();
                                            dailyChart = chart; // Store reference for potential cleanup
                                        })
                                        .catch(error => {
                                            console.error("Error loading chart:", error);
                                            chartContainer.innerHTML = `
                                    <p class='text-danger text-center mt-3'>
                                        Gagal memuat chart.
                                    </p>`;
                                        });
                                }

                                // Expose the loadStockPerDayChart function to window for synchronization
                                window.loadStockPerDayChart = loadStockPerDayChart;

                                // Force daily chart to sync with main chart on customer change
                                $('#custForecast').on('change', function() {
                                    console.log('Customer changed, resetting daily chart');
                                    setTimeout(() => {
                                        loadStockPerDayChart();
                                    }, 500); // Small delay to ensure main chart updates first
                                });

                                // Add hover events for daily chart container
                                if (chartContainer) {
                                    chartContainer.addEventListener('mouseenter', function() {
                                        pauseDailyRotation();
                                        if (window.pauseRotation) window.pauseRotation();
                                    });

                                    chartContainer.addEventListener('mouseleave', function() {
                                        resumeDailyRotation();
                                        if (window.resumeRotation) window.resumeRotation();
                                    });
                                }

                                // Initialize daily chart
                                setTimeout(() => {
                                    syncWithMainChart();
                                    // Wait for main chart to be ready
                                    const checkMainChart = setInterval(() => {
                                        if (window.categories && window.categories.length > 0) {
                                            console.log('Main chart categories ready, loading daily chart');
                                            dailyCategories = [...window.categories];
                                            clearInterval(checkMainChart);
                                            loadStockPerDayChart();
                                        }
                                    }, 200);
                                }, 1500); // Wait for main chart to initialize
                            });
                        </script>
                        <!-- End Bar Chart -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Ensure Select2 is initialized after everything is loaded
        $(document).ready(function() {
            // Force reinitialize Select2 without allowClear
            if ($('#custForecast').hasClass('select2-hidden-accessible')) {
                $('#custForecast').select2('destroy');
            }

            $('#custForecast').select2({
                placeholder: "Select Customer",
                allowClear: false,
                width: '100%',
                theme: 'default',
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            // Populate category select with AJAX
            $.get('dashboard/get-categories', function(data) {
                var $catSelect = $('#categorySelect');
                $catSelect.empty();
                $.each(data, function(idx, cat) {
                    $catSelect.append($('<option>', {
                        value: cat.id,
                        text: cat.name,
                        selected: idx === 0
                    }));
                });
            });

            // Reset Filter Button Event Handler
            $('#resetFilter').on('click', function() {
                console.log('Reset button clicked via jQuery');

                // Reset Select2 to "All Customers"
                $('#custForecast').val('').trigger('change');

                // Reset category to first (Finish Good)
                $('#categorySelect').prop('selectedIndex', 0).trigger('change');

                // Reset date filter
                $('#dateFilter').val('');

                // Reset global variables
                if (window.resetMainChart) {
                    window.resetMainChart();
                }

                // Visual feedback
                const $btn = $(this);
                const originalText = $btn.html();
                $btn.html('<i class="bi bi-arrow-repeat"></i> Resetting...').prop('disabled', true);

                setTimeout(() => {
                    $btn.html(originalText).prop('disabled', false);
                }, 1500);

                // Show success message
                if (typeof toastr !== 'undefined') {
                    toastr.success('Filter berhasil direset ke All Customers');
                }
            });
        }); // Global functions for chart interactions
        window.pauseAllRotations = function() {
            if (window.pauseRotation) window.pauseRotation();
            if (window.pauseDailyRotation) window.pauseDailyRotation();
        }

        window.resumeAllRotations = function() {
            if (window.resumeRotation) window.resumeRotation();
            if (window.resumeDailyRotation) window.resumeDailyRotation();
        }
    </script>
@endsection
