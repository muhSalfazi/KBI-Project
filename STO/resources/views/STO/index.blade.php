@extends('layouts.app')

@section('title', 'List Sto')

@section('content')
    <div class="pagetitle animate__animated animate__fadeInLeft">
        <h1>Data Sto</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">List Data Sto</li>
            </ol>
        </nav>
    </div>
    {{-- ========================= alert ======================= --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Export Gagal',
                    html: `{{ str_contains(session('error'), 'Export gagal: Data terlalu banyak') ? 'Export gagal karena data terlalu banyak atau proses terlalu lama.<br>Silakan gunakan filter kategori, remark, atau bulan untuk memperkecil data yang diexport.' : session('error') }}`,
                    confirmButtonText: 'OK'
                });
            });
        </script>
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
            <ul>
                <strong>Detail Import:</strong>
                <ul>
                    @foreach (session('import_logs') as $log)
                        <li>{{ $log }}</li>
                    @endforeach
                </ul>
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
    {{-- ==================================== --}}
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeInLeft">Daftar STO</h5>
                        <div class="mb-2">
                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                        return in_array($role, ['SuperAdmin', 'admin']);
                                    }))
                                {{-- <a href="{{ route('sto.create.get') }}" class="btn btn-primary btn-sm me-2"
                                    style="font-size: 0.875rem; padding: 4px 8px;">
                                    <i class="bi bi-plus-square"></i> Create STO
                                </a> --}}
                                <button type="button" class="btn btn-success btn-sm me-2"
                                    style="font-size: 0.875rem; padding: 4px 8px;" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bi bi-filetype-csv"></i></i> Import Excel By Ledger
                                </button>
                                <button type="button" class="btn btn-warning btn-sm me-2"
                                    style="font-size: 0.875rem; padding: 4px 8px;"
                                    onclick="window.location='{{ route(
                                        'sto.export',
                                        array_filter([
                                            'category_id' => request('category_id'),
                                            'remark' => request('remark'),
                                            'inv_id' => request('inv_id'),
                                            'month' => request('month'),
                                        ]),
                                    ) }}'">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
                                </button>
                            @endif

                            {{-- history sto --}}
                            {{-- <button type="button" class="btn btn-info btn-sm me-2"
                                style="font-size: 0.875rem; padding: 4px 8px;"
                                onclick="window.location='{{ route('esxportHistory', ['category_id' => request('category_id')]) }}'">
                                <i class="bi bi-file-earmark-arrow-down-fill"></i> Export Excel History STO
                            </button> --}}

                        </div>
                        <!-- Filter Kategori -->
                        <form action="{{ route('sto.index') }}" method="GET" class="row g-3 align-items-end mb-3">
                            {{-- date filter --}}
                            <div class="col-md-3">
                                <label for="monthFilter" class="form-label">Month Filter:</label>
                                <input type="month" name="month" id="monthFilter" class="form-control"
                                    value="{{ request('month') }}">
                            </div>
                            <!-- Filter Kategori -->
                            <div class="col-md-3">
                                <label for="category_id" class="form-label mb-0">Kategori</label>
                                <select name="category_id" id="category_id" class="form-select form-select-sm ">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <!-- Filter Remark -->
                                <label for="remark" class="form-label mb-0">Remark</label>
                                <select name="remark" id="remark" class="form-select form-select-sm">
                                    <option value="">-- Pilih Remark --</option>
                                    <option value="normal" {{ request('remark') == 'normal' ? 'selected' : '' }}>
                                        Normal
                                    </option>
                                    <option value="abnormal" {{ request('remark') == 'abnormal' ? 'selected' : '' }}>
                                        Abnormal</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="inv_id" class="form-label mb-0">Search inv id:</label>
                                <input type="text" name="inv_id" value="{{ request('inv_id') }}" class="form-control "
                                    placeholder="inv id...">
                            </div>
                            {{-- Add hidden input for per_page to preserve it during filtering --}}
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm me-2"
                                    style="font-size: 0.875rem; padding: 4px 8px;">Filter</button>
                                <a href="{{ route('sto.index') }}" class="btn btn-secondary btn-sm me-2"
                                    style="font-size: 0.875rem; padding: 4px 8px;">Reset</a>
                            </div>
                        </form>

                        {{-- <div class="table-responsive animate__animated animate__fadeInUp"> --}}
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="d-flex align-items-center">
                                <form class="form-inline me-3" id="perPageForm">
                                    <label for="per_page" class="mr-2">Items per page:</label>
                                    <select name="per_page" id="per_page" class="form-control form-control-sm"
                                        onchange="updatePerPage()">
                                        <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>
                                            25
                                        </option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                            50
                                        </option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                            100
                                        </option>
                                    </select>

                                    {{-- Hidden inputs for other filters to preserve them --}}
                                    <input type="hidden" name="date" value="{{ request('date') }}">
                                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    <input type="hidden" name="remark" value="{{ request('remark') }}">
                                    <input type="hidden" name="inv_id" value="{{ request('inv_id') }}">
                                    <input type="hidden" name="month" value="{{ request('month') }}">
                                </form>

                                <!-- Column visibility dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                        id="columnVisibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                                            <input type="checkbox" id="col-datetime" class="column-toggle"
                                                data-column="datetime" checked>
                                            <label for="col-datetime">DateTime</label>
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
                                            <input type="checkbox" id="col-part_no" class="column-toggle"
                                                data-column="part_no" checked>
                                            <label for="col-part_no">Part No</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-plan" class="column-toggle"
                                                data-column="plan" checked>
                                            <label for="col-plan">Plan</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-customer" class="column-toggle"
                                                data-column="customer" checked>
                                            <label for="col-customer">Customer</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-plan_stok" class="column-toggle"
                                                data-column="plan_stok" checked>
                                            <label for="col-plan_stok">Plan Stok</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-act_stok" class="column-toggle"
                                                data-column="act_stok" checked>
                                            <label for="col-act_stok">Act Stok</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-category" class="column-toggle"
                                                data-column="category" checked>
                                            <label for="col-category">Category</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-sto_period" class="column-toggle"
                                                data-column="sto_period" checked>
                                            <label for="col-sto_period">STO Period</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-remark" class="column-toggle"
                                                data-column="remark" checked>
                                            <label for="col-remark">Remark</label>
                                        </div>
                                        <div class="dropdown-item-column">
                                            <input type="checkbox" id="col-note_remark" class="column-toggle"
                                                data-column="note_remark" checked>
                                            <label for="col-note_remark">Note-Remark</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- button delete --}}
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
                            <form id="deleteForm" action="{{ route('sto.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="ids" id="selectedIds">
                            </form>
                        </div>
                        {{-- </div> --}}

                        <div class="table-responsive animate__animated animate__fadeInUp">
                            <table class="table table-striped table-bordered ">
                                <thead class="thead-light">
                                    <tr>
                                        @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                    return in_array($role, ['SuperAdmin']);
                                                }))
                                            <th class="text-center">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                        @endif
                                        <th class="text-center">No</th>
                                        <th class="text-center column-datetime">DateTime</th>
                                        <th class="text-center column-inv_id">Inv ID</th>
                                        <th class="text-center column-part_name">Part Name</th>
                                        <th class="text-center column-part_no">Part No</th>
                                        <th class="text-center column-plan">Plan</th>
                                        <th class="text-center column-customer">Customer</th>
                                        <th class="text-center column-plan_stok">Plan Stok</th>
                                        <th class="text-center column-act_stok">Act Stok</th>
                                        <th class="text-center column-category">Category</th>
                                        <th class="text-center column-sto_period">STO Period</th>
                                        <th class="text-center column-remark">Remark</th>
                                        <th class="text-center column-note_remark">Note-Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($parts as $part)
                                        <tr>
                                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                        return in_array($role, ['SuperAdmin']);
                                                    }))
                                                <td class="text-center">
                                                    <input type="checkbox" name="ids[]" value="{{ $part->id }}"
                                                        class="form-check-input select-checkbox">
                                                </td>
                                            @endif
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center column-datetime">
                                                {{ $part->updated_at ? $part->updated_at->format('d-m-Y H:i:s') : '-' }}
                                            </td>
                                            <td class="text-center column-inv_id">{{ $part->part->Inv_id ?? '-' }}</td>
                                            <td class="text-center column-part_name">{{ $part->part->Part_name ?? '-' }}
                                            </td>
                                            <td class="text-center column-part_no">{{ $part->part->Part_number ?? '-' }}
                                            </td>
                                            <td class="text-center column-plan">{{ $part->part->plant->name ?? '-' }}</td>
                                            <td class="text-center column-customer">
                                                {{ $part->part->customer->username ?? '-' }}</td>
                                            <td class="text-center column-plan_stok">{{ $part->plan_stock ?? '-' }}</td>
                                            <td class="text-center column-act_stok">{{ $part->act_stock ?? '-' }}</td>
                                            <td class="text-center column-category">
                                                {{ $part->part->category->name ?? '-' }}</td>
                                            <td class="text-center column-sto_period">
                                                {{ $part->date ? \Carbon\Carbon::parse($part->date)->format('M Y') : '-' }}
                                            </td>
                                            <td class="text-center column-remark">
                                                @if ($part->remark === 'normal')
                                                    <span class="badge bg-success text-white px-2 py-1">Normal</span>
                                                @elseif ($part->remark === 'abnormal')
                                                    <span class="badge bg-danger text-white px-2 py-1">Abnormal</span>
                                                @else
                                                    <span class="badge bg-secondary text-white px-2 py-1">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center column-note_remark">{{ $part->note_remark ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                {{ $parts->withQueryString()->links('pagination::bootstrap-5') }}
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
                    const savedVisibility = localStorage.getItem('stoColumnVisibility');
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
                    localStorage.setItem('stoColumnVisibility', JSON.stringify(visibilitySettings));
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
    </section>


    {{-- modal import excel --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import List Sto from Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sto.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" id="file" required
                                accept=".xls,.xlsx">
                            <small class="text-danger">*Download Template Excel Import: <a
                                    href="{{ asset('file/format-import-listSto(system-sto).xlsx') }}" download><i
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
