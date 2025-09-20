@extends('layouts.app')

@section('title', 'Create Part')

@section('content')
    <div class="pagetitle">
        <h1>Created Part KBI</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('parts.index') }}">Part</a></li>
                <li class="breadcrumb-item active">Created Part</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Created Part</h5>

                <!-- Custom Styled Validation -->
                <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data" method="POST"
                    action="{{ route('parts.store') }}">
                    @csrf

                    <div class="col-md-12">
                        <label for="P_Name" class="form-label">Part Name</label>
                        <input type="text" name="P_Name" class="form-control @error('P_Name') is-invalid @enderror"
                            id="P_Name" value="{{ old('P_Name') }}" required>
                        @error('P_Name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="P_No" class="form-label">Part Number</label>
                        <input type="text" name="P_No" class="form-control @error('P_No') is-invalid @enderror"
                            id="P_No" value="{{ old('P_No') }}" required>
                        @error('P_No')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="cust_part_no" class="form-label">Customer Part Number</label>
                        <input type="text" name="cust_part_no"
                            class="form-control @error('cust_part_no') is-invalid @enderror" id="cust_part_no"
                            value="{{ old('cust_part_no') }}"value="{{ old('cus_part_no') }}" required>
                        @error('cust_part_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </div>
                </form><!-- End Custom Styled Validation -->
            </div>
        </div>
    </section>
@endsection
