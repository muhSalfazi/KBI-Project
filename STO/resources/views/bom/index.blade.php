@extends('layouts.app')

@section('title', 'Bill of Materials (BOM)')

@section('content')
    <div class="pagetitle animate__animated animate__fadeInLeft">
        <h1>Bill of Materials (BOM)</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">BOM</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ session('error') }}</strong>

            @if (session('error_details'))
                <hr>
                <div style="max-height: 300px; overflow-y: auto;">
                    <ul class="mb-0">
                        @foreach (session('error_details') as $detail)
                            <li>{{ $detail }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title animate__animated animate__fadeInLeft">BOM List</h5>
                        {{-- export excel --}}
                        <a href="{{ route('bom.export', ['search' => request('search')]) }}"
                            class="btn btn-warning btn-sm mb-1">
                            <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
                        </a>
                        @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                    return in_array($role, ['SuperAdmin', 'admin']);
                                }))
                            <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="modal"
                                data-bs-target="#importModal">
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import Excel
                            </button>
                        @endif
                        <!-- Search Form -->
                        <form action="{{ route('bom.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by INV ID or Part Name..." value="{{ request('search') }}">
                                @if (request('per_page'))
                                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                @endif
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </form>
                        {{-- Pagination  --}}
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="d-flex align-items-center">
                                <form class="form-inline me-3" id="perPageForm">
                                    <label for="per_page" class="mr-2">Items per page:</label>
                                    <select name="per_page" id="per_page" class="form-control form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
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
                                                    value="created_date" id="col_created_date" checked>
                                                <label class="form-check-label" for="col_created_date">
                                                    Created or Revised date
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="product_id" id="col_product_id" checked>
                                                <label class="form-check-label" for="col_product_id">
                                                    Product
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="product_name" id="col_product_name" checked>
                                                <label class="form-check-label" for="col_product_name">
                                                    Product Name
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="part_material" id="col_part_material" checked>
                                                <label class="form-check-label" for="col_part_material">
                                                    Part / Material
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="component_name" id="col_component_name" checked>
                                                <label class="form-check-label" for="col_component_name">
                                                    Component Name
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="quantity" id="col_quantity" checked>
                                                <label class="form-check-label" for="col_quantity">
                                                    Quantity
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input toggle-column" type="checkbox"
                                                    value="unit" id="col_unit" checked>
                                                <label class="form-check-label" for="col_unit">
                                                    Unit
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
                                {{-- form delete --}}
                                <form id="deleteForm" action="{{ route('bom.delete-multiple') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="ids" id="selectedIds">
                                </form>
                                <div class="mt-1">
                                    <button type="button" class="btn btn-danger btn-sm" id="deleteAllBtn">
                                        <i class="bi bi-trash3-fill"></i> Delete Selected
                                    </button>
                                </div>
                            @endif
                        </div>


                        <div class="table-responsive animate__animated animate__fadeInUp">
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
                                        <th class="text-center column-created_date">Created or Revised date</th>
                                        <th class="text-center column-product_id">Product</th>
                                        <th class="text-center column-product_name">Product Name</th>
                                        <th class="text-center column-part_material">Part / Material </th>
                                        <th class="text-center column-component_name">Component Name</th>
                                        <th class="text-center column-quantity">Quantity</th>
                                        <th class="text-center column-unit">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($boms as $index => $bom)
                                        <tr>
                                            @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                                return in_array($role, ['SuperAdmin']);
                                            }))
                                                <td class="text-center">
                                                    <input type="checkbox" name="ids[]" value="{{ $bom->id }}"
                                                        class="form-check-input select-checkbox">
                                                </td>
                                            @endif
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center column-created_date">{{ $bom->updated_at }}</td>
                                            <td class="text-center column-product_id">{{ $bom->product->Inv_id }}</td>
                                            <td class="column-product_name">{{ $bom->product->Part_name }}</td>
                                            <td class="text-center column-part_material">{{ $bom->component->Inv_id }}
                                            </td>
                                            <td class="column-component_name">{{ $bom->component->Part_name }}</td>
                                            <td class="column-quantity">{{ $bom->quantity }}</td>
                                            <td class="column-unit">{{ $bom->unit }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No BOM data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                {{ $boms->withQueryString()->links('pagination::bootstrap-5') }}
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
                localStorage.removeItem('bomColumnPreferences');
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
                localStorage.setItem('bomColumnPreferences', JSON.stringify(preferences));
            }

            // Function to load column preferences
            function loadColumnPreferences() {
                const savedPreferences = localStorage.getItem('bomColumnPreferences');
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

    {{-- import modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import BOM from Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bom.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" id="file" required
                                accept=".xls,.xlsx">
                            <small class="text-danger">*Download Template Excel Import: <a
                                    href="{{ asset('file/format-BOM-systemsto.xlsx') }}" download> <i
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
