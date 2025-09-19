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
                        <h5 class="card-title animate__animated animate__fadeInLeft">Data Part By Customer</h5>
                        @if (Auth::user()->roles->pluck('name')->contains(function ($role) {
                                    return in_array($role, ['SuperAdmin', ' admin']);
                                }))
                            <div class="mb-2 d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-sm  me-2"
                                    data-bs-toggle="modal"data-bs-target="#importModal">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import Excel
                                </button>
                                <a href="{{ route('part.export', ['category_id' => request('category_id'), 'export_type' => 'customer']) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Export Excel
                                </a>
                            </div>
                            <div class="mb-2">
                                <form action="{{ route('parts.index') }}" method="GET"
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

                                    {{-- Filter Customer --}}
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

                                    {{-- Filter Inv_id --}}
                                    <input type="text" name="inv_id" value="{{ request('inv_id') }}"
                                        class="form-control form-control-sm me-2" placeholder="Search by INV ID..."
                                        style="width: 200px;">

                                    {{-- Tombol --}}
                                    <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                                    <a href="{{ route('parts.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                                </form>

                            </div>
                        @endif
                        <div class="table-responsive animate__animated animate__fadeInUp">
                            <form class="form-inline col-lg-6">
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
                            </form>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
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
                                            <th>Inv ID</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <th>Category</th>
                                            <th>Customer</th>
                                            <th>Source</th>
                                            <th>Package</th>
                                            <th>Qty/Box</th>
                                            <th>Plant</th>
                                            <th>Area</th>
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
                                                <td>{{ $part->Inv_id }}</td>
                                                <td>{{ $part->Part_name }}</td>
                                                <td>{{ $part->Part_number }}</td>
                                                <td>{{ $part->category->name ?? '-' }}</td>
                                                <td>{{ $part->customer->username ?? '-' }}</td>
                                                <td>{{ $part->subcont ?? '-' }}</td>
                                                <td>{{ $part->package->type_pkg ?? '-' }}</td>
                                                <td>{{ $part->package->qty ?? '-' }}</td>
                                                <td>{{ $part->plant->name ?? '-' }}</td>
                                                <td>{{ $part->area->nama_area ?? '-' }}</td>
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
                        <input type="hidden" name="redirect_to" value="index">
                        <div class="mb-2">
                            <label for="file" class="form-label">Upload Excel File</label>
                            <input type="file" name="file" class="form-control" id="file" required
                                accept=".xls,.xlsx">
                            <small class="text-danger">*Download Template Excel Import: <a
                                    href="{{ asset('file/format-import-part(system-sto).xlsx') }}" download><i
                                        class="bi bi-download"></i> klik di sini</a></small>
                        </div>
                        <small class="text-secondary ">
                            *Lihat referensi untuk Area & customer:
                            <a href="{{ asset('file/area_customer_kbi.xlsx') }}" download>
                                <i class="bi bi-download"></i> Reference
                            </a>
                        </small>
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
