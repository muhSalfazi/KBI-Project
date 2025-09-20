@extends('layouts.app')

@section('title', 'Data Orders')

@section('content')
    <div class="pagetitle">
        <h1>Data Orders</h1>
        <nav>
            <ol class="breadcrumb">
                @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'viewer')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.viewer') }}">Home</a></li>
                @endif
                <li class="breadcrumb-item active">Data Orders</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
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
            {{-- start filter date --}}
            @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                <form method="GET" action="{{ route('orders.index') }}">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control" onclick="encryptParams()"><i
                                    class="bi bi-filter-square"></i>&nbsp;Filter</button>
                        </div>
                    </div>
                </form>
            @endif
            @if (Auth::check() && Auth::user()->role == 'viewer')
                <form method="GET" action="{{ route('orders.index.viewer') }}">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control" onclick="encryptParams()"><i
                                    class="bi bi-filter-square"></i>&nbsp;Filter</button>

                        </div>
                    </div>
                </form>
            @endif
            @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                <script>
                    function encryptParams() {
                        let startDate = document.getElementById('start_date').value;
                        let endDate = document.getElementById('end_date').value;

                        if (startDate && endDate) {
                            // Enkripsi menggunakan Laravel
                            fetch('/encrypt', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        start_date: startDate,
                                        end_date: endDate
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.encrypted_start_date && data.encrypted_end_date) {
                                        const urlParams = new URLSearchParams(window.location.search);
                                        urlParams.set('start_date', data.encrypted_start_date);
                                        urlParams.set('end_date', data.encrypted_end_date);
                                        window.location.search = urlParams.toString();
                                    }
                                });
                        }
                    }
                </script>
            @endif
            {{-- viewer --}}
            @if (Auth::check() && Auth::user()->role == 'viewer')
                <script>
                    function encryptParams() {
                        let startDate = document.getElementById('start_date').value;
                        let endDate = document.getElementById('end_date').value;

                        if (startDate && endDate) {
                            // Enkripsi menggunakan Laravel
                            fetch('/view', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        start_date: startDate,
                                        end_date: endDate
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.encrypted_start_date && data.encrypted_end_date) {
                                        const urlParams = new URLSearchParams(window.location.search);
                                        urlParams.set('start_date', data.encrypted_start_date);
                                        urlParams.set('end_date', data.encrypted_end_date);
                                        window.location.search = urlParams.toString();
                                    }
                                });
                        }
                    }
                </script>
            @endif
            {{-- end filter date --}}
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Orders</h5>
                        {{-- filter status admin --}}
                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                            <form action="{{ route('orders.index') }}" method="GET"
                                class="mb-3 d-flex align-items-center">
                                <label for="status" class="me-2 fw-bold">
                                    <i class="bi bi-filter"></i> Filter Status:
                                </label>
                                <select name="status" id="status" class="form-select w-auto"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>
                                        Canceled</option>
                                </select>
                            </form>
                        @endif
                        {{-- filter status viewer --}}
                        @if (Auth::check() && Auth::user()->role == 'viewer')
                        <form action="{{ route('orders.index.viewer') }}" method="GET" class="mb-3 d-flex align-items-center">
                            <label for="status" class="me-2 fw-bold">
                                <i class="bi bi-filter"></i> Filter Status:
                            </label>
                            <select name="status" id="status" class="form-select w-auto" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </form>
                        @endif
                        <div class="mb-3">
                            @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-square"></i> Create New Order
                                </a>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bi bi-file-earmark-excel"></i> Import Excel
                                </button>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">NO</th>
                                        <th scope="col" class="text-center">Purchase Order</th>
                                        <th scope="col" class="text-center">Customer Part Number</th>
                                        <th scope="col" class="text-center">Customer</th>
                                        <th scope="col" class="text-center">Part Number</th>
                                        <th scope="col" class="text-center">Part Name</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col" class="text-center">Delivery Date</th>
                                        <th scope="col" class="text-center">Cancel Date</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        @if (Auth::check() && Auth::user()->role == 'admin')
                                            <th scope="col" class="text-center">Aksi</th>
                                        @endif
                                        @if (Auth::check() && Auth::user()->role == 'viewer')
                                            <th scope="col" class="text-center">Status Order</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $order->P_order }}</td>
                                            <td>{{ $order->P_no_cus }}</td>
                                            <td>{{ $order->customer->username ?? 'N/A' }}</td>
                                            <td>{{ $order->part->P_No ?? 'N/A' }}</td>
                                            <td>{{ $order->part->P_Name ?? 'N/A' }}</td>
                                            <td>{{ $order->Qty }}</td>
                                            <td class="text-center">
                                                @if ($order->delivery_date)
                                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                                @else
                                                    {{ $order->status ? $order->status : 'N/A' }}
                                                    <!-- Display status if ETA_WH_NEW is null -->
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($order->deleted_at)
                                                    {{ \Carbon\Carbon::parse($order->deleted_at)->format('d M Y') }}
                                                @else
                                                    {{ '-' }}
                                                    <!-- Display status if ETA_WH_NEW is null -->
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $order->catatan ?? 'tidak ada' }}
                                            </td>
                                            @if (Auth::check() && Auth::user()->role == 'admin')
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#updateQtyModal"
                                                        data-orderid="{{ $order->id }}"
                                                        data-qty="{{ $order->Qty }}"
                                                        onclick="openUpdateQtyModal(this)">
                                                        <i class="bi bi-pencil-square">Edit</i>
                                                    </button>
                                                    @if ($order->trashed())
                                                        <form action="{{ route('orders.toggleStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm  ms-1 mt-1 shadow-sm">
                                                                <i class="bi bi-arrow-clockwise"></i> Aktifkan
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('orders.toggleStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm  ms-1 mt-1 shadow-sm">
                                                                <i class="bi bi-x-circle"></i> Batalkan
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            @endif
                                            <!--role viewer-->
                                            @if (Auth::check() && Auth::user()->role == 'viewer')
                                                <td class="text-center">
                                                    @if ($order->status === 'canceled')
                                                        <span class="badge bg-danger">Cancel</span>
                                                    @elseif ($order->status === 'open')
                                                        <span class="badge bg-success">Open</span>
                                                    @else
                                                        <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Orders from Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload Excel File</label>
                                <input type="file" name="file" class="form-control" id="file" required
                                    accept=".xls,.xlsx">
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

        <!-- Update Quantity + ETA WH New Modal -->
        <div class="modal fade" id="updateQtyModal" tabindex="-1" aria-labelledby="updateQtyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateQtyModalLabel">Update Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateQtyForm" action="{{ route('orders.update.qty') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_id" id="order_id">
                            <div class="mb-3">
                                <label for="qty" class="form-label">Quantity</label>
                                <input type="number" name="qty" id="qty" class="form-control" required
                                    min="1">
                            </div>
                            <div class="mb-3">
                                <label for="eta_wh_new" class="form-label">Delivery Date</label>
                                <input type="date" name="eta_wh_new" id="eta_wh_new" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" name="catatan" id="catatan" placeholder="max 20 karakter" style="height: 100px;">{{ old('catatan') }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                        <script>
                            function openUpdateQtyModal(button) {
                                const orderId = button.getAttribute('data-orderid');
                                const qty = button.getAttribute('data-qty');
                                const etaWhNew = button.getAttribute('data-etawhnew') || ''; // Defaultnya string kosong jika tidak disetel
                                const catatan = button.getAttribute('data-catatan') || ''; // Defaultnya string kosong jika tidak disetel

                                document.getElementById('order_id').value = orderId;
                                document.getElementById('qty').value = qty;
                                document.getElementById('eta_wh_new').value = etaWhNew; // Tetapkan nilai tanggal
                                document.getElementById('catatan').value = catatan; // Tetapkan nilai catatan
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>




    @endsection
