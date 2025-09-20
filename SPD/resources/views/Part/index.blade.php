@extends('layouts.app')

@section('title', 'Data Parts ')

@section('content')
    <style>
        form label {
            font-size: 1.1rem;
            color: #495057;
        }

        form select {
            border: 2px solid #6c757d;
            font-size: 1rem;
            padding: 0.5rem;
            border-radius: 5px;
        }

        button i {
            margin-right: 5px;
        }

        .table img {
            max-width: 100px;
            /* Lebar maksimum gambar */
            max-height: 100px;
            /* Tinggi maksimum gambar */
            object-fit: cover;
            /* Agar gambar tidak terdistorsi */
            margin: 0 auto;
            /* Menempatkan gambar di tengah */
            display: block;
            /* Memastikan gambar menjadi blok */
        }
    </style>
    <div class="pagetitle">
        <h1>Data Part</h1>
        <nav>
            <ol class="breadcrumb">
                @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                @endif
                @if (Auth::check() && Auth::user()->role == 'viewer')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.viewer') }}">Home</a></li>
                @endif
                <li class="breadcrumb-item active ">Data Part</li>
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
            {{ session('error') }}
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('info') }}
        </div>
    @endif

    <!-- Blade Template with Edit Modal -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Part</h5>
                        <!-- Create and Import Buttons -->
                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'superAdmin']))
                            <div class="mb-3">
                                <a href="{{ route('parts.create') }}" class="btn btn-primary"><i class="bi bi-plus-square">
                                        Create New Part</i>
                                </a>
                                <button type="button" class="btn btn-success"
                                    data-bs-toggle="modal"data-bs-target="#importModal">
                                    <i class="bi bi-file-earmark-excel"></i> Import Excel
                                </button>
                            </div>
                            <form action="{{ route('parts.index') }}" method="GET" class="mb-3 d-flex align-items-center">
                                <label for="status" class="me-2 fw-bold">
                                    <i class="bi bi-filter"></i> Filter Status:
                                </label>
                                <select name="status" id="status" class="form-select w-auto"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif
                                    </option>
                                </select>
                            </form>
                        @endif
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">NO</th>
                                        <th scope="col" class="text-center">Part Number</th>
                                        <th scope="col" class="text-center">Part Name</th>
                                        <th scope="col" class="text-center">Customer Part Number</th>
                                        {{-- <th scope="col" class="text-center">Customer</th> --}}
                                        <th scope="col" class="text-center">Image Part</th>
                                        <th scope="col" class="text-center">Size Part</th>
                                        <th scope="col" class="text-center">Label Image</th>
                                        <th scope="col" class="text-center">Position Label</th>
                                        <th scope="col" class="text-center">Image Inner Packages</th>
                                        <th scope="col" class="text-center">Size Inner Packages</th>
                                        <th scope="col" class="text-center">Logo Inner Packages</th>
                                        <th scope="col" class="text-center">Label Inner Packages</th>
                                        <th scope="col" class="text-center">Type Inner Packages</th>
                                        <th scope="col" class="text-center">Qty Inner Packages</th>
                                        <th scope="col" class="text-center">Image Outer Packages</th>
                                        <th scope="col" class="text-center">Size Outer Packages</th>
                                        <th scope="col" class="text-center">Logo Outer Packages</th>
                                        <th scope="col" class="text-center">Label Outer Packages</th>
                                        <th scope="col" class="text-center">Type Outer Packages</th>
                                        <th scope="col" class="text-center">Qty Outer Packages</th>
                                        @if (Auth::check() && Auth::user()->role == 'admin')
                                            <th scope="col" class="text-center">Aksi</th>
                                        @endif
                                        @if (Auth::check() && Auth::user()->role == 'viewer')
                                            <th scope="col" class="text-center">Status Part</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parts as $part)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $part->P_No }}</td>
                                            <td class="text-center">{{ $part->P_Name }}</td>
                                            <td class="text-center">{{ $part->cust_part_no }}</td>
                                            {{-- <td class="text-center">{{ $part->customer->name ?? 'Customer Tidak Ditemukan' }}</td> --}}
                                            <td class="text-center">
                                                <img src="{{ asset($part->img_p) }}" alt="Tidak Tersedia"
                                                    class="img-thumbnail" style="max-width: 150px; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset($part->img_p) }}')">
                                            </td>

                                            <td class="text-center">{{ $part->size }} mm</td>
                                            <td class="text-center">
                                                <img src="{{ asset($part->lbl_img) }}" alt="Tidak Tersedia"
                                                    class="img-thumbnail" style="max-width: 150px; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset($part->lbl_img) }}')">
                                            </td>
                                            <td class="text-center"><img src="{{ asset($part->pos_label) }}"
                                                    alt="Tidak Tersedia" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset($part->pos_label) }}')">
                                            </td>

                                            <td class="text-center">
                                                <img src="{{ asset($part->innerPart->Image_ip) }}" alt="Tidak Tersedia"
                                                    class="img-thumbnail" style="max-width: 150px; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset($part->innerPart->Image_ip) }}')">
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->innerPart->size_ip }} mm
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->innerPart->logo_ip }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->innerPart->label_ip }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->innerPart->type_ip }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->innerPart->Qty_ip }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>

                                            {{-- OUTERPKG --}}
                                            <td class="text-center">
                                                <img src="{{ asset($part->outerPart->Image_op) }}" alt="Tidak Tersedia"
                                                    class="img-thumbnail" style="max-width: 150px; cursor: pointer;"
                                                    onclick="showImageModal('{{ asset($part->outerPart->Image_op) }}')">
                                                @if (!$loop->last)
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                {{ $part->outerPart->size_op }} mm
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->outerPart->logo_op }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->outerPart->label_op }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->outerPart->type_op }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $part->outerPart->Qty_op }}
                                                @if (!$loop->last)
                                                @endif
                                            </td>
                                            @if (Auth::check() && Auth::user()->role == 'viewer')
                                                @if ($part->status)
                                                    <td class="text-center">
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Nonaktif</span>
                                                @endif
                                                </td>
                                            @endif
                                            @if (Auth::check() && Auth::user()->role == 'admin')
                                                <td class="text-center">
                                                    <!-- Edit Button (Images Only) -->
                                                    <button type="button"
                                                        class="btn btn-warning btn-sm ms-1 mt-1 shadow-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editImagesModal{{ $part->id }}">
                                                        <i class="bi bi-file-earmark-image-fill"></i> Edit Images
                                                    </button>

                                                    <!-- Edit Button (All Data) -->
                                                    <a class="btn btn-primary btn-sm ms-1 mt-1 shadow-sm"
                                                        href="{{ route('parts.edit', ['id' => $part->id]) }}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    @if ($part->status)
                                                        <button class="btn btn-success btn-sm ms-1 mt-1 shadow-sm"
                                                            onclick="changeStatus({{ $part->id }}, 0)"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Klik untuk Aktifkan">
                                                            <i class="bi bi-check-circle"></i> Aktif
                                                        </button>
                                                    @else
                                                        <button class="btn btn-danger btn-sm ms-1 mt-1 shadow-sm"
                                                            onclick="changeStatus({{ $part->id }}, 1)"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Klik untuk Nonaktifkan">
                                                            <i class="bi bi-x-circle"></i> Nonaktif
                                                        </button>
                                                    @endif

                                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                    <script>
                                                        function changeStatus(partId, status) {
                                                            // Konfirmasi menggunakan SweetAlert2
                                                            Swal.fire({
                                                                title: 'Apakah Anda yakin?',
                                                                text: status === 0 ? "Status akan diubah menjadi Nonaktif!" : "Status akan diubah menjadi Aktif!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: status === 1 ? '#d33' : '#28a745',
                                                                cancelButtonColor: '#6c757d',
                                                                confirmButtonText: 'Ya, Ubah',
                                                                cancelButtonText: 'Batal'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    // Lakukan permintaan AJAX
                                                                    fetch(`/parts/${partId}/change-status`, {
                                                                            method: 'POST',
                                                                            headers: {
                                                                                'Content-Type': 'application/json',
                                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                            },
                                                                            body: JSON.stringify({
                                                                                status
                                                                            })
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            if (data.success) {
                                                                                // Alert berhasil
                                                                                Swal.fire({
                                                                                    title: 'Berhasil!',
                                                                                    text: data.message,
                                                                                    icon: 'success',
                                                                                    confirmButtonColor: '#28a745',
                                                                                    confirmButtonText: 'OK'
                                                                                }).then(() => {
                                                                                    location.reload();
                                                                                });
                                                                            } else {
                                                                                // Alert gagal
                                                                                Swal.fire({
                                                                                    title: 'Gagal!',
                                                                                    text: data.message,
                                                                                    icon: 'error',
                                                                                    confirmButtonColor: '#d33',
                                                                                    confirmButtonText: 'OK'
                                                                                });
                                                                            }
                                                                        })
                                                                        .catch(error => {
                                                                            Swal.fire({
                                                                                title: 'Error!',
                                                                                text: 'Terjadi kesalahan saat memproses permintaan.',
                                                                                icon: 'error',
                                                                                confirmButtonColor: '#d33',
                                                                                confirmButtonText: 'OK'
                                                                            });
                                                                            console.error('Error:', error);
                                                                        });
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                </td>
                                            @endif
                                        </tr>
                                        <!-- Modal for displaying the image -->
                                        <div class="modal fade" id="imageModal" tabindex="-1"
                                            aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img id="modalImage" src="" alt="Preview Image"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Images Modal -->
                                        <div class="modal fade" id="editImagesModal{{ $part->id }}" tabindex="-1"
                                            aria-labelledby="editImagesLabel{{ $part->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content col-md-6">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editImagesLabel{{ $part->id }}">
                                                            Edit Gambar untuk {{ $part->P_Name }} | {{ $part->P_No }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('parts.updateImages', $part->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <!-- Part Image -->
                                                            <div class="mb-3">
                                                                <label for="img_p" class="form-label">Part
                                                                    Image</label>
                                                                <input type="file" name="img_p"
                                                                    class="form-control">
                                                                @if ($part->img_p)
                                                                    <img src="{{ asset($part->img_p) }}"
                                                                        alt="Tidak Tersedia" class="img-thumbnail mt-2"
                                                                        width="150">
                                                                @endif
                                                                @error('img_p')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Label Image -->
                                                            <div class="mb-3">
                                                                <label for="lbl_img" class="form-label">Label
                                                                    Image</label>
                                                                <input type="file" name="lbl_img"
                                                                    class="form-control">
                                                                @if ($part->lbl_img)
                                                                    <img src="{{ asset($part->lbl_img) }}"
                                                                        alt="Tidak Tersedia" class="img-thumbnail mt-2"
                                                                        width="150">
                                                                @endif
                                                                @error('lbl_img')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Position Label Image -->
                                                            <div class="mb-3">
                                                                <label for="pos_label" class="form-label">Position Label
                                                                    Image</label>
                                                                <input type="file" name="pos_label"
                                                                    class="form-control">
                                                                @if ($part->pos_label)
                                                                    <img src="{{ asset($part->pos_label) }}"
                                                                        alt="Tidak Tersedia" class="img-thumbnail mt-2"
                                                                        width="150">
                                                                @endif
                                                                @error('pos_label')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Inner Package Image -->
                                                            <div class="mb-3">
                                                                <label for="Image_Ip" class="form-label">Inner Package
                                                                    Image</label>
                                                                <input type="file" name="Image_ip"
                                                                    class="form-control">
                                                                @if ($part->innerPart->Image_ip)
                                                                    <img src="{{ asset($part->innerPart->Image_ip) }}"
                                                                        alt="Tidak Tersedia" class="img-thumbnail mt-2"
                                                                        width="150">
                                                                @endif
                                                                @error('Image_Ip')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Outer Package Image -->
                                                            <div class="mb-3">
                                                                <label for="Image_Op" class="form-label">Outer Package
                                                                    Image</label>
                                                                <input type="file" name="Image_op"
                                                                    class="form-control">
                                                                @if ($part->OuterPart->Image_op)
                                                                    <img src="{{ asset($part->OuterPart->Image_op) }}"
                                                                        alt="Tidak Tersedia" class="img-thumbnail mt-2"
                                                                        width="150">
                                                                @endif
                                                                @error('Image_Op')
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <button type="submit" class="btn btn-primary">Save
                                                                Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal import excel --}}
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
        {{-- end --}}
    </section>
    <script>
        function showImageModal(imageSrc) {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {
                keyboard: true
            });
            imageModal.show();
        }
    </script>

@endsection
-
