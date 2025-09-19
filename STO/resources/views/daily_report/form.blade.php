@extends('layouts.app_user')

@section('contents')
    <div class="container">
        <div class="card mt-4 shadow-lg">
            <div class="card-body p-4">
                <h5><strong>PT Kyoraku Blowmolding Indonesia</strong></h5>
                <p class="text-sm"><strong>PPIC Department / Warehouse Section</strong></p>
                <div class="text-center">
                    <h5>Inventory Card</h5>
                </div>
                {{-- Tampilkan error dan tombol edit jika ada --}}
                @if (session('errorSTO'))
                    <div class="alert alert-danger">
                        <audio id="errorSound" src="{{ asset('sounds/error.mp3') }}" preload="auto"></audio>

                        {{ session('errorSTO') }}
                        @if (session('edit_log_id'))
                            <a href="{{ route('sto.edit.log', session('edit_log_id')) }}"
                                class="btn btn-warning btn-sm ms-2">
                                Edit
                            </a>
                        @endif
                    </div>
                    <script>
                        function playErrorSound() {
                            const audio = document.getElementById('errorSound');
                            if (audio) {
                                audio.currentTime = 0;
                                audio.play().catch(e => console.log('Audio play failed:', e));
                            }
                        }
                        // Putar otomatis saat error muncul
                        document.addEventListener('DOMContentLoaded', function() {
                            playErrorSound();
                        });
                    </script>
                @endif
                <form class="w-100" method="POST" action="{{ route('sto.store', $inventory->id) }}" id="stoForm">
                    <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                    @csrf
                    <!-- Part Name -->
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Part Name</label>
                        <div class="col-md-9">
                            <input type="text" name="part_name" class="form-control" readonly
                                value="{{ old('part_name', $inventory->Part_name ?? '') }}">
                        </div>
                    </div>

                    <!-- Part Number -->
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Part Number</label>
                        <div class="col-md-9">
                            <input type="text" name="part_number" class="form-control" readonly
                                value="{{ old('part_number', $inventory->Part_number ?? '') }}">
                        </div>
                    </div>

                    <!-- Inventory Code -->
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label"><strong>Inventory Code</strong></label>
                        <div class="col-md-9">
                            <input type="hidden" name="id_inventory" value="{{ old('id_inventory', $inventory->id) }}">
                            <input type="text" name="inventory_id" class="form-control" readonly
                                value="{{ old('inventory_id', $inventory->Inv_id) }}">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Category</label>
                        <div class="col-md-9">
                            <input type="text" name="category" class="form-control" readonly
                                value="{{ old('category', $inventory->category->name ?? '') }}">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label">Status</label>
                        <div class="col-md-9">
                            <select name="status" class="form-select">
                                <option disabled>--Pilih--</option>
                                @foreach (['OK', 'NG', 'Virgin', 'Funsai'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('status', $inventory->status_product) == $s ? 'selected' : '' }}>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Quantity Inputs -->
                    <div class="mb-3 p-3 border rounded">
                        <h5 class="mb-3 text-center"><strong>QUANTITY INPUT</strong></h5>
                        <h6 class="col-12"><strong>ITEM COMPLETE </strong></h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Qty/Box</label>
                                <input type="number" name="qty_per_box" id="qty_per_box" class="form-control"
                                    value="{{ old('qty_per_box', $inventory->package->qty ?? '') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Qty Box</label>
                                <input type="number" name="qty_box" id="qty_box" class="form-control"
                                    value="{{ old('qty_box') }}"required>
                            </div>
                            <div class="col-md-3">
                                <label>Total</label>
                                <input type="number" name="total" id="total" class="form-control" readonly
                                    value="{{ old('total') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Grand Total</label>
                                <input type="number" name="grand_total" id="grand_total" class="form-control" readonly
                                    value="{{ old('grand_total') }}"required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary mt-3 col-md-12"
                            onclick="toggleOptionalQuantityInputs()">
                            SHOW UNCOMPLETE ITEM
                        </button>

                        <div id="optionalQuantityInputs" class="row mt-3" style="display: none;">
                            <h6 class="col-12"><strong>ITEM UNCOMPLETE</strong></h6>
                            <div class="col-md-3">
                                <label>Qty/Box</label>
                                <input type="number" name="qty_per_box_2" id="qty_per_box_2" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-3">
                                <label>Qty Box</label>
                                <input type="number" name="qty_box_2" id="qty_box_2" class="form-control"
                                    value="{{ old('qty_box_2') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Total</label>
                                <input type="number" name="total_2" id="total_2" class="form-control" readonly
                                    value="{{ old('total_2') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Dates & Metadata -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Issued Date</label>
                            <input type="date" name="issued_date" class="form-control" readonly
                                value="{{ old('issued_date', date('Y-m-d')) }}">
                        </div>
                        {{-- <div class="col-md-3 mb-3"> --}}
                        {{-- <label>Prepared By</label> --}}
                        <input type="hidden" name="prepared_by" value="{{ auth()->id() }}">
                        {{-- <input type="text" class="form-control" readonly value="{{ Auth::user()->username }}"> --}}
                        {{-- </div> --}}
                        <div class="col-md-4 mb-3">
                            <label>Lokasi STO</label>
                            <select name="plant_id" class="form-control select2-lokasi" required>
                                <!-- Default plant dari session login -->
                                <option value="{{ $sessionData['selected_plan_id'] }}" selected>
                                    {{ $sessionData['selected_plan_name'] }}
                                </option>

                                <!-- Plant lainnya -->
                                @foreach ($plants as $plant)
                                    @if ($plant->id != $sessionData['selected_plan_id'])
                                        <option value="{{ $plant->id }}">
                                            {{ $plant->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Area</label>
                            <select name="area_id" class="form-control select2-area" required>
                                <!-- Default area dari session login -->
                                <option value="{{ $sessionData['selected_area_id'] }}"
                                    data-plan="{{ $sessionData['selected_plan_id'] }}" selected>
                                    {{ $sessionData['selected_area_name'] }}
                                </option>

                                <!-- Area lainnya dari HeadArea -->
                                @foreach ($headAreas as $headArea)
                                    @if ($headArea->id != $sessionData['selected_area_id'])
                                        <option value="{{ $headArea->id }}" data-plan="{{ $headArea->id_plan }}">
                                            {{ $headArea->nama_area }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100" id="submitBtn">Submit</button>
                </form>
                <a href="{{ route('dailyreport.index') }}" class="btn btn-info mt-3 col-12">Back</a>
            </div>
        </div>
    </div>
    {{-- js box and plant-area filtering --}}
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Calculation functions
                function calculateTotals() {
                    let QtyPerBox2 = parseFloat(document.getElementById("qty_per_box_2").value) || 0;
                    let QtyBox2 = parseFloat(document.getElementById("qty_box_2").value) || 0;
                    let qtyPerBox = parseFloat(document.getElementById("qty_per_box").value) || 0;
                    let qtyBox = parseFloat(document.getElementById("qty_box").value) || 0;

                    // Calculate totals
                    let Total2 = QtyPerBox2 * QtyBox2;
                    let total = qtyPerBox * qtyBox;
                    let grandTotal = Total2 + total;

                    // Update the input fields
                    document.getElementById("total_2").value = Total2;
                    document.getElementById("total").value = total;
                    document.getElementById("grand_total").value = grandTotal;
                }

                // Attach event listeners to calculation inputs
                let inputs = document.querySelectorAll("#qty_per_box_2, #qty_box_2, #qty_per_box, #qty_box");
                inputs.forEach(input => {
                    input.addEventListener("input", calculateTotals);
                });

                // Plant-Area filtering logic
                $(document).ready(function() {
                    // Inisialisasi select2
                    $('.select2-lokasi, .select2-area').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });

                    // Data untuk filter
                    const plantAreas = @json($plantAreas);
                    const sessionData = @json($sessionData);
                    const headAreasData = @json($headAreas);
                    const loginAreaId = sessionData.selected_area_id;
                    const loginPlanId = sessionData.selected_plan_id;

                    console.log('Session Data:', sessionData);
                    console.log('Plant Areas mapping:', plantAreas);
                    console.log('Head Areas data:', headAreasData);
                    console.log('Login Area ID:', loginAreaId);
                    console.log('Login Plant ID:', loginPlanId);

                    // Fungsi filter area berdasarkan plant dengan rebuild options
                    function filterHeadAreas(plantId) {
                        const $areaSelect = $('.select2-area');

                        // Konversi ke integer untuk memastikan konsistensi
                        plantId = parseInt(plantId);

                        console.log('Filtering areas for plant ID:', plantId, typeof plantId);

                        // Destroy select2 terlebih dahulu
                        $areaSelect.select2('destroy');

                        // Clear all options
                        $areaSelect.empty();

                        let selectedAreaId = null;
                        let hasAddedAreas = false;

                        // Jika plant yang dipilih sama dengan plant login, prioritaskan area login
                        if (plantId == loginPlanId) {
                            $areaSelect.append(new Option(sessionData.selected_area_name, loginAreaId, true,
                                true));
                            selectedAreaId = loginAreaId;
                            hasAddedAreas = true;
                            console.log('Added login area for login plant');
                        }

                        // Tambahkan area lain yang sesuai dengan plant yang dipilih
                        headAreasData.forEach(function(headArea, index) {
                            console.log(`Checking area ${index}:`, {
                                id: headArea.id,
                                nama_area: headArea.nama_area,
                                id_plan: headArea.id_plan,
                                plantId: plantId,
                                match: parseInt(headArea.id_plan) == plantId
                            });

                            // Skip jika ini adalah area login dan sudah ditambahkan
                            if (headArea.id == loginAreaId && hasAddedAreas) {
                                console.log('Skipped login area (already added)');
                                return;
                            }

                            // Tambahkan area jika plant-nya cocok (gunakan == untuk konversi tipe)
                            if (parseInt(headArea.id_plan) == plantId) {
                                const isFirstArea = !hasAddedAreas;
                                $areaSelect.append(new Option(headArea.nama_area, headArea.id,
                                    isFirstArea, isFirstArea));

                                if (isFirstArea) {
                                    selectedAreaId = headArea.id;
                                }
                                hasAddedAreas = true;
                                console.log('Added area:', headArea.nama_area, 'for plant:', plantId,
                                    'area plant_id:', headArea.id_plan);
                            }
                        });

                        // Jika tidak ada area yang cocok, tambahkan area login sebagai fallback
                        if (!hasAddedAreas) {
                            $areaSelect.append(new Option(sessionData.selected_area_name, loginAreaId, true,
                                true));
                            selectedAreaId = loginAreaId;
                            console.log('Added login area as fallback');
                        }

                        // Reinitialize select2
                        $areaSelect.select2({
                            theme: 'bootstrap-5',
                            width: '100%'
                        });

                        console.log('Final selected area:', selectedAreaId);
                        console.log('Total areas added:', $areaSelect.find('option').length);
                    }

                    // Initial filter berdasarkan plant yang dipilih di awal
                    const initialPlantId = $('.select2-lokasi').val();
                    console.log('Initial plant ID:', initialPlantId);
                    filterHeadAreas(initialPlantId);

                    // Event ketika plant berubah
                    $('.select2-lokasi').on('change', function() {
                        const selectedPlantId = $(this).val();
                        console.log('Plant changed to:', selectedPlantId);
                        filterHeadAreas(selectedPlantId);
                    });
                });
            });

            // IndexedDB untuk penyimpanan lokal
            class OfflineStorage {
                constructor() {
                    this.DB_NAME = 'sto_kbi_offline';
                    this.DB_VERSION = 1;
                    this.STORE_NAME = 'offline_reports';
                    this.db = null;
                    this.initDB();
                }

                // Inisialisasi database
                initDB() {
                    return new Promise((resolve, reject) => {
                        if (this.db) {
                            resolve(this.db);
                            return;
                        }

                        const request = indexedDB.open(this.DB_NAME, this.DB_VERSION);

                        request.onerror = (event) => {
                            console.error('IndexedDB error:', event.target.errorCode);
                            reject('Tidak dapat membuka database offline');
                        };

                        request.onupgradeneeded = (event) => {
                            const db = event.target.result;
                            if (!db.objectStoreNames.contains(this.STORE_NAME)) {
                                db.createObjectStore(this.STORE_NAME, {
                                    keyPath: 'id',
                                    autoIncrement: true
                                });
                            }
                        };

                        request.onsuccess = (event) => {
                            this.db = event.target.result;
                            resolve(this.db);
                        };
                    });
                }

                // Simpan data report
                saveReport(inventoryId, formData) {
                    return new Promise((resolve, reject) => {
                        this.initDB().then((db) => {
                            const transaction = db.transaction([this.STORE_NAME], 'readwrite');
                            const store = transaction.objectStore(this.STORE_NAME);

                            // Buat objek data
                            const report = {
                                inventory_id: inventoryId,
                                form_data: formData,
                                timestamp: new Date().toISOString(),
                                status: 'pending'
                            };

                            const request = store.add(report);

                            request.onsuccess = () => {
                                resolve(report);
                            };

                            request.onerror = (event) => {
                                reject('Gagal menyimpan data offline');
                            };
                        }).catch(reject);
                    });
                }

                // Ambil semua data yang belum tersinkronisasi
                getPendingReports() {
                    return new Promise((resolve, reject) => {
                        this.initDB().then((db) => {
                            const transaction = db.transaction([this.STORE_NAME], 'readonly');
                            const store = transaction.objectStore(this.STORE_NAME);
                            const request = store.getAll();

                            request.onsuccess = (event) => {
                                const reports = event.target.result.filter(r => r.status === 'pending');
                                resolve(reports);
                            };

                            request.onerror = () => {
                                reject('Gagal mengambil data offline');
                            };
                        }).catch(reject);
                    });
                }

                // Update status laporan
                updateReportStatus(id, newStatus) {
                    return new Promise((resolve, reject) => {
                        this.initDB().then((db) => {
                            const transaction = db.transaction([this.STORE_NAME], 'readwrite');
                            const store = transaction.objectStore(this.STORE_NAME);

                            const getRequest = store.get(id);

                            getRequest.onsuccess = (event) => {
                                const report = event.target.result;
                                if (report) {
                                    report.status = newStatus;

                                    const updateRequest = store.put(report);
                                    updateRequest.onsuccess = () => resolve(report);
                                    updateRequest.onerror = () => reject('Gagal update status');
                                } else {
                                    reject('Laporan tidak ditemukan');
                                }
                            };

                            getRequest.onerror = () => {
                                reject('Gagal mengambil laporan');
                            };
                        }).catch(reject);
                    });
                }
            }

            // Inisialisasi storage
            const offlineStorage = new OfflineStorage();

            // Utilitias untuk network
            function checkNetworkSpeed(callback) {
                const startTime = new Date().getTime();
                const url = '/favicon.ico?rand=' + startTime;

                fetch(url, {
                        method: 'HEAD',
                        cache: 'no-store'
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response error');
                        const endTime = new Date().getTime();
                        const duration = endTime - startTime;
                        console.log('Network speed test: ' + duration + 'ms');

                        // Anggap koneksi lambat jika > 2000ms
                        const isSlowConnection = duration > 2000;
                        callback(isSlowConnection, duration);
                    })
                    .catch(error => {
                        console.error('Network test failed:', error);
                        // Jika gagal, anggap offline/koneksi sangat lambat
                        callback(true, 5000);
                    });
            }

            $(document).ready(function() {
                const stoForm = $('#stoForm');
                const submitBtn = $('#submitBtn');
                const inventoryId = $('input[name="inventory_id"]').val();

                // Buat ID unik untuk request
                const requestId = "{{ uniqid() }}";

                // Tambahkan hidden input untuk request ID
                stoForm.append('<input type="hidden" name="request_id" value="' + requestId + '">');

                // Override submit form
                stoForm.on('submit', function(e) {
                    e.preventDefault(); // Tahan submit normal

                    // Tampilkan loading overlay
                    $('body').append(
                        '<div id="loading-overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;display:flex;justify-content:center;align-items:center;">' +
                        '<div style="background:white;padding:20px;border-radius:5px;text-align:center;">' +
                        '<div class="spinner-border text-primary" role="status"></div>' +
                        '<h5 class="mt-2">Memeriksa koneksi...</h5>' +
                        '<p>Mohon tunggu sebentar.</p>' +
                        '</div></div>'
                    );

                    // Nonaktifkan tombol submit
                    submitBtn.prop('disabled', true);

                    // Kumpulkan data form
                    const formData = {};
                    const formElements = stoForm[0].elements;

                    for (let i = 0; i < formElements.length; i++) {
                        const element = formElements[i];
                        if (element.name && element.name !== '_method') {
                            formData[element.name] = element.value;
                        }
                    }

                    // Cek kecepatan koneksi
                    checkNetworkSpeed(function(isSlowConnection, duration) {
                        console.log('Connection is slow:', isSlowConnection, 'Speed:', duration + 'ms');

                        // Update loading message
                        $('#loading-overlay div').html(
                            `<h5>Koneksi ${isSlowConnection ? 'lambat' : 'baik'} terdeteksi</h5>` +
                            `<p>Kecepatan: ${duration}ms</p>` +
                            '<div id="loading-status" class="mt-2"></div>'
                        );

                        // Jika koneksi lambat atau offline, simpan lokal
                        if (isSlowConnection || !navigator.onLine) {
                            $('#loading-status').html(
                                '<div class="spinner-border spinner-border-sm text-warning" role="status"></div>' +
                                '<p>Menyimpan data secara lokal...</p>');

                            // Simpan ke local storage
                            offlineStorage.saveReport(inventoryId, formData)
                                .then(report => {
                                    console.log('Data tersimpan lokal:', report);

                                    // Update loading message
                                    $('#loading-overlay div').html(
                                        '<div class="text-success"><i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i></div>' +
                                        '<h5 class="text-success mt-2">Data tersimpan!</h5>' +
                                        '<p>Data telah disimpan secara lokal dan akan otomatis dikirim ke server saat koneksi membaik.</p>' +
                                        '<button id="go-to-index" class="btn btn-primary mt-2">Kembali ke Halaman Utama</button>'
                                    );

                                    // Tambah badge ke navbar brand
                                    updateOfflineIndicator();

                                    // Tambahkan event listener untuk tombol
                                    $('#go-to-index').on('click', function() {
                                        window.location.href =
                                            "{{ route('dailyreport.index') }}";
                                    });

                                    // Auto redirect setelah 3 detik
                                    setTimeout(function() {
                                        window.location.href =
                                            "{{ route('dailyreport.index') }}";
                                    }, 3000);
                                })
                                .catch(error => {
                                    console.error('Error saving offline data:', error);

                                    // Update loading message dengan error
                                    $('#loading-overlay div').html(
                                        '<div class="text-danger"><i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i></div>' +
                                        '<h5 class="text-danger mt-2">Gagal menyimpan!</h5>' +
                                        '<p>Terjadi kesalahan saat menyimpan data.</p>' +
                                        '<button id="try-again" class="btn btn-primary mt-2">Coba Lagi</button>'
                                    );

                                    // Reset form submit button
                                    submitBtn.prop('disabled', false);

                                    // Tambahkan event listener untuk tombol coba lagi
                                    $('#try-again').on('click', function() {
                                        $('#loading-overlay').remove();
                                    });
                                });
                        } else {
                            // Jika koneksi normal, lanjutkan dengan submit normal
                            $('#loading-status').html(
                                '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>' +
                                '<p>Mengirim data ke server...</p>');

                            // Submit form normal
                            stoForm[0].submit();
                        }
                    });
                });

                // Deteksi koneksi online
                window.addEventListener('online', function() {
                    console.log('Koneksi online terdeteksi');

                    // Coba sinkronisasi data offline
                    syncOfflineData();

                    // Sembunyikan pesan offline
                    if (document.getElementById('offline-alert')) {
                        document.getElementById('offline-alert').style.display = 'none';
                    }
                });

                // Deteksi koneksi offline
                window.addEventListener('offline', function() {
                    console.log('Koneksi offline terdeteksi');

                    // Tampilkan pesan offline
                    if (!document.getElementById('offline-alert')) {
                        const alert = document.createElement('div');
                        alert.id = 'offline-alert';
                        alert.style =
                            'position:fixed;top:0;left:0;width:100%;background:red;color:white;text-align:center;padding:10px;z-index:10000;';
                        alert.innerHTML =
                            '<strong>Anda sedang offline!</strong> Data akan disimpan secara lokal.';
                        document.body.prepend(alert);
                    } else {
                        document.getElementById('offline-alert').style.display = 'block';
                    }
                });

                // Fungsi untuk sinkronisasi data offline
                function syncOfflineData() {
                    offlineStorage.getPendingReports().then(reports => {
                        if (reports.length === 0) return;

                        console.log(`Found ${reports.length} pending reports to sync`);

                        // Tampilkan notifikasi sedang sinkronisasi
                        showSyncingNotification(reports.length);

                        // Batch kirim semua laporan pending
                        fetch('{{ route('api.sync-offline-data') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    reports
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Sync response:', data);

                                if (data.success) {
                                    // Update status untuk setiap laporan
                                    const updatePromises = data.results.map(result => {
                                        const reportId = reports.find(r => r.timestamp === result
                                            .timestamp)?.id;
                                        if (!reportId) return Promise.resolve();

                                        return offlineStorage.updateReportStatus(
                                            reportId,
                                            result.status === 'success' ? 'synced' : 'failed'
                                        );
                                    });

                                    // Ketika semua laporan terupdate, update indikator
                                    Promise.all(updatePromises).then(() => {
                                        updateOfflineIndicator();
                                        showSyncedNotification(data.processed);
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error during sync:', error);
                                showSyncErrorNotification();
                            });
                    });
                }

                // Cek jika ada data offline dan tambahkan indikator
                function updateOfflineIndicator() {
                    offlineStorage.getPendingReports().then(reports => {
                        const navbarBrand = document.querySelector('.navbar-brand');
                        const existingBadge = document.getElementById('offline-data-badge');

                        if (reports.length > 0) {
                            if (!existingBadge && navbarBrand) {
                                const badge = document.createElement('span');
                                badge.id = 'offline-data-badge';
                                badge.className = 'badge badge-warning ml-2';
                                badge.style = 'vertical-align: middle;';
                                badge.textContent = reports.length;
                                badge.title = `${reports.length} data menunggu untuk disinkronkan`;
                                navbarBrand.appendChild(badge);
                            } else if (existingBadge) {
                                existingBadge.textContent = reports.length;
                            }
                        } else if (existingBadge) {
                            existingBadge.remove();
                        }
                    });
                }

                // Tampilkan notifikasi sinkronisasi
                function showSyncingNotification(count) {
                    // Cek dulu apakah Swal tersedia
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Sinkronisasi Data',
                            text: `Sedang menyinkronkan ${count} data offline...`,
                            icon: 'info',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    } else {
                        // Alternatif jika tidak ada SweetAlert
                        if (document.getElementById('sync-notification')) {
                            document.getElementById('sync-notification').remove();
                        }

                        const notification = document.createElement('div');
                        notification.id = 'sync-notification';
                        notification.style =
                            'position:fixed;top:20px;right:20px;background:#17a2b8;color:white;padding:15px;border-radius:5px;z-index:9999;';
                        notification.innerHTML = `
                            <div>
                                <div class="spinner-border spinner-border-sm text-white" role="status"></div>
                                <span>Menyinkronkan ${count} data offline...</span>
                            </div>
                        `;
                        document.body.appendChild(notification);
                    }
                }

                // Tampilkan notifikasi selesai sinkronisasi
                function showSyncedNotification(count) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Sinkronisasi Selesai',
                            text: `Berhasil menyinkronkan ${count} data`,
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        const notification = document.getElementById('sync-notification');
                        if (notification) {
                            notification.style.background = '#28a745';
                            notification.innerHTML = `<span>Berhasil menyinkronkan ${count} data</span>`;
                            setTimeout(() => {
                                notification.remove();
                            }, 3000);
                        }
                    }
                }

                // Tampilkan notifikasi error sinkronisasi
                function showSyncErrorNotification() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Sinkronisasi Gagal',
                            text: 'Terjadi kesalahan saat menyinkronkan data. Data tetap aman dan akan dicoba lagi nanti.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        const notification = document.getElementById('sync-notification');
                        if (notification) {
                            notification.style.background = '#dc3545';
                            notification.innerHTML = `<span>Gagal menyinkronkan data. Akan dicoba lagi nanti.</span>`;
                            setTimeout(() => {
                                notification.remove();
                            }, 5000);
                        }
                    }
                }

                // Cek data offline saat halaman dimuat
                updateOfflineIndicator();

                // Coba sinkronkan jika online
                if (navigator.onLine) {
                    // Tunggu sebentar untuk pastikan halaman sudah dimuat
                    setTimeout(syncOfflineData, 1000);
                }
            });

            function toggleOptionalQuantityInputs() {
                $('#optionalQuantityInputs').toggle();
            }
        </script>
    @endpush
@endsection
