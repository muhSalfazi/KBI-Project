<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KBI</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('../assets/img/icon-kbi.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<style>
    .animated-image {
        width: 300px;
        /* Set the width of the image */
        height: auto;
        /* Maintain aspect ratio */
        animation: bounce 2s ease infinite;
        /* Apply bounce animation */
    }

    .animated-image {
        max-width: 100%;
        /* Agar gambar tidak lebih besar dari kontainer */
        height: auto;
        /* Agar proporsi gambar tetap */
    }
</style>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-12 col-lg-12 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('../assets/img/kyoraku-baru.png') }}" width="180"
                                        alt="Logo">
                                </div>
                                <p class="text-center">PT.Kyoraku Blowmolding Indonesia</p>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mt-1 p-1"
                                        role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show mt-1 p-1" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if (session('auth_error'))
                                    <div class="alert alert-warning  alert-dismissible fade show mt-1 p-1"
                                        role="alert">
                                        {{ session('auth_error') }}
                                    </div>
                                @endif
                                <form action="{{ route('loginUser') }}" method="POST" id="partNumberForm">
                                    @csrf
                                    <div class="mb-4 password-wrapper">
                                        <label for="partNumberInput" class="form-label">ID Card Number</label>
                                        <input type="text" name="id_card_number" class="form-control"
                                            id="partNumberInput" placeholder="Silahkan scan QR" required autofocus>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                    <div class="credits mt-1">
                                        <a href="{{ route('login-admin') }}" class="back-to-home">
                                            <i class="bi bi-box-arrow-in-right"></i>Login Admin
                                        </a>
                                    </div>
                                </form>
                                <script>
                                    function submitForm() {
                                        document.getElementById('partNumberForm').submit();
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        const partNumberInput = document.getElementById('partNumberInput');
                                        partNumberInput.focus(); // Fokus pada input saat halaman dimuat
                                        // Menjaga fokus tetap pada input meskipun mengklik di luar form
                                        document.addEventListener('click', function(event) {
                                            if (event.target !== partNumberInput) {
                                                partNumberInput.focus();
                                            }
                                        });
                                    });

                                    // Auto submit form setelah input selesai
                                    let inputLengthBefore = 0;

                                    {{-- document.getElementById('partNumberInput').addEventListener('input', function(event) {
                                        const inputLength = event.target.value.length;
                                        const delay = 2000; // 2 detik

                                        // Jika input lebih dari 3 karakter, submit form
                                        setTimeout(() => {
                                            if (inputLength >= 2 && inputLength === inputLengthBefore) {
                                                submitForm();   
                                            }
                                            inputLengthBefore = inputLength;
                                        }, delay) 
                                    }); --}}

                                    let inputLengthBefore = 0;

                                    function cekTyping() {
                                        const inputLength = document.querySelector('#partNumberInput').value.length;
                                        console.log('inputNow', inputLength);
                                        console.log('inputNowBefore', inputLengthBefore);


                                        if (inputLength >= 2 && inputLength === inputLengthBefore) {
                                            console.log('submit');
                                        }

                                        inputLengthBefore = inputLength;
                                    }

                                    setInterval(cekTyping, 2000);

                                    // Submit form saat tombol enter ditekan
                                    document.getElementById('partNumberInput').addEventListener('keypress', function(event) {
                                        if (event.key === 'Enter') {
                                            event.preventDefault(); // Mencegah submit default
                                            submitForm();
                                        }
                                    });
                                    // Fungsi untuk memfokus kembali input jika form telah dikirim
                                    window.onfocus = function() {
                                        const partNumberInput = document.getElementById('partNumberInput');
                                        partNumberInput.focus();
                                    };
                                </script>
                            </div>
                        </div>
                        <div class="copyright" style="text-align: center">
                            Copyright_Logistic System<strong><span> &copy;2024</span></strong>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> <!-- FontAwesome for icons -->

    {{-- time alert --}}
    @if (session('success') || session('error') || session('auth_error'))
        <script>
            // Waktu delay 5 detik (5000 milidetik)
            setTimeout(function() {
                // Mencari elemen alert yang ada dan menyembunyikannya
                var alertElement = document.querySelector('.alert');
                if (alertElement) {
                    alertElement.classList.remove('show');
                    alertElement.classList.add('fade');
                    setTimeout(function() {
                        alertElement.remove();
                    }, 50); // Menunggu animasi fade-out
                }
            }, 2000);
        </script>
    @endif

    {{-- sesion reload with ajax --}}
    <script>
        setInterval(function() {
            fetch('/keep-session-alive').then(response => {
                if (response.ok) {
                    console.log('Session refreshed');
                }
            });
        }, 600000); // Refresh setiap 10 menit (600000 ms)
    </script>


</body>

</html>
