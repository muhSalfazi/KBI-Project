@extends('layouts.app')

@section('title', 'Data Parts')

@section('content')
    <div class="pagetitle animate__animated animate__fadeInLeft">
        <h1>Data Parts</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Data Part</li>
            </ol>
        </nav>
    </div>
    {{-- =====================alert ======================== --}}
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
            <strong>Detail Import:</strong>
            <ul>
                @foreach (session('import_logs') as $log)
                    <li>{{ $log }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- ============================= --}}
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeInLeft">Data Part </h5>
                         @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                            return in_array($role, ['SuperAdmin','admin']);
                                        }))
                            <div class="mb-2 d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-sm  me-2"
                                    data-bs-toggle="modal"data-bs-target="#importModal">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import Excel
                                </button>
                                <a href="{{ route('part.export') }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
                                </a>
                            </div>
                            <div class="mb-2">
                                <form action="{{ route('parts.all') }}" method="GET"
                                    class="d-flex align-items-center flex-wrap gap-2">
                                    {{-- Filter Kategori --}}
                                    <select name="category_id" id="category_id" class="form-select form-select-sm me-2"
                                        style="width: 200px;">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- filter customer --}}
                                    <select name="customer_id" id="customer_id" class="form-select form-select-sm me-2"
                                        style="width: 200px;">
                                        <option value="">-- Pilih Customer --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->username }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Filter Supplier --}}
                                    <select name="supplier" id="supplier" class="form-select form-select-sm me-2"
                                        style="width: 200px;">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->supplier }}"
                                                {{ request('supplier') == $supplier->supplier ? 'selected' : '' }}>
                                                {{ $supplier->supplier }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Filter Inv_id --}}
                                    <input type="text" name="inv_id" value="{{ request('inv_id') }}"
                                        class="form-control form-control-sm me-1" placeholder="Search by INV ID..."
                                        style="width: 200px;">

                                    @if (request('per_page'))
                                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                    @endif

                                    {{-- Tombol --}}
                                    <button type="submit" class="btn btn-primary btn-sm me-1">Filter</button>
                                    <a href="{{ route('parts.all') }}" class="btn btn-secondary btn-sm">Reset</a>
                                </form>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="d-flex align-items-center">
                                <form class="form-inline me-3">
                                    <label for="per_page" class="mr-2">Items per page:</label>
                                    <select name="per_page" id="per_page" class="form-control form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                        </option>
                                    </select>
                                    @if (request('category_id'))
                                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    @endif
                                    @if (request('customer_id'))
                                        <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
                                    @endif
                                    @if (request('supplier'))
                                        <input type="hidden" name="supplier" value="{{ request('supplier') }}">
                                    @endif
                                    @if (request('inv_id'))
                                        <input type="hidden" name="inv_id" value="{{ request('inv_id') }}">
                                    @endif
                                </form>

                                <!-- Column Visibility Dropdown -->
                                <div class="dropdown me-2">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        id="columnVisibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-eye"></i> Toggle Columns
                                    </button>
                                    <ul class="dropdown-menu p-2" aria-labelledby="columnVisibilityDropdown">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="inv_id" id="col_inv_id" checked>
                                                <label class="form-check-label" for="col_inv_id">
                                                    Inv ID
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="part_name" id="col_part_name" checked>
                                                <label class="form-check-label" for="col_part_name">
                                                    Part Name
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="part_number" id="col_part_number" checked>
                                                <label class="form-check-label" for="col_part_number">
                                                    Part Number
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="category" id="col_category" checked>
                                                <label class="form-check-label" for="col_category">
                                                    Category
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="customer" id="col_customer" checked>
                                                <label class="form-check-label" for="col_customer">
                                                    Customer
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="supplier" id="col_supplier" checked>
                                                <label class="form-check-label" for="col_supplier">
                                                    Supplier
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="subcont" id="col_subcont" checked>
                                                <label class="form-check-label" for="col_subcont">
                                                    Subcont/Source
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="package" id="col_package" checked>
                                                <label class="form-check-label" for="col_package">
                                                    Package
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="qty_box" id="col_qty_box" checked>
                                                <label class="form-check-label" for="col_qty_box">
                                                    Qty/Box
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="plant" id="col_plant" checked>
                                                <label class="form-check-label" for="col_plant">
                                                    Plant
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="area" id="col_area" checked>
                                                <label class="form-check-label" for="col_area">
                                                    Area
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button class="btn btn-sm btn-primary w-100" id="resetColumns">Reset to
                                                Default</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                              @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                            return in_array($role, ['SuperAdmin']);
                                        }))
                                <div class="mt-1">
                                    <button type="button" class="btn btn-danger btn-sm mt-1" id="deleteAllBtn">
                                        <i class="bi bi-trash3-fill"></i> Delete Selected
                                    </button>
                                </div>
                            @endif
                            <form id="deleteForm" action="{{ route('part.delete-multiple') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="ids" id="selectedIds">
                            </form>
                        </div>
                        <div class="table-responsive animate__animated animate__fadeInUp">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                            return in_array($role, ['SuperAdmin']);
                                        }))
                                            <th class="text-center">
                                                <input type="checkbox" id="selectAll" class="form-check-input">
                                            </th>
                                        @endif
                                        <th>No</th>
                                        <th class="column-inv_id">Inv ID</th>
                                        <th class="column-part_name">Part Name</th>
                                        <th class="column-part_number">Part Number</th>
                                        <th class="column-category">Category</th>
                                        <th class="column-customer">Customer</th>
                                        <th class="column-supplier">Supplier</th>
                                        <th class="column-subcont">Subcont/Source</th>
                                        <th class="column-package">Package</th>
                                        <th class="column-qty_box">Qty/Box</th>
                                        <th class="column-plant">Plant</th>
                                        <th class="column-area">Area</th>
                                         @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                            return in_array($role, ['SuperAdmin']);
                                        }))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($parts as $index => $part)
                                        <tr>
                                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                return in_array($role, ['SuperAdmin']);
                                            }))
                                                <td class="text-center">
                                                    <input type="checkbox" name="ids[]" value="{{ $part->id }}"
                                                        class="form-check-input select-checkbox">
                                                </td>
                                            @endif
                                            <td>{{ $parts->firstItem() + $index }}</td>
                                            <td class="column-inv_id">{{ $part->Inv_id }}</td>
                                            <td class="column-part_name">{{ $part->Part_name ?? '-' }}</td>
                                            <td class="column-part_number">{{ $part->Part_number ?? '-' }}</td>
                                            <td class="column-category">{{ $part->category->name ?? '-' }}</td>
                                            <td class="column-customer">{{ $part->customer->username ?? '-' }}</td>
                                            <td class="column-supplier">{{ $part->supplier ?? '-' }}</td>
                                            <td class="column-subcont">{{ $part->subcont ?? '-' }}</td>
                                            <td class="column-package">{{ $part->package->type_pkg ?? '-' }}</td>
                                            <td class="column-qty_box">{{ $part->package->qty ?? '-' }}</td>
                                            <td class="column-plant">{{ $part->plant->name ?? '-' }}</td>
                                            <td class="column-area">{{ $part->area->nama_area ?? '-' }}</td>
                                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                return in_array($role, ['SuperAdmin']);
                                            }))
                                                <td class="text-center">
                                                    <a href="{{ route('parts.edit', $part->id) }}"
                                                        class="btn btn-success btn-sm"
                                                        style="font-size: 0.875rem; padding: 4px 8px;">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                {{ $parts->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- checkbox all js --}}
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

                // Column visibility toggle functionality
                const toggleColumnCheckboxes = document.querySelectorAll('.toggle-column');

                // Load saved column preferences
                loadColumnPreferences();

                // Add event listeners to toggle columns
                toggleColumnCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const columnName = this.value;
                        const isChecked = this.checked;

                        // Toggle column visibility
                        toggleColumnVisibility(columnName, isChecked);

                        // Save preferences to localStorage
                        saveColumnPreferences();
                    });
                });

                // Reset columns button
                document.getElementById('resetColumns').addEventListener('click', function() {
                    toggleColumnCheckboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });

                    // Show all columns
                    document.querySelectorAll('[class*="column-"]').forEach(col => {
                        col.style.display = '';
                    });

                    // Clear saved preferences
                    localStorage.removeItem('partsColumnPreferences');
                });

                // Function to toggle column visibility
                function toggleColumnVisibility(columnName, isVisible) {
                    const columnElements = document.querySelectorAll(`.column-${columnName}`);
                    columnElements.forEach(el => {
                        el.style.display = isVisible ? '' : 'none';
                    });
                }

                // Function to save column preferences
                function saveColumnPreferences() {
                    const preferences = {};
                    toggleColumnCheckboxes.forEach(checkbox => {
                        preferences[checkbox.value] = checkbox.checked;
                    });
                    localStorage.setItem('partsColumnPreferences', JSON.stringify(preferences));
                }

                // Function to load column preferences
                function loadColumnPreferences() {
                    const savedPreferences = localStorage.getItem('partsColumnPreferences');
                    if (savedPreferences) {
                        const preferences = JSON.parse(savedPreferences);
                        toggleColumnCheckboxes.forEach(checkbox => {
                            const columnName = checkbox.value;
                            if (preferences.hasOwnProperty(columnName)) {
                                checkbox.checked = preferences[columnName];
                                toggleColumnVisibility(columnName, preferences[columnName]);
                            }
                        });
                    }
                }
            });
        </script>
    </section>
    {{-- modal import Excel --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Parts from Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('parts.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="redirect_to" value="all">
                        <div class="mb-2">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" id="file" required
                                accept=".xls,.xlsx">
                            <small class="text-danger">*Download Template Excel Import: <a
                                    href="{{ asset('file/format-import-part(system-sto).xlsx') }}" download><i
                                        class="bi bi-download"></i> klik di sini</a></small>
                        </div>
                        {{-- <small class="text-secondary ">
                            *Lihat referensi untuk Area & customer:
                            <a href="{{ asset('file/area_customer_kbi.xlsx') }}" download>
                                <i class="bi bi-download"></i> Reference
                            </a>
                        </small> --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success mt-1">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end --}}

@endsection
