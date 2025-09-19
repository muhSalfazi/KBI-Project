@extends('layouts.app')

@section('title', 'Dailly Stock')

@section('content')

    <div class="pagetitle animate__animated animate__fadeInLeft">
        <h1>Dailly Stock</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dailly Stock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

    @if (session('error_details'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <pre class="text-danger">{{ implode("\n", session('error_details')) }}</pre>
        </div>
    @endif


    @if (session('swal_error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Import Salah',
                    html: `{!! session('swal_error') !!}`,
                    confirmButtonText: 'Download Format Import Baru',
                    showCancelButton: true,
                    cancelButtonText: 'Kembali',
                    showCloseButton: true,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ asset('file/format-import-daily.xlsx') }}";
                    }
                    // Jika cancel atau close, tidak melakukan apa-apa (hanya tutup alert)
                });
            });
        </script>
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
    <style>
        .swal2-popup .swal2-html-container {
            text-align: left !important;
            max-height: 60vh;
            overflow-y: auto;
        }

        .swal2-popup ul {
            padding-left: 20px;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .swal2-popup li {
            margin-bottom: 3px;
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

    {{-- s confirm duplikat --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('confirm_duplicates'))
                const importData = @json(session('import_data'));
                const duplicates = importData.duplicates;

                let duplicateList = `
                    <div class="text-left mb-3">
                        <strong>Status Impor:</strong><br>
                        • Data baru: ${importData.imported}<br>
                        • Data duplikat: ${duplicates.length}<br>
                        <br>
                        <strong>Daftar Data Duplikat:</strong>
                        <div style="max-height: 400px; overflow-y: auto; margin-top: 10px;">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="thead-light sticky-top">
                                    <tr>
                                        <th>Inv ID</th>
                                        <th>Nama Part</th>
                                        <th>Qty</th>
                                        <th>Tanggal</th>
                                        <th>Plant</th>
                                        <th>Area</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                duplicates.forEach(item => {
                    duplicateList += `
                                    <tr>
                                        <td>${item.inv_id}</td>
                                        <td>${item.part_name}</td>
                                        <td>${item.existing_qty}</td>
                                        <td>${item.import_date}</td>
                                        <td>${item.plant}</td>
                                        <td>${item.area}</td>
                                    </tr>`;
                });

                duplicateList += `
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 text-muted">
                            <small>* Data dianggap duplikat jika memiliki Inv ID, Qty, Tanggal, Plant,Area dan Status yang sama</small>
                        </div>
                    </div>
                `;

                Swal.fire({
                    title: 'Data Duplikat Ditemukan',
                    html: duplicateList,
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Lewati Duplikat dan Lanjutkan Import',
                    focusConfirm: false,
                    customClass: {
                        htmlContainer: 'text-left',
                        confirmButton: 'btn btn-primary'
                    },
                    width: '900px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('daily-stock.process') }}";

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);

                        const action = document.createElement('input');
                        action.type = 'hidden';
                        action.name = 'duplicate_action';
                        action.value = 'skip';
                        form.appendChild(action);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            @endif
        });
    </script>


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeInLeft">Dailly Stock </h5>
                        <div class="mb-2">

                            {{-- export excel --}}
                            <a href="{{ route('daily-stock.export', [
                                'status' => request('status'),
                                'category' => request('category'),
                                'date' => request('date'),
                                'customer' => request('customer'),
                                'plant' => request('plant'),
                                'inv_id' => request('inv_id'),
                            ]) }}"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
                            </a>
                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                        return in_array($role, ['SuperAdmin', 'admin']);
                                    }))
                                <button type="button" class="btn btn-success btn-sm  me-2"
                                    data-bs-toggle="modal"data-bs-target="#importModal">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import Excel
                                </button>
                            @endif
                            <form method="GET" action="{{ route('daily-stock.index') }}">
                                <div class="row mb-3">
                                    {{-- select status --}}
                                    <div class="col-md-3">
                                        <label for="statusFilter" class="form-label">Status Filters:</label>
                                        <select class="form-select" name="status" id="statusFilter">
                                            <option value="">-- Semua Status --</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    {{ request('status') == $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- select kategori --}}
                                    <div class="col-md-3">
                                        <label for="categoryFilter" class="form-label">Category Filters:</label>
                                        <select class="form-select" name="category" id="categoryFilter">
                                            <option value="">-- Semua Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- select customer --}}
                                    <div class="col-md-3">
                                        <label for="customerFilter" class="form-label">Customer Filters:</label>
                                        <select class="form-select select2" name="customer" id="customerFilter">
                                            <option value="">-- Semua Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->username }}"
                                                    {{ request('customer') == $customer->username ? 'selected' : '' }}>
                                                    {{ $customer->username }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- date filter --}}
                                    <div class="col-md-3">
                                        <label for="dateFilter" class="form-label">Date Filter:</label>
                                        <input type="date" name="date" id="dateFilter" class="form-control"
                                            value="{{ request('date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="plantFilter" class="form-label">Plant Filter:</label>
                                        <select class="form-select" name="plant" id="plantFilter">
                                            <option value="">-- Semua Plant --</option>
                                            @foreach ($plants as $plant)
                                                <option value="{{ $plant->id }}"
                                                    {{ request('plant') == $plant->id ? 'selected' : '' }}>
                                                    {{ $plant->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- search inv id --}}
                                    <div class="col-md-3">
                                        <label for="inv_id" class="form-label">Search inv id:</label>
                                        <input type="text" name="inv_id" id="inv_id" value="{{ request('inv_id') }}"
                                            class="form-control " placeholder="Cari Inv ID..." style="width: 200px;">
                                        {{-- <small class="text-muted">Contoh: INV001, INV002, INV003</small> --}}
                                    </div>

                                    {{-- Add hidden input for per_page to preserve it during filtering --}}
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">

                                    <div class="col-md-3 d-flex align-items-end mt-1">
                                        <button type="submit" class="btn btn-primary me-2 btn-sm"
                                            style="font-size: 0.875rem; padding: 4px 8px;">Filter</button>
                                        <a href="{{ route('daily-stock.index') }}" class="btn btn-secondary btn-sm"
                                            style="font-size: 0.875rem; padding: 4px 8px;">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive animate__animated animate__fadeInUp">
                                <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                                    <div class="d-flex align-items-center">
                                        <form class="form-inline me-3" id="perPageForm">
                                            <label for="per_page" class="mr-2">Items per page:</label>
                                            <select name="per_page" id="per_page" class="form-control form-control-sm"
                                                onchange="updatePerPage()">
                                                <option value="25"
                                                    {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25
                                                </option>
                                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                                    50
                                                </option>
                                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                                    100
                                                </option>
                                            </select>

                                            {{-- Hidden inputs for other filters to preserve them --}}
                                            <input type="hidden" name="status" value="{{ request('status') }}">
                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                            <input type="hidden" name="customer" value="{{ request('customer') }}">
                                            <input type="hidden" name="date" value="{{ request('date') }}">
                                            <input type="hidden" name="plant" value="{{ request('plant') }}">
                                            <input type="hidden" name="inv_id" value="{{ request('inv_id') }}">
                                            <input type="hidden" name="from_dashboard"
                                                value="{{ request('from_dashboard') }}">
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
                                                    <label for="col-created_at">Created At</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-date" class="column-toggle"
                                                        data-column="date" checked>
                                                    <label for="col-date">Date</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-inv_id" class="column-toggle"
                                                        data-column="inv_id" checked>
                                                    <label for="col-inv_id">Inv Id</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-part_name" class="column-toggle"
                                                        data-column="part_name" checked>
                                                    <label for="col-part_name">Part Name</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-part_no" class="column-toggle"
                                                        data-column="part_no" checked>
                                                    <label for="col-part_no">Part No</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-sto_stock" class="column-toggle"
                                                        data-column="sto_stock" checked>
                                                    <label for="col-sto_stock">STO Stock PCS (Min/Max)</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-act_stock" class="column-toggle"
                                                        data-column="act_stock" checked>
                                                    <label for="col-act_stock">Act Stock (Qty/Day)</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-area" class="column-toggle"
                                                        data-column="area" checked>
                                                    <label for="col-area">Area</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-plant" class="column-toggle"
                                                        data-column="plant" checked>
                                                    <label for="col-plant">Plant</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-customer" class="column-toggle"
                                                        data-column="customer" checked>
                                                    <label for="col-customer">Customer</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-supplier" class="column-toggle"
                                                        data-column="supplier" checked>
                                                    <label for="col-supplier">Supplier</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-status" class="column-toggle"
                                                        data-column="status" checked>
                                                    <label for="col-status">Status</label>
                                                </div>
                                                <div class="dropdown-item-column">
                                                    <input type="checkbox" id="col-prepared_by" class="column-toggle"
                                                        data-column="prepared_by" checked>
                                                    <label for="col-prepared_by">Prepared By</label>
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
                                    <form id="deleteForm" action="{{ route('reports.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="ids" id="selectedIds">
                                    </form>
                                </div>
                                <table class="table table-striped table-bordered mt-2">
                                    <thead>
                                        <tr>
                                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                        return in_array($role, ['SuperAdmin']);
                                                    }))
                                                <th class="text-center"rowspan="2">
                                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                                </th>
                                            @endif
                                            <th class="text-center align-middle" rowspan="2">No</th>
                                            <th class="text-center align-middle column-created_at" rowspan="2">Created
                                                At</th>
                                            <th class="text-center align-middle column-date" rowspan="2">Date</th>
                                            <th class="text-center align-middle column-inv_id" rowspan="2">Inv Id</th>
                                            <th class="text-center align-middle column-part_name" rowspan="2">Part Name
                                            </th>
                                            <th class="text-center align-middle column-part_no" rowspan="2">Part No
                                            </th>
                                            <th class="text-center column-sto_stock" colspan="2">Sto Stock Pcs</th>
                                            <th class="text-center column-act_stock" colspan="2">Act Stock</th>
                                            <th class="text-center align-middle column-area" rowspan="2">Area</th>
                                            <th class="text-center align-middle column-plant" rowspan="2">Plant</th>
                                            <th class="text-center align-middle column-customer" rowspan="2">Customer
                                            </th>
                                            <th class="text-center align-middle column-supplier" rowspan="2">Supplier
                                            </th>
                                            <th class="text-center align-middle column-status" rowspan="2">Status</th>
                                            <th class="text-center align-middle column-prepared_by" rowspan="2">
                                                Prepared By</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center column-sto_stock">Min</th>
                                            <th class="text-center column-sto_stock">Max</th>
                                            <th class="text-center column-act_stock">Qty</th>
                                            <th class="text-center column-act_stock">Day</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dailyStockLogs as $key => $log)
                                            <tr>
                                                @if (Auth::user()->roles->pluck('name')->intersect(['SuperAdmin'])->isNotEmpty())
                                                    <td class="text-center">
                                                        <input type="checkbox" name="ids[]"
                                                            value="{{ $log->id }}"
                                                            class="form-check-input select-checkbox">
                                                    </td>
                                                @endif
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center column-created_at">
                                                    {{ $log->updated_at ? \Carbon\Carbon::parse($log->updated_at)->format('d-m-Y H:i:s') : '-' }}
                                                </td>
                                                <td class="text-center column-date">
                                                    {{ $log->date ? \Carbon\Carbon::parse($log->date)->format('d M Y') : '-' }}
                                                </td>
                                                <td class="column-inv_id">{{ $log->part->Inv_id ?? '-' }}</td>
                                                <td class="column-part_name">{{ $log->part->Part_name ?? '-' }}</td>
                                                <td class="column-part_no">{{ $log->part->Part_number ?? '-' }}</td>
                                                <td class="text-center column-sto_stock">
                                                    {{ $log->forecast_min ?? 'NOFC' }}
                                                </td>
                                                <td class="text-center column-sto_stock">
                                                    {{ $log->forecast_max ?? 'NOFC' }}
                                                </td>
                                                <td class="text-center column-act_stock">{{ $log->Total_qty }}</td>
                                                <td class="text-center column-act_stock">
                                                    @if ($log->has_forecast)
                                                        @if ($log->stock_per_day == 0)
                                                            <span style="color: red;">
                                                                {{ number_format($log->stock_per_day, 1) }}
                                                                {{-- <br>
                                                                <span
                                                                    class="badge bg-danger stock-day-badge">{{ stock_day_category($log->stock_per_day) }}</span> --}}
                                                            </span>
                                                        @else
                                                            {{ number_format($log->stock_per_day, 1) }}
                                                            {{-- <br>
                                                            <span
                                                                class="badge bg-info stock-day-badge">{{ stock_day_category($log->stock_per_day) }}</span> --}}
                                                        @endif
                                                    @else
                                                        <span style="color: red;">NOFC</span>
                                                        @if (!$log->id_inventory)
                                                            <small class="text-muted">(No Inventory)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="column-area">{{ $log->areaHead->nama_area ?? 'By Excel' }}</td>
                                                <td class="column-plant">{{ $log->areaHead->plan->name ?? 'By Excel' }}
                                                </td>
                                                <td class="column-customer">{{ $log->part->customer->username ?? '-' }}
                                                </td>
                                                <td class="column-supplier">{{ $log->part->supplier ?? '-' }} </td>
                                                <td class="text-center column-status">{{ $log->status }}</td>
                                                <td class="text-center column-prepared_by">{{ $log->user->username }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="17" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- Tambahkan pagination links -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        {{ $dailyStockLogs->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
                    const savedVisibility = localStorage.getItem('dailyStockColumnVisibility');
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
                    localStorage.setItem('dailyStockColumnVisibility', JSON.stringify(visibilitySettings));
                }

                // Toggle specific column visibility
                function toggleColumnVisibility(column, isVisible) {
                    const columnCells = document.querySelectorAll(`.column-${column}`);
                    columnCells.forEach(cell => {
                        cell.style.display = isVisible ? '' : 'none';
                    });

                    // Special handling for grouped columns (headers)
                    if (column === 'sto_stock' || column === 'act_stock') {
                        // Find the parent th with colspan that needs toggling
                        const columnHeader = document.querySelector(`th.column-${column}`);
                        if (columnHeader) {
                            columnHeader.style.display = isVisible ? '' : 'none';
                        }
                    }
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
                const perPage = document.getElementById('per_page').value;
                let url = window.location.pathname + window.location.search;
                let [base, queryString] = url.split('?');
                let params = [];
                let perPageFound = false;
                if (queryString) {
                    params = queryString.split('&').filter(Boolean).map(p => {
                        if (p.startsWith('per_page=')) {
                            perPageFound = true;
                            return 'per_page=' + encodeURIComponent(perPage);
                        }
                        return p;
                    });
                    if (!perPageFound) {
                        params.push('per_page=' + encodeURIComponent(perPage));
                    }
                } else {
                    params = ['per_page=' + encodeURIComponent(perPage)];
                }
                // Pastikan per_page di akhir
                params = params.filter(p => !p.startsWith('per_page='));
                params.push('per_page=' + encodeURIComponent(perPage));
                window.location.href = base + '?' + params.join('&');
            }
        </script>

        <!-- Modal Import Excel -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Daily Stock from Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('daily-stock.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <label for="file" class="form-label">Upload Excel File</label>
                                <input type="file" name="file" class="form-control" id="file" required
                                    accept=".xls,.xlsx">
                                <small class="text-danger">*Download Template Excel Import: <a
                                        href="{{ asset('file/format-import-daily.xlsx') }}" download><i
                                            class="bi bi-download"></i> Click here</a></small><br>
                                {{-- RW kbi1 --}}
                                <small class="text-secondary mt-1">
                                    <a href="{{ asset('file/format-daily-RW.xlsx') }}" download>*Rawmaterial
                                        KBI1</a></small>
                                {{-- childpartkbi1 --}}
                                <small class="text-secondary mt-1">
                                    <a href="{{ asset('file/format-daily-childpart-kbi1.xlsx') }}" download>*Childpart
                                        KBI1</a></small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success mt-1">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Show notification when redirected from dashboard with filters
        document.addEventListener('DOMContentLoaded', function() {
            // Check if came from dashboard
            const urlParams = new URLSearchParams(window.location.search);
            const fromDashboard = urlParams.get('from_dashboard');

            if (fromDashboard === '1') {
                // Create success alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show';
                alertDiv.setAttribute('role', 'alert');

                // Check what filters were applied
                const appliedFilters = [];
                const dateParam = urlParams.get('date');
                const invIdParam = urlParams.get('inv_id');
                const stockCategory = urlParams.get('stock_category');
                const customerParam = urlParams.get('customer');
                const categoryParam = urlParams.get('category');

                if (dateParam) {
                    console.log('Date filter applied:', dateParam); // Debug log
                    const formattedDate = new Date(dateParam).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    appliedFilters.push(`Tanggal ${formattedDate}`);
                }

                if (stockCategory) {
                    console.log('Stock category filter applied:', stockCategory); // Debug log
                    appliedFilters.push(`Klasifikasi Stok "${stockCategory}"`);
                }

                if (customerParam) {
                    console.log('Customer filter applied:', customerParam); // Debug log
                    appliedFilters.push(`Customer "${customerParam}"`);
                }

                if (categoryParam) {
                    console.log('Category filter applied:', categoryParam); // Debug log
                    appliedFilters.push(`Kategori #${categoryParam}`);
                }

                // if (invIdParam) {
                //     const invIdCount = invIdParam.split(',').length;
                //     console.log('Inv ID filter applied, count:', invIdCount, 'values:', invIdParam); // Debug log
                //     appliedFilters.push(`${invIdCount} Inv ID${invIdCount > 1 ? 's' : ''}`);
                // }

                let filterText;
                if (appliedFilters.length > 0) {
                    filterText = `Hasil pencarian dari Dashboard: ${appliedFilters.join(', ')}`;
                } else {
                    filterText = 'Hasil pencarian berdasarkan pilihan dari Dashboard Chart';
                }

                alertDiv.innerHTML = `
                    <i class="bi bi-info-circle"></i>
                    ${filterText}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;

                // Insert after breadcrumb
                const breadcrumb = document.querySelector('.pagetitle');
                if (breadcrumb) {
                    breadcrumb.parentNode.insertBefore(alertDiv, breadcrumb.nextSibling);
                }

                // Auto hide after 7 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 10000);

                // Highlight rows matching the stock category if specified
                if (stockCategory) {
                    highlightStockCategoryRows(stockCategory);
                }
            }
        });

        // Function to highlight rows with matching stock categories
        function highlightStockCategoryRows(category) {
            setTimeout(() => {
                const rows = document.querySelectorAll('table tbody tr');

                rows.forEach(row => {
                    const stockDayBadge = row.querySelector('.stock-day-badge');
                    if (stockDayBadge && stockDayBadge.textContent.trim() === category) {
                        row.classList.add('table-info'); // Add Bootstrap highlighting
                    }
                });
            }, 200); // Small delay to ensure DOM is ready
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Select2 pada customerFilter
            if (window.jQuery && $('#customerFilter').length) {
                $('#customerFilter').select2({
                    width: '100%',
                    placeholder: '-- Semua Customer --',
                    allowClear: true
                });
                // Initialize Select2 for per_page select
                $('#per_page').select2({
                    minimumResultsForSearch: Infinity,
                    width: 'auto'
                });
            }
            // Jika from_dashboard aktif, disable semua filter kecuali per_page
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('from_dashboard') === '1') {
                // Disable semua select dan input filter kecuali per_page
                $('#statusFilter').prop('disabled', true);
                $('#categoryFilter').prop('disabled', true);
                $('#customerFilter').prop('disabled', true);
                $('#plantFilter').prop('disabled', true);
                $('#dateFilter').prop('disabled', true);
                $('#inv_id').prop('disabled', true);
                // Jika pakai select2, refresh tampilannya
                $('#statusFilter').trigger('change.select2');
                $('#categoryFilter').trigger('change.select2');
                $('#customerFilter').trigger('change.select2');
                $('#plantFilter').trigger('change.select2');
            }
        });
    </script>

@endsection
