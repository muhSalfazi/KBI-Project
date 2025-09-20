    @extends('layouts.app')

    @section('title', 'Data Tables')

    @section('content')
        <div class="pagetitle">
            <h1>Update Part KBI</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('parts.index') }}">Part</a></li>
                    <li class="breadcrumb-item active">Update Part</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Update Part</h5>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- Custom Styled Validation -->
                    <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('parts.update', $part->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="P_Name" class="form-label">Part Name</label>
                            <input type="text" name="P_Name" class="form-control @error('P_Name') is-invalid @enderror"
                                id="P_Name" value="{{ old('P_Name', $part->P_Name) }}">
                            @error('P_Name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="P_No" class="form-label">Part Number</label>
                            <input type="text" name="P_No" class="form-control @error('P_No') is-invalid @enderror"
                                id="P_No" value="{{ old('P_No', $part->P_No) }}">
                            @error('P_No')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cust_part_no" class="form-label">Customer Part Number</label>
                            <input type="text" name="cust_part_no"
                                class="form-control @error('cust_part_no') is-invalid @enderror" id="cust_part_no"
                                value="{{ old('cust_part_no', $part->cust_part_no) }}">
                            @error('cust_part_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Size Part</label>
                            <div class="d-flex gap-2">
                                <input type="text" name="size_length"
                                    class="form-control @error('size_length') is-invalid @enderror" placeholder="Length (mm)"
                                    value="{{ old('size_length', $part->size_length ?? '') }}">
                                <input type="text" name="size_width"
                                    class="form-control @error('size_width') is-invalid @enderror" placeholder="Width (mm)"
                                    value="{{ old('size_width', $part->size_width ?? '') }}">
                                <input type="text" name="size_height"
                                    class="form-control @error('size_height') is-invalid @enderror" placeholder="Height (mm)"
                                    value="{{ old('size_height', $part->size_height ?? '') }}">
                            </div>
                            @error('size_length')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('size_width')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('size_height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Inner Packaging -->
                        <ul class="sidebar-nav mt-2" id="sidebar-nav">
                            <li class="nav-heading">INNER PACKAGING</li>
                        </ul>
                        <div class="col-md-6">
                            <label for="label_ip" class="form-label">Label Name</label>
                            <input type="text" name="label_ip" class="form-control @error('label_ip') is-invalid @enderror"
                                id="label_ip" value="{{ old('label_ip', $part->innerPart->label_ip) }}">
                            @error('label_ip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="logo_ip" class="form-label">Logo Name</label>
                            <input type="text" name="logo_ip" class="form-control @error('logo_ip') is-invalid @enderror"
                                id="logo_ip" value="{{ old('logo_ip', $part->innerPart->logo_ip) }}">
                            @error('logo_ip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="size_ip_length" class="form-label">Length</label>
                                    <input type="text" class="form-control" id="size_ip_length" name="size_ip_length"
                                        value="{{ old('size_ip_length', $part->size_ip_length) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="size_ip_width" class="form-label">Width</label>
                                    <input type="text" class="form-control" id="size_ip_width" name="size_ip_width"
                                        value="{{ old('size_ip_width', $part->size_ip_width) }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="size_ip_height" class="form-label">Height</label>
                                    <input type="text" class="form-control" id="size_ip_height" name="size_ip_height"
                                        value="{{ old('size_ip_height', $part->size_ip_height) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="type_ip" class="form-label">Type</label>
                            <select name="type_ip" class="form-select @error('type_ip') is-invalid @enderror"
                                id="type_ip">
                                <option value="pcs" {{ old('type_ip', $part->innerPart->type_ip) == 'pcs' ? 'selected' : '' }}>Pcs
                                </option>
                                <option value="pack" {{ old('type_ip', $part->innerPart->type_ip) == 'pack' ? 'selected' : '' }}>Pack
                                </option>
                            </select>
                            @error('type_ip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="Qty_ip" class="form-label">Qty</label>
                            <input type="number" name="Qty_ip" class="form-control @error('Qty_ip') is-invalid @enderror"
                                id="Qty_ip" value="{{ old('Qty_ip', $part->innerPart->Qty_ip) }}">
                            @error('Qty_ip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Outer Packaging -->
                        <ul class="sidebar-nav mt-2" id="sidebar-nav">
                            <li class="nav-heading">OUTER PACKAGING</li>
                        </ul>
                        <div class="col-md-6">
                            <label for="label_op" class="form-label">Label Name</label>
                            <input type="text" name="label_op" class="form-control @error('label_op') is-invalid @enderror"
                                id="label_op" value="{{ old('label_op', $part->outerPart->label_op) }}">
                            @error('label_op')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="logo_op" class="form-label">Logo Name</label>
                            <input type="text" name="logo_op" class="form-control @error('logo_op') is-invalid @enderror"
                                id="logo_op" value="{{ old('logo_op', $part->outerPart->logo_op) }}">
                            @error('logo_op')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="size_op" class="form-label">Outer Package Size</label>
                            <div class="d-flex gap-2">
                                <input type="text" name="size_op_length"
                                value="{{ old('size_op_length', $part->size_op_length ?? '') }}"
                                class="form-control">
                         <input type="text" name="size_op_width"
                                value="{{ old('size_op_width', $part->size_op_width ?? '') }}"
                                class="form-control">
                         <input type="text" name="size_op_height"
                                value="{{ old('size_op_height', $part->size_op_height ?? '') }}"
                                class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="type_op" class="form-label">Type</label>
                            <select name="type_op" class="form-select @error('type_op') is-invalid @enderror"
                                id="type_op">
                                <option value="pcs" {{ old('type_op', $part->outerPart->type_op) == 'pcs' ? 'selected' : '' }}>Pcs
                                </option>
                                <option value="pack" {{ old('type_op', $part->outerPart->type_op) == 'pack' ? 'selected' : '' }}>Pack
                                </option>
                                <option value="box" {{ old('type_op', $part->outerPart->type_op) == 'box' ? 'selected' : '' }}>Box
                                </option>
                            </select>
                            @error('type_op')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="Qty_op" class="form-label">Qty</label>
                            <input type="number" name="Qty_op" class="form-control @error('Qty_op') is-invalid @enderror"
                                id="Qty_op" value="{{ old('Qty_op', $part->outerPart->Qty_op) }}">
                            @error('Qty_op')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Update Part</button>
                        </div>
                    </form><!-- End Custom Styled Validation -->
                </div>
            </div>
        </section>
    @endsection
