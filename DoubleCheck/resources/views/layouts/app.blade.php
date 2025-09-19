<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/png" href="{{ asset('logo-kbi.png') }}" />
        <title>{{ $title ?? "Scan Delivery" }}</title>

        <!-- Bootstrap 5 CDN -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <!-- Optional Font Awesome (untuk ikon) -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        />
        <!-- SweetAlert2 CSS -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
        />
        <!-- html5qr -->
        <script
            src="https://unpkg.com/html5-qrcode"
            type="text/javascript"
        ></script>

        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
            rel="stylesheet"
        />
        
         <!-- date picker -->
         <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        
        <!-- Custom CSS -->
        <link
            rel="stylesheet"
            href="https://unpkg.com/bs-brain@2.0.4/components/tables/table-1/assets/css/table-1.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @livewireStyles

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
            <div class="container-fluid">
                <!-- Tombol toggle sidebar (muncul di mobile) -->
                <!-- Inside your navbar -->
                <button
                    class="navbar-toggler me-2 d-none d-lg-block"
                    id="desktopToggle"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <button class="navbar-toggler me-2 d-lg-none" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand/logo -->
                <a class="navbar-brand" href="#">DELIVERY SISTEM</a>

                <!-- Tombol toggle navbar (muncul di mobile) -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu navbar -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <form
                                id="logout-form"
                                action="{{ route('logout') }}"
                                method="POST"
                            >
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <div class="sidebar bg-light">
            <div class="sidebar-header p-3 border-bottom">
                <h5 class="mb-0">
                    {{ Illuminate\Support\Facades\Auth::user()->full_name }}
                </h5>
            </div>
            <ul class="nav flex-column p-2">
                @if(in_array(Illuminate\Support\Facades\Auth::user()->id_role,
                [1, 2, 4]))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('scanAdmin') }}">
                        <i class="fa-solid fa-chart-bar"></i> Scan Admin
                    </a>
                </li>
                @endif
                @if(in_array(Illuminate\Support\Facades\Auth::user()->id_role,
                [1, 2, 3]))
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="https://delivery.jajaleun.com/SCAN/pages/Login.php"
                    >
                        <i class="fa-solid fa-layer-group"></i> Prepare Member
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('scanLeader') }}">
                        <i class="fa-solid fa-chart-bar"></i> Checking Leader
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('checkSuratJalan') }}">
                        <i class="fa-solid fa-truck-loading"></i> Check Surat
                        Jalan
                    </a>
                </li>
                @endif
                @if(in_array(Illuminate\Support\Facades\Auth::user()->id_role,
                [1, 2, 4]))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('history.admin') }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>Riwayat
                        Posting
                    </a>
                </li>
                @elseif(in_array(Illuminate\Support\Facades\Auth::user()->id_role,
                [1, 2, 3]))
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('history.leader') }}?leader=true"
                    >
                        <i class="fa-solid fa-clock-rotate-left"></i>Riwayat
                        Check Leader
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('history.loading') }}?loading=true"
                    >
                        <i class="fa-solid fa-clock-rotate-left"></i>Riwayat
                        Scan Loading
                    </a>
                </li>
                @endif
                @if(in_array(Illuminate\Support\Facades\Auth::user()->id_role,
                [1]))
                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('user.userManagement') }}"
                    >
                        <i class="fa-solid fa-users"></i> Manajemen User
                    </a>
                </li>
                @endif
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="{{ route('pesan') }}">-->
                <!--        <i class="fa-solid fa-message"></i> Pesan-->
                <!--    </a>-->
                <!--</li>-->
            </ul>
        </div>

        <!-- Main Content -->
        <main class="py-4 main-content">
            <div class="container-fluid">
                @yield('content')
                <!-- Global Alert Container -->
                <div
                    id="responseAlert"
                    class="alert alert-success d-none text-center mx-4 mt-3"
                ></div>

                <!-- SweetAlert2 JS -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                @if(session('success'))
                <script>
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: '{{ session("success") }}',
                        showConfirmButton: true,
                        timer: 3000,
                    });
                </script>
                @endif

                @livewireScripts
            </div>
            <footer>
                <p>
                    © <span id="footer-year"></span> - Delivery KBI | v{{
                        config("app.version")
                    }}
                </p>
            </footer>
        </main>

        <!-- Overlay untuk sidebar di mobile -->
        <div class="overlay"></div>
        @stack('scripts')

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("footer-year").textContent =
                    new Date().getFullYear();
                const sidebar = document.querySelector(".sidebar");
                // const mainContent = document.querySelector(".main-content");
                const desktopToggle = document.getElementById("desktopToggle");
                const mobileToggle = document.getElementById("mobileToggle");
                const overlay = document.querySelector(".overlay");
                const isMobile = window.innerWidth < 992;

                const sidebarState = localStorage.getItem("sidebarCollapsed");
                if (sidebarState === "true" || isMobile) {
                    sidebar.classList.add("collapsed");
                }

                function toggleSidebar() {
                    sidebar.classList.toggle("collapsed");
                    const isCollapsed = sidebar.classList.contains("collapsed");
                    localStorage.setItem("sidebarCollapsed", isCollapsed);

                    // For mobile, handle overlay
                    if (window.innerWidth < 992) {
                        overlay.style.display = isCollapsed ? "none" : "block";
                    }
                }

                // Update your event listeners to use toggleSidebar()
                if (desktopToggle) {
                    desktopToggle.addEventListener("click", toggleSidebar);
                }

                // Tambahkan event listener untuk tombol mobile
                if (mobileToggle) {
                    mobileToggle.addEventListener("click", toggleSidebar);
                }

                function handleResize() {
                    if (window.innerWidth >= 992) {
                        overlay.style.display = "none";
                        const sidebarState =
                            localStorage.getItem("sidebarCollapsed");

                        if (sidebarState !== "true") {
                            // Open sidebar if localStorage doesn't say it's collapsed
                            sidebar.classList.remove("collapsed");
                        } else {
                            sidebar.classList.add("collapsed");
                        }
                    } else {
                        // Mobile - always start with sidebar collapsed and show overlay if not
                        sidebar.classList.add("collapsed");
                        overlay.style.display = "none";
                    }
                }

                // Jalankan saat pertama kali load
                handleResize();

                // Dan saat window di-resize
                window.addEventListener("resize", handleResize);

                overlay.addEventListener("click", function () {
                    if (!sidebar.classList.contains("collapsed")) {
                        toggleSidebar();
                    }
                });
            });
            const qrConfig = { fps: 10, qrbox: 250 };
            let canScan = true; // untuk kontrol cooldown
            function loadTable() {
                const tableContainer =
                    document.getElementById("table-container");

                // tampilkan loading state dulu
                tableContainer.innerHTML = `
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Sedang memuat data...</p>
                    </div>
                `;
            }
        </script>
    </body>
</html>
