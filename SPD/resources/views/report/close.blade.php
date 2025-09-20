@extends('layouts.app')

@section('title', 'Data Delivery Closed')

@section('content')
    <div class="pagetitle">
        <h1>Data Delivery Closed</h1>
        <nav>
            <ol class="breadcrumb">
                @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'viewer')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.viewer') }}">Home</a></li>
                @endif
                <li class="breadcrumb-item active">Data Close Delivery</li>
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
                <form method="GET" action="{{ route('report.closed') }}">
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
                <form method="GET" action="{{ route('report.closed.viewer') }}">
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
                        <h5 class="card-title">Data Delivery Closed</h5>
                        <div class="table-responsive">
                            {{-- filter status admin --}}
                            @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                                <form action="{{ route('report.closed') }}" method="GET"
                                    class="mb-3 d-flex align-items-center">
                                    <label for="status" class="me-2 fw-bold">
                                        <i class="bi bi-filter"></i> Filter Status:
                                    </label>
                                    <select name="status" id="status" class="form-select w-auto"
                                        onchange="this.form.submit()">
                                        <option value="">Semua Status</option>
                                        <option value="Late Delivery"
                                            {{ request('status') == 'Late Delivery' ? 'selected' : '' }}>Late Delivery
                                        </option>
                                        <option value="ontime" {{ request('status') == 'ontime' ? 'selected' : '' }}>
                                            on-time
                                        </option>
                                    </select>
                                </form>
                            @endif
                            {{-- filter status viewer --}}
                            @if (Auth::check() && Auth::user()->role == 'viewer')
                                <form action="{{ route('report.closed.viewer') }}" method="GET"
                                    class="mb-3 d-flex align-items-center">
                                    <label for="status" class="me-2 fw-bold">
                                        <i class="bi bi-filter"></i> Filter Status:
                                    </label>
                                    <select name="status" id="status" class="form-select w-auto"
                                        onchange="this.form.submit()">
                                        <option value="">Semua Status</option>
                                        <option value="Late Delivery"
                                            {{ request('status') == 'Late Delivery' ? 'selected' : '' }}>Late Delivery
                                        </option>
                                        <option value="ontime" {{ request('status') == 'ontime' ? 'selected' : '' }}>
                                            on-time
                                        </option>
                                    </select>
                                </form>
                            @endif
                            <table class="table table-striped table-bordered datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">NO</th>
                                        <th scope="col" class="text-center">Customer</th>
                                        <th scope="col" class="text-center">Purchase Order</th>
                                        <th scope="col" class="text-center">Customer Part Number</th>
                                        <th scope="col" class="text-center">Qty Close</th>
                                        <th scope="col" class="text-center">Delivery Date</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($closedBarang as $delivery)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                {{ $delivery->part && $delivery->customer ? $delivery->customer->username : 'Tidak Ada Customer' }}
                                            </td>
                                            <td class="text-center">{{ $delivery->P_order }}</td>
                                            <td class="text-center">{{ $delivery->P_no_cus }}</td>

                                            <td class="text-center">{{ $delivery->Qty }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($delivery->delivery_date)->format('d M Y') }}</td>

                                            <td class="text-center">
                                                @if ($delivery->delivery_date < $delivery->created_at)
                                                    <span class="badge bg-warning">Late Delivery</span>
                                                @else
                                                    <span class="badge bg-success">Closed</span>
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
    </section>
@endsection
