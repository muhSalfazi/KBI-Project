<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendoman Packing</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/icon-kbi.png') }}" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<style>
    .text-warning {
        color: #ffc107 !important;
    }

    .debug {
        outline: 3px solid green;
    }
</style>

<body>
    {{-- loader --}}
    <div class="loader" id="loader">
        <div class="truckWrapper">
            <div class="truckBody">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 198 93" class="trucksvg">
                    <path stroke-width="3" stroke="#282828" fill="#F83D3D"
                        d="M135 22.5H177.264C178.295 22.5 179.22 23.133 179.594 24.0939L192.33 56.8443C192.442 57.1332 192.5 57.4404 192.5 57.7504V89C192.5 90.3807 191.381 91.5 190 91.5H135C133.619 91.5 132.5 90.3807 132.5 89V25C132.5 23.6193 133.619 22.5 135 22.5Z">
                    </path>
                    <path stroke-width="3" stroke="#282828" fill="#7D7C7C"
                        d="M146 33.5H181.741C182.779 33.5 183.709 34.1415 184.078 35.112L190.538 52.112C191.16 53.748 189.951 55.5 188.201 55.5H146C144.619 55.5 143.5 54.3807 143.5 53V36C143.5 34.6193 144.619 33.5 146 33.5Z">
                    </path>
                    <path stroke-width="2" stroke="#282828" fill="#282828"
                        d="M150 65C150 65.39 149.763 65.8656 149.127 66.2893C148.499 66.7083 147.573 67 146.5 67C145.427 67 144.501 66.7083 143.873 66.2893C143.237 65.8656 143 65.39 143 65C143 64.61 143.237 64.1344 143.873 63.7107C144.501 63.2917 145.427 63 146.5 63C147.573 63 148.499 63.2917 149.127 63.7107C149.763 64.1344 150 64.61 150 65Z">
                    </path>
                    <rect stroke-width="2" stroke="#282828" fill="#FFFCAB" rx="1" height="7" width="5"
                        y="63" x="187"></rect>
                    <rect stroke-width="2" stroke="#282828" fill="#282828" rx="1" height="11" width="4"
                        y="81" x="193"></rect>
                    <rect stroke-width="3" stroke="#282828" fill="#DFDFDF" rx="2.5" height="90" width="121"
                        y="1.5" x="6.5"></rect>
                    <rect stroke-width="2" stroke="#282828" fill="#DFDFDF" rx="2" height="4" width="6"
                        y="84" x="1"></rect>
                </svg>
            </div>
            <div class="truckTires">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" class="tiresvg">
                    <circle stroke-width="3" stroke="#282828" fill="#282828" r="13.5" cy="15" cx="15">
                    </circle>
                    <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" class="tiresvg">
                    <circle stroke-width="3" stroke="#282828" fill="#282828" r="13.5" cy="15" cx="15">
                    </circle>
                    <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
                </svg>
            </div>
            <div class="road"></div>

            <svg xml:space="preserve" viewBox="0 0 453.459 453.459" xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns="http://www.w3.org/2000/svg" id="Capa_1" version="1.1" fill="#000000" class="lampPost">
                <path d="M252.882,0c-37.781,0-68.686,29.953-70.245,67.358h-6.917v8.954c-26.109,2.163-45.463,10.011-45.463,19.366h9.993
                    c-1.65,5.146-2.507,10.54-2.507,16.017c0,28.956,23.558,52.514,52.514,52.514c28.956,0,52.514-23.558,52.514-52.514
                    c0-5.478-0.856-10.872-2.506-16.017h9.992c0-9.354-19.352-17.204-45.463-19.366v-8.954h-6.149C200.189,38.779,223.924,16,252.882,16
                    c29.952,0,54.32,24.368,54.32,54.32c0,28.774-11.078,37.009-25.105,47.437c-17.444,12.968-37.216,27.667-37.216,78.884v113.914
                    h-0.797c-5.068,0-9.174,4.108-9.174,9.177c0,2.844,1.293,5.383,3.321,7.066c-3.432,27.933-26.851,95.744-8.226,115.459v11.202h45.75
                    v-11.202c18.625-19.715-4.794-87.527-8.227-115.459c2.029-1.683,3.322-4.223,3.322-7.066c0-5.068-4.107-9.177-9.176-9.177h-0.795
                    V196.641c0-43.174,14.942-54.283,30.762-66.043c14.793-10.997,31.559-23.461,31.559-60.277C323.202,31.545,291.656,0,252.882,0z
                    M232.77,111.694c0,23.442-19.071,42.514-42.514,42.514c-23.442,0-42.514-19.072-42.514-42.514c0-5.531,1.078-10.957,3.141-16.017
                    h78.747C231.693,100.736,232.77,106.162,232.77,111.694z"></path>
            </svg>
        </div>
    </div>
    {{-- loadder  --}}
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <!-- Penanda Login -->
                <div class="navbar-form d-flex justify-content-between align-items-center mb-1 p-2  rounded">
                    <h5 class="card-title" style="font-size: 1.5rem; font-weight: bold; color: #ffff;">
                        <i class="fas fa-box-open me-2"></i> Panduan Packing
                        @if (isset($orders) && $orders->isNotEmpty())
                            <p class="colom mt-1" style="font-size: 17px; margin-bottom: -1px; color: #e67e22;">
                                <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;PO No&nbsp;:&nbsp;
                                <strong
                                    style="width: 5px; font-size: 20px; color: #e0e0e0; padding: 1px; text-transform: uppercase;">
                                    {{ $orders->first()->P_order ?? 'Not Available' }}
                                </strong>
                            </p>
                        @else
                            <p class="text-center" style="color: #e74c3c;">Data order tidak tersedia.</p>
                        @endif

                    </h5>
                    <audio id="noOrderSound" src="{{ asset('assets/audio/no_order.m4a') }}" preload="auto"></audio>
                    <audio id="poberhasil" src="{{ asset('assets/audio/po.m4a') }}" preload="auto"></audio>
                    @if (session('notfound'))
                        <div id="alertNotFound" class="alert alert-danger alert-dismissible fade show mt-1 p-1"
                            role="alert">
                            {{ session('notfound') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div id="alertSuccess" class="alert alert-success alert-dismissible fade show mt-1 p-1"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="text-end">
                        {{-- name --}}
                        <small class="text-muted d-block">
                            <strong style="color:#1abc9c;">{{ $user->first_name }} {{ $user->last_name }}</strong>
                            <i class="fas fa-user me-1" style="color:#1abc9c;"></i>
                        </small>
                        <small class="text-muted d-block">
                            <strong style="color: #bdc3c7">
                                @if (!empty($user->last_login) && $user->last_login instanceof \Carbon\Carbon)
                                    {{ $user->last_login->format('d M Y, H:i:s') }}
                                @else
                                    {{ $user->last_login ?? 'Belum login' }}
                                @endif
                            </strong>
                        </small>
                    </div>
                </div>
                <div class="card p-4 shadow-lg" style="margin-bottom: -10px">
                    <!-- Form Packing -->
                    <form class="row g-3" action="{{ route('packing.manage', Auth::id()) }}" method="POST"
                        novalidate id="autoSubmitForm">
                        @csrf
                        <div class="col-12 mb-2">
                            <label for="partNumberInput" class="form-label" style="font-size: 1.1rem;">Customer Part
                                Number
                                (Scan QR)</label>
                            <div class="input-group">
                                <input type="text" name="part_number" class="form-control" id="partNumberInput"
                                    required autofocus>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-lg w-100" type="submit" id="">Show</button>
                        </div>
                        <input type="hidden" name="action" value="show" id="actionField">
                    </form>
                </div>
                <div class="col-md-12 p-2 mb-4">
                    {{-- <div class="card"> --}}
                    @if (isset($orders) && $orders->isNotEmpty())
                        <div class="card-body mt-12 p-2" style="margin-bottom: 2px;">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-center" style="gap: 15px;">
                                    <!-- Set gap for space between tables -->
                                    <div style="margin-right:auto; width:100%;">
                                        <!-- Adjust margin and set width -->
                                        <table class="table table-bordered text-center align-middle"
                                            style="border: 2px solid black; margin-bottom: 2px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th colspan="1"
                                                        style="font-size: 12px; border: 2px solid black; padding: 10px; text-align: center; vertical-align: middle; padding: 2px;">
                                                        No
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 2px solid black; padding: 10px; text-align: center; vertical-align: middle; padding: 2px;">
                                                        Part Number
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                        Part Name
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 2px solid black; text-align: center; vertical-align: middle; padding:2px;">
                                                        Part No Customer
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 2px solid black; text-align: center; vertical-align: middle; padding:2px;">
                                                        Order Qty
                                                    </th>
                                                    <th colspan="6"
                                                        style="font-size: 12px; border: 2px solid black; text-align: center; vertical-align: middle; padding:2px;">
                                                        Status Prepare
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr
                                                        class="{{ $order->Qty <= $order->prepared_qty ? 'table-success debug' : 'table-default' }}">
                                                        <!-- Nomor -->
                                                        <td class="text-center"
                                                            style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                            {{ $loop->iteration }}
                                                        </td>

                                                        <!-- Part Number -->
                                                        <td colspan="6"
                                                            style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                            <strong
                                                                style="font-size: 16px;">{{ $order->part->P_No ?? '' }}</strong>
                                                        </td>

                                                        <!-- Part Name -->
                                                        <td colspan="6"
                                                            style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                            <strong
                                                                style="font-size: 16px;">{{ $order->part->P_Name ?? '' }}</strong>
                                                        </td>

                                                        <!-- Part No Customer -->
                                                        <td colspan="6"
                                                            style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                            <strong
                                                                style="font-size: 16px;">{{ $order->P_no_cus ?? '' }}</strong>
                                                        </td>

                                                        <!-- Order Quantity -->
                                                        <td colspan="6"
                                                            style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                            <strong
                                                                style="font-size: 16px;">{{ $order->Qty ?? '' }}</strong>
                                                        </td>

                                                        <!-- Status Prepare -->
                                                        <td colspan="6"
                                                            style="border: 2px solid black; text-align: center; vertical-align: middle; padding: 2px;">
                                                            @if ($order->Qty <= $order->prepared_qty)
                                                                <span class="text-success">
                                                                    <i class="fas fa-check-circle"></i> Closed
                                                                </span>
                                                            @else
                                                                <span class="text-warning">
                                                                    <i class="fas fa-hourglass-half"></i> In Progress
                                                                </span>
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
                    @else
                        <div class="p-2 text-center">
                            <p>Data order tidak tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
        {{-- footer --}}
        <footer>
            <div class="copyright" style="text-align: center">
                Copyright_Logistic System<strong><span> &copy;2024</span></strong>. All Rights Reserved
            </div>
        </footer>
    </section>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    {{-- jsload --}}
    <script>
        window.addEventListener('load', function() {
            // Sembunyikan loader setelah halaman selesai dimuat
            document.getElementById('loader').style.display = 'none';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    // Auto-focus pada input ketika halaman dimuat
                    const partNumberInput = document.getElementById('partNumberInput');
                    const form = document.getElementById('autoSubmitForm');

                    if (partNumberInput) {
                        partNumberInput.focus(); // Fokus pada input saat halaman dimuat

                        document.addEventListener('click', function(event) {
                            if (event.target !== partNumberInput) {
                                partNumberInput.focus();
                            }
                        });
                    }
                    // Keep session alive setiap 10 menit
                    let sessionAlive = true; // Kendalikan secara global
                    setInterval(() => {
                        if (!sessionAlive) return;
                        fetch('/keep-session-alive').catch(() => sessionAlive = false);
                    }, 10 * 60 * 1000);

                    function debounce(func, delay) {
                        let timer;
                        return function(...args) {
                            clearTimeout(timer);
                            timer = setTimeout(() => func.apply(this, args), delay);
                        };
                    }
                    document.getElementById('partNumberInput').addEventListener('input', debounce(resetTimer, 500));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk menampilkan alert dan memutar audio
            function showAlertWithAudio(alertId, audioId) {
                var alertBox = document.getElementById(alertId);
                var audio = document.getElementById(audioId);
                if (alertBox) {
                    alertBox.style.display = 'block'; // Pastikan alert terlihat
                    alertBox.classList.add('show'); // Tambahkan kelas show untuk animasi
                }
                if (audio) {
                    audio.muted = false; // Lepaskan mute sebelum memutar
                    audio.play().catch(function(error) {
                        console.error(`Audio ${audioId} gagal diputar:`, error);
                        // Tambahkan tombol interaktif jika autoplay dibatasi
                        createEnableSoundButton(audio);
                    });
                }
            }

            // Fungsi untuk membuat tombol interaktif saat audio autoplay gagal
            function createEnableSoundButton(audio) {
                var startButton = document.createElement('button');
                startButton.innerText = 'Enable Sound';
                startButton.style.position = 'fixed';
                startButton.style.bottom = '10px';
                startButton.style.right = '10px';
                startButton.style.zIndex = 9999;
                startButton.style.padding = '10px 20px';
                startButton.style.background = '#1abc9c';
                startButton.style.color = '#fff';
                startButton.style.border = 'none';
                startButton.style.cursor = 'pointer';
                startButton.onclick = function() {
                    audio.play();
                    startButton.remove(); // Hapus tombol setelah audio diputar
                };
                document.body.appendChild(startButton);
            }

            // Logika untuk menentukan alert mana yang akan ditampilkan
            @if (session('success'))
                showAlertWithAudio('alertSuccess', 'poberhasil'); // Tidak memutar audio
            @elseif (session('notfound'))
                showAlertWithAudio('alertNotFound', 'noOrderSound'); // Alert dengan audio
            @endif

            // Hapus alert setelah beberapa waktu (contoh: 5 detik)
            setTimeout(function() {
                var alertBoxes = document.querySelectorAll('.alert');
                alertBoxes.forEach(function(alertBox) {
                    alertBox.classList.add('fade'); // Tambahkan kelas fade untuk animasi
                    setTimeout(function() {
                        alertBox.remove(); // Hapus elemen setelah animasi selesai
                    }, 500); // Pastikan sesuai dengan durasi animasi fade-out
                });
            }, 5000);
        });

        // Sembunyikan loader setelah halaman selesai dimuat
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            if (loader) loader.style.display = 'none';
        });

        // Menjaga sesi tetap hidup setiap 10 menit
        setInterval(() => {
            fetch('/keep-session-alive')
                .then(() => console.log('Session tetap hidup'))
                .catch(err => console.error('Gagal memperbarui sesi:', err));
        }, 600000);
    </script>

</body>

</html>
