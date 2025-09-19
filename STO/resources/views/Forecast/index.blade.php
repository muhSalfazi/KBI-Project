@extends('layouts.app')

@section('title', 'Forecast Data')

@section('content')
    <div class="pagetitle animate__animated animate__fadeInLeft">
        <h1>Forecast Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Forecast Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    {{-- =================alert ================ --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session('import_logs'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Detail Forecast:</strong>
            <ul>
                @foreach (session('import_logs') as $log)
                    <li>{{ $log }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Export Gagal',
                    html: `{!! str_contains(session('error'), 'Export gagal: Data terlalu banyak')
                        ? 'Export gagal karena data terlalu banyak atau proses terlalu lama.<br>Silakan gunakan filter status, kategori, tanggal, atau plant untuk memperkecil data yang diexport.'
                        : session('error') !!}`,
                    confirmButtonText: 'OK'
                });
            });
        </script>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('error') }}
        </div>
    @endif
    {{-- end alert --}}
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* Add styles for column visibility dropdown */
        .dropdown-menu-columns {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .dropdown-item-column {
            display: flex;
            align-items: center;
            padding: 5px;
        }

        .dropdown-item-column input {
            margin-right: 8px;
        }
    </style>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeInLeft">Forecast Data</h5>
                        <div class="mb-2">
                            <a href="{{ route('forecast.export', [
                                'customer' => request('customer'),
                                'forecast_month' => request('forecast_month'),
                                'category' => request('category'),
                                'inv_id' => request('inv_id'),
                            ]) }}"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
                            </a>
                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                        return in_array($role, ['SuperAdmin', 'admin']);
                                    }))
                                {{-- <a href="{{ route('forecast.create') }}" class="btn btn-primary btn-sm  mb-1">
                                    <i class="bi bi-plus-square"></i> Create Forecast
                                </a> --}}
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import Excel
                                </button>
                            @endif
                        </div>
                        {{-- filter --}}
                        <form method="GET" class="row g-3 align-items-end mb-3">
                            <div class="col-md-3">
                                <label for="customer" class="form-label mb-0">Filter Customer</label>
                                <select name="customer" id="customer" class="form-select select2">
                                    <option value="">-- Semua Customer --</option>
                                    @foreach ($customers as $cust)
                                        <option value="{{ $cust->username }}"
                                            {{ request('customer') == $cust->username ? 'selected' : '' }}>
                                            {{ $cust->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    // Initialize Select2 for customer filter
                                    $('#customer').select2({
                                        placeholder: "-- Semua Customer --",
                                        allowClear: true,
                                        width: '100%'
                                    });

                                    // Initialize Select2 for per_page select
                                    $('#per_page').select2({
                                        minimumResultsForSearch: Infinity,
                                        width: 'auto'
                                    });
                                });
                            </script>
                            <div class="col-md-3">
                                <label for="forecast_month" class="form-label mb-0">Filter Forecast Bulan</label>
                                <input type="month" name="forecast_month" class="form-control" placeholder="mm-yyyy"
                                    value="{{ request('forecast_month') }}">
                            </div>
                            {{-- select kategori --}}
                            <div class="col-md-3">
                                <label for="category" class="form-label mb-0">Filter Kategori</label>
                                <select name="category" id="category" class="form-select select2">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="inv_id" class="form-label mb-0">Search inv id:</label>
                                <input type="text" name="inv_id" value="{{ request('inv_id') }}" class="form-control "
                                    placeholder="Cari Inv ID" style="width: 200px;">
                            </div>
                            {{-- Add hidden input for per_page to preserve it during filtering --}}
                            <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="font-size: 0.875rem; padding: 4px 8px;">Filter</button>
                                <a href="{{ route('forecast.index') }}" class="btn btn-secondary btn-sm"
                                    style="font-size: 0.875rem; padding: 4px 8px;">Reset</a>
                            </div>
                        </form>
                        {{-- end filter --}}

                        <div class="table-responsive animate__animated animate__fadeInUp">
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="d-flex align-items-center">
                                    <form class="form-inline me-3" id="perPageForm">
                                        <label for="per_page" class="mr-2">Items per page:</label>
                                        <select name="per_page" id="per_page" class="form-control form-control-sm"
                                            onchange="updatePerPage()">
                                            <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>
                                                25
                                            </option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>

                                        {{-- Hidden inputs for other filters to preserve them --}}
                                        <input type="hidden" name="customer" value="{{ request('customer') }}">
                                        <input type="hidden" name="forecast_month"
                                            value="{{ request('forecast_month') }}">
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="inv_id" value="{{ request('inv_id') }}">
                                    </form>

                                    <!-- Column visibility dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                            id="columnVisibilityDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="bi bi-eye"></i> Column Visibility
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-columns"
                                            aria-labelledby="columnVisibilityDropdown">
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="toggle-all-columns" checked>
                                                <label for="toggle-all-columns"><strong>Toggle All</strong></label>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-created_at" class="column-toggle"
                                                    data-column="created_at" checked>
                                                <label for="col-created_at">Created at</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-inv_id" class="column-toggle"
                                                    data-column="inv_id" checked>
                                                <label for="col-inv_id">Inv ID</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-part_name" class="column-toggle"
                                                    data-column="part_name" checked>
                                                <label for="col-part_name">Part Name</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-part_number" class="column-toggle"
                                                    data-column="part_number" checked>
                                                <label for="col-part_number">Part Number</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-customer" class="column-toggle"
                                                    data-column="customer" checked>
                                                <label for="col-customer">Customer</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-forecast_month" class="column-toggle"
                                                    data-column="forecast_month" checked>
                                                <label for="col-forecast_month">Forecast Month</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-freq_delivery" class="column-toggle"
                                                    data-column="freq_delivery" checked>
                                                <label for="col-freq_delivery">Freq Delivery</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-po_pcs" class="column-toggle"
                                                    data-column="po_pcs" checked>
                                                <label for="col-po_pcs">Po/Pcs</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-min" class="column-toggle"
                                                    data-column="min" checked>
                                                <label for="col-min">Min</label>
                                            </div>
                                            <div class="dropdown-item-column">
                                                <input type="checkbox" id="col-max" class="column-toggle"
                                                    data-column="max" checked>
                                                <label for="col-max">Max</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                            return in_array($role, ['SuperAdmin']);
                                        }))
                                    <div class="mt-1">
                                        <button type="button" class="btn btn-danger btn-sm" id="deleteAllBtn">
                                            <i class="bi bi-trash3-fill"></i> Delete Selected
                                        </button>
                                    </div>
                                @endif
                                {{-- form delete --}}
                                <form id="deleteForm" action="{{ route('forecast.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="ids" id="selectedIds">
                                </form>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                    return in_array($role, ['SuperAdmin']);
                                                }))
                                            <th class="text-center">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                        @endif
                                        <th class="text-center">No</th>
                                        <th class="text-center column-created_at">Created at</th>
                                        <th class="text-center column-inv_id">Inv ID</th>
                                        <th class="text-center column-part_name">Part Name</th>
                                        <th class="text-center column-part_number">Part Number</th>
                                        <th class="text-center column-customer">Customer</th>
                                        <th class="text-center column-forecast_month">Forecast Month</th>
                                        <th class="text-center column-freq_delivery">Freq Delivery</th>
                                        <th class="text-center column-po_pcs">Po/Pcs</th>
                                        <th class="text-center column-min">Min</th>
                                        <th class="text-center column-max">Max</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($forecasts as $index => $forecast)
                                        <tr>
                                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                        return in_array($role, ['SuperAdmin']);
                                                    }))
                                                <td class="text-center">
                                                    <input type="checkbox" name="ids[]" value="{{ $forecast->id }}"
                                                        class="form-check-input select-checkbox">
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                {{ ($forecasts->currentPage() - 1) * $forecasts->perPage() + $index + 1 }}
                                            </td>
                                            <td class="text-center column-created_at">
                                                {{ $forecast->updated_at ? \Carbon\Carbon::parse($forecast->updated_at)->format('d-m-Y H:i:s') : '-' }}
                                            </td>
                                            <td class="text-center column-inv_id">{{ $forecast->part->Inv_id ?? '-' }}
                                            </td>
                                            <td class="text-center column-part_name">
                                                {{ $forecast->part->Part_name ?? '-' }}</td>
                                            <td class="text-center column-part_number">
                                                {{ $forecast->part->Part_number ?? '-' }}</td>
                                            <td class="text-center column-customer">
                                                {{ $forecast->part->customer->username ?? '-' }}
                                            </td>
                                            <td class="text-center column-forecast_month">
                                                {{ \Carbon\Carbon::parse($forecast->forecast_month)->format('M Y') }}
                                            </td>
                                            <td class="text-center column-freq_delivery">
                                                {{ $forecast->frequensi_delivery ?? '-' }}</td>
                                            <td class="text-center column-po_pcs">{{ $forecast->PO_pcs }}</td>
                                            <td class="text-center column-min">{{ $forecast->min }}</td>
                                            <td class="text-center column-max">{{ $forecast->max }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Tambahkan pagination links -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    {{ $forecasts->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>

    {{-- checkbox --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select/Deselect all checkboxes
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.select-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Delete selected items
            document.getElementById('deleteAllBtn').addEventListener('click', function() {
                const selectedIds = Array.from(document.querySelectorAll('.select-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('Please select at least one item to delete.');
                    return;
                }

                if (confirm('Are you sure you want to delete the selected items?')) {
                    document.getElementById('selectedIds').value = selectedIds.join(',');
                    document.getElementById('deleteForm').submit();
                }
            });

            // Column visibility functionality
            const toggleAllColumnsCheckbox = document.getElementById('toggle-all-columns');
            const columnToggleCheckboxes = document.querySelectorAll('.column-toggle');

            // Load saved column visibility from localStorage
            function loadColumnVisibility() {
                const savedVisibility = localStorage.getItem('forecastColumnVisibility');
                if (savedVisibility) {
                    const visibilitySettings = JSON.parse(savedVisibility);

                    columnToggleCheckboxes.forEach(checkbox => {
                        const column = checkbox.dataset.column;
                        if (visibilitySettings.hasOwnProperty(column)) {
                            checkbox.checked = visibilitySettings[column];
                            toggleColumnVisibility(column, visibilitySettings[column]);
                        }
                    });

                    // Update toggle all checkbox based on current state
                    updateToggleAllCheckbox();
                }
            }

            // Save column visibility to localStorage
            function saveColumnVisibility() {
                const visibilitySettings = {};
                columnToggleCheckboxes.forEach(checkbox => {
                    visibilitySettings[checkbox.dataset.column] = checkbox.checked;
                });
                localStorage.setItem('forecastColumnVisibility', JSON.stringify(visibilitySettings));
            }

            // Toggle specific column visibility
            function toggleColumnVisibility(column, isVisible) {
                const columnCells = document.querySelectorAll(`.column-${column}`);
                columnCells.forEach(cell => {
                    cell.style.display = isVisible ? '' : 'none';
                });
            }

            // Update toggle all checkbox state based on individual checkboxes
            function updateToggleAllCheckbox() {
                const allChecked = Array.from(columnToggleCheckboxes).every(checkbox => checkbox.checked);
                toggleAllColumnsCheckbox.checked = allChecked;
            }

            // Toggle all columns event handler
            toggleAllColumnsCheckbox.addEventListener('change', function() {
                columnToggleCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    toggleColumnVisibility(checkbox.dataset.column, this.checked);
                });
                saveColumnVisibility();
            });

            // Individual column toggle event handlers
            columnToggleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    toggleColumnVisibility(this.dataset.column, this.checked);
                    updateToggleAllCheckbox();
                    saveColumnVisibility();
                });
            });

            // Initialize column visibility
            loadColumnVisibility();
        });

        // Function to handle per_page changes while preserving other filters
        function updatePerPage() {
            document.getElementById('perPageForm').submit();
        }
    </script>
    {{-- end --}}

    {{-- modal import Excel --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Forecast from Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('forecast.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" id="file" required
                                accept=".xls,.xlsx">
                            <small class="text-danger">*Download Template Excel Import: <a
                                    href="{{ asset('file/format-import-Forecast(system-sto).xlsx') }}" download> <i
                                        class="bi bi-download"></i> klik di sini</a></small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end --}}


@endsection
