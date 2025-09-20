@extends('layouts.app')

@section('title', 'Create Order KBI')

@section('content')
    <div class="pagetitle">
        <h1>Create Order KBI</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Data Order</a></li>
                <li class="breadcrumb-item active">Create Part</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create Order</h5>

                <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data" method="POST"
                    action="{{ route('orders.store') }}">
                    @csrf
                    <!-- Hidden Input untuk Id_part -->
                    <input type="hidden" id="id_part" name="id_part" value="">

                    <div class="col-md-6">
                        <label for="P_No" class="form-label">Part Number</label>
                        <select id="P_No" name="P_No" class="form-control @error('id_part') is-invalid @enderror"
                            required>
                            <option value="">Select a part</option>
                            @foreach ($parts as $part)
                                <option value="{{ $part->cust_part_no }}" data-part-id="{{ $part->id }}">
                                    {{ $part->cust_part_no }} - {{ $part->P_No }} - {{ $part->P_Name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_part')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('P_No').addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            document.getElementById('id_part').value = selectedOption.getAttribute('data-part-id');
                        });
                    </script>


                    <div class="col-md-6">
                        <label for="P_order" class="form-label">Purchase Order</label>
                        <input type="number" name="P_order" class="form-control @error('P_order') is-invalid @enderror"
                            value="{{ old('P_order') }}" required>
                        @error('P_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @php
                    $customers = App\Models\Customer::all();
                @endphp

                <div class="col-md-6">
                    <label for="customer" class="form-label" onclick="openSelect2()">Customer</label>

                    <select name="customer_id" class="form-select select2 @error('customer_id') is-invalid @enderror"
                        id="customer" required>
                        <option value="" disabled {{ old('customer_id') === null ? 'selected' : '' }}>Pilih
                            Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->username }}
                            </option>
                        @endforeach
                    </select>

                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
                    <div class="col-md-6">
                        <label for="Qty" class="form-label">Quantity</label>
                        <input type="number" name="Qty" class="form-control @error('Qty') is-invalid @enderror"
                            value="{{ old('Qty') }}" required>
                        @error('Qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ETA_WH_NEW" class="form-label">Delivery Date</label>
                        <input type="date" name="ETA_WH_NEW"
                            class="form-control @error('ETA_WH_NEW') is-invalid @enderror" value="{{ old('ETA_WH_NEW') }}" required>
                        @error('ETA_WH_NEW')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="catatan" class="form-label">Catatan <span
                                style="font-size: 8px; font-weight: bold;color:red;">(opsional)</span></label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="floatingTextarea"
                            placeholder="max 20 karakter" style="height: 100px;">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Include jQuery and Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#P_No').select2({
                placeholder: "cust part number | Part Number | Part Name  ",
                allowClear: true
            });

            // Set Id_part based on selected option
            $('#P_No').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var idPart = selectedOption.data('part-id');
                $('#id_part').val(idPart);
            });
        });
    </script>
     <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#customer').select2({
                placeholder: 'Pilih Customer',
                allowClear: true
            });
        });

        function openSelect2() {
            $('#customer').select2('open'); // Open the Select2 dropdown when label is clicked
        }
    </script>
@endsection
