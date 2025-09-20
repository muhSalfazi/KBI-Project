@extends('layouts.app')

@section('title', 'Data Delivery')

@section('content')
    <div class="pagetitle">
        <h1>Data Delivery</h1>
        <nav>
            <ol class="breadcrumb">
                @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'viewer')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.viewer') }}">Home</a></li>
                @endif
                <li class="breadcrumb-item active">Data Delivery</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
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

            {{-- start filter date --}}
            @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                <form method="GET" action="{{ route('admin.delivery') }}">
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
                <form method="GET" action="{{ route('viewer.delivery') }}">
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
                        <h5 class="card-title">Data Delivery</h5>
                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                            <a href="{{ route('export.deliveries', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                                class="btn btn-success mb-2">
                                <i class="bi bi-file-earmark-excel"></i> Export to Excel
                            </a>
                        @endif
                        {{-- filter status admin --}}
                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                            <form action="{{ route('admin.delivery') }}" method="GET"
                                class="mb-3 d-flex align-items-center">
                                <label for="status" class="me-2 fw-bold">
                                    <i class="bi bi-filter"></i> Filter Status:
                                </label>
                                <select name="status" id="status" class="form-select w-auto"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="Belum Siap" {{ request('status') == 'Belum Siap' ? 'selected' : '' }}>
                                        Belum Siap
                                    </option>
                                    <option value="Dalam Proses"
                                        {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses
                                    </option>
                                    <option value="Close" {{ request('status') == 'Close' ? 'selected' : '' }}>Close
                                    </option>
                                    <option value="Delay" {{ request('status') == 'Delay' ? 'selected' : '' }}>
                                        Delay</option>
                                    <option value="Late Delivery"
                                        {{ request('status') == 'Late Delivery' ? 'selected' : '' }}>
                                        Late Delivery</option>
                                </select>
                            </form>
                        @endif
                        {{-- filter status viewer --}}
                        @if (Auth::check() && Auth::user()->role == 'viewer')
                            <form action="{{ route('viewer.delivery') }}" method="GET"
                                class="mb-3 d-flex align-items-center">
                                <label for="status" class="me-2 fw-bold">
                                    <i class="bi bi-filter"></i> Filter Status:
                                </label>
                                <select name="status" id="status" class="form-select w-auto"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="Belum Siap" {{ request('status') == 'Belum Siap' ? 'selected' : '' }}>
                                        Belum Siap
                                    </option>
                                    <option value="Dalam Proses"
                                        {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses
                                    </option>
                                    <option value="Close" {{ request('status') == 'Close' ? 'selected' : '' }}>Close
                                    </option>
                                    <option value="Delay" {{ request('status') == 'Delay' ? 'selected' : '' }}>
                                        Delay</option>
                                    <option value="Late Delivery"
                                        {{ request('status') == 'Late Delivery' ? 'selected' : '' }}>
                                        Late Delivery</option>
                                </select>
                            </form>
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
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Prepared</th>
                                        <th scope="col" class="text-center">Outstanding</th>
                                        <th scope="col" class="text-center">Delivery Date</th>
                                        <th scope="col" class="text-center">Overdue (Days)</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deliveries as $delivery)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $delivery->PO }}</td>
                                            <td class="text-center">{{ $delivery->customer_part_number }}</td>
                                            <td class="text-center">{{ $delivery->customer }}</td>
                                            <td class="text-center">{{ $delivery->part_number }}</td>
                                            <td class="text-center">{{ $delivery->part_name }}</td>
                                            <td class="text-center">{{ $delivery->qty }}</td>
                                            <td class="text-center">{{ $delivery->prepared }}</td>
                                            <td class="text-center">{{ $delivery->outstanding }}</td>
                                            <td class="text-center">{{ $delivery->delivery_date }}</td>
                                            <td class="text-center"
                                                style="color: {{ $delivery->overdue > 0 ? 'orange' : 'green' }};">
                                                {{ $delivery->overdue > 0 ? '-' . $delivery->overdue : '0' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($delivery->status == 'Belum Siap')
                                                    <span class="badge bg-secondary">{{ $delivery->status }}</span>
                                                @elseif ($delivery->status == 'Dalam Proses')
                                                    <span
                                                        class="badge bg-warning text-dark">{{ $delivery->status }}</span>
                                                @elseif ($delivery->status == 'Close')
                                                    <span class="badge bg-success">{{ $delivery->status }}</span>
                                                @elseif ($delivery->status == 'Delay')
                                                    <span class="badge bg-danger">{{ $delivery->status }}</span>
                                                @elseif($delivery->status == 'Late Delivery')
                                                    <span class="badge bg-warning">{{ $delivery->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
