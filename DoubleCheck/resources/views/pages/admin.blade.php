@extends('layouts.app', ['title' => 'Admin']) @section('content') @php use
Illuminate\Support\Facades\Auth; @endphp

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center mb-4">
                <h5 class="mb-3 mb-md-0 text-center">{{ $judul }}</h5>

                <div class="row mb-3 px-2 px-md-3">
                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center w-100"
                    >
                        <h6 class="mb-2 mb-md-0">Data Waiting Post</h6>

                        <form
                            action="{{ route('scan.end-session') }}"
                            method="POST"
                            class="d-inline"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-danger btn-sm px-2 py-1 small"
                            >
                                Reset
                            </button>
                        </form>
                    </div>
                </div>

                {{-- form tanggal --}}
                <form
                    action="{{ route('wp.index') }}"
                    method="GET"
                    id="dateForm"
                >
                    @csrf
                    <label for="dateInput" class="form-label"
                        >Tanggal Delivery</label
                    >
                    <div class="col-md-4">
                        <input
                            type="date"
                            name="date"
                            id="dateInput"
                            class="form-control"
                            value="{{ request('date') }}"
                            autofocus
                        />
                    </div>
                </form>

                <form method="POST" id="formWaitingPost">
                    @csrf @include('partials.input-waiting-post')
                </form>

                <div id="form2-container" style="display: none">
                    @include('partials.input-manifest')

                    <div id="table-manifest">
                        @include('partials.table-manifest')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <audio src="{{ asset('assets/sound/error.mp3') }}" id="errorSound"></audio>
    <audio src="{{ asset('assets/sound/lanjut.wav') }}" id="lanjutSound"></audio>
    <audio src="{{ asset('assets/sound/scan-dn-selesai.m4a') }}" id="dnSound"></audio>
    <audio src="{{ asset('assets/sound/ng-manifest.m4a') }}" id="errorDnSound"></audio>
    <audio src="{{ asset('assets/sound/warning-manifest.m4a') }}" id="warningSound"></audio>
    <audio src="{{ asset('assets/sound/success.wav') }}" id="successSound"></audio>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let rowCount = 0;
        let inputCounter = 0;
        let inputedManifest = new Set();
        document
            .getElementById("inputWP")
            .addEventListener("keydown", async function (e) {
                if (e.key === "Enter") {
                    e.preventDefault();

                    try {
                        // Coba parse input sebagai JSON
                        const scannedData = e.target.value;
                        const parse = scannedData.split(";");
                        const data = {
                            customer: parse[0],
                            route: parse[1],
                            cycle: parse[2],
                        };
                        // Isi otomatis field lainnya jika data JSON valid
                        if (data.customer) {
                            document.getElementById("inputCustomer").value =
                                data.customer;
                            console.log(data.customer);
                        }
                        if (data.route) {
                            document.getElementById("inputRoute").value =
                                data.route;
                        }
                        if (data.cycle) {
                            document.getElementById("inputCycle").value =
                                data.cycle;
                        }
                        await inputWP();
                    } catch (error) {
                        // Jika bukan JSON, lanjutkan dengan input biasa
                        await inputWP();
                    }
                }
            });

        document
            .getElementById("inputManifest")
            .addEventListener("keydown", handleEnter);

        async function handleEnter(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                if (e.target.id === "inputManifest") {
                    inputManifest();
                }
            }
        }

        function refreshTabel() {
            const dateInput = document.getElementById("dateInput");
            const selectedDate = dateInput ? dateInput.value : "";

            const baseUrl = "{{ route('wp.index') }}";
            const url = new URL(baseUrl, window.location.origin);

            if (selectedDate) {
                // Hanya tambahkan parameter jika tanggal dipilih
                url.searchParams.append("date", selectedDate);
            }
            fetch(url.toString(), {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest", // <== ini WAJIB
                },
            })
                .then((response) => response.text())
                .then((html) => {
                    document.getElementById("table-manifest").innerHTML = html;
                    rowCount = document.querySelectorAll('#table-manifest table tbody tr').length;
                });
        }

        document
            .getElementById("dateInput")
            .addEventListener("change", function () {
                const selectedDate = this.value;
                const baseUrl = "{{ route('wp.index') }}"; // URL dasar dari route Laravel
                const url = new URL(baseUrl, window.location.origin); // Pastikan URL absolut
                url.searchParams.append("date", selectedDate);

                fetch(url.toString(), {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((response) => response.text())
                    .then((html) => {
                        document.getElementById("table-manifest").innerHTML =
                            html;
                    });
                document.getElementById("inputCustomer").focus();
            });

        async function inputWP(onSuccessCallback) {
            const customer = document.getElementById("inputCustomer").value;
            const cycle = document.getElementById("inputCycle").value;
            const route = document.getElementById("inputRoute").value;
            const csrfToken = document.querySelector(
                'input[name="_token"]'
            ).value;

            try {
                const response = await fetch("{{ route ('wp.store-scan') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        customer: customer,
                        cycle: cycle,
                        route: route,
                    }),
                });

                const data = await response.json();

                Swal.fire({
                    title: data.success ? "OK!" : "NG!",
                    text: data.message,
                    icon: data.success ? "success" : "error",
                    timer: 3000,
                    showConfirmButton: false,
                    didOpen: () => {
                        const audio = new Audio(
                            data.success
                                ? document.getElementById("successSound").src
                                : document.getElementById("errorSound").src
                        );
                        audio.play();
                    },
                });

                if (data.success) {
                    const form1Inputs = document.querySelectorAll(
                        "#formWaitingPost input"
                    );
                    form1Inputs.forEach((input) => {
                        input.disabled = true;
                    });

                    document.getElementById("div-input-wp").style.display =
                        "none";
                    document
                        .getElementById("div-detail-wp")
                        .classList.remove("d-none");
                    document.getElementById("form2-container").style.display =
                        "block";
                    const dateInput = document.getElementById("dateInput");
                    const selectedDate = dateInput ? dateInput.value : null;

                    await refreshTabel(selectedDate);

                    const manifestInput =
                        document.getElementById("inputManifest");
                    if (manifestInput) {
                        manifestInput.focus();
                        manifestInput.select();
                    }
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error!",
                    text: error,
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
        }

        function setTotalManifest(j) {
            rowCount = j;
            inputCounter = 0;
            inputedManifest.clear()
        }

        async function inputManifest() {
            const manifestInput = document.getElementById("inputManifest");
            const manifest = manifestInput.value;
            const csrfToken = document.querySelector(
                'input[name="_token"]'
            ).value;

            manifestInput.value = "";

            fetch("{{ route ('po.store-scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    manifest: manifest,
                }),
            })
                .then((response) => response.json())
                .then((data) => {

                    if(data.success) {
                        if(!inputedManifest.has(manifest)) {
                            inputedManifest.add(manifest);
                            inputCounter++;
                        }
                    }

                    let soundId;
                    switch (data.type) {
                        case "warning":
                            soundId = "warningSound";
                            break;
                        case "error":
                            soundId = "errorDnSound";
                            break;
                        case "success":
                            if (inputCounter >= rowCount) {
                                soundId = "dnSound";
                                inputCounter = 0;
                            } else {
                                soundId = "lanjutSound";
                            }
                            break;
                        default:
                            soundId = "errorDnSound"; // fallback
                    }

                    Swal.fire({
                        title: data.type === "success" ? "OK!" : 
                                data.type === "warning" ? "Warning!" : "NG!",
                        text: data.message,
                        icon: data.type,
                        timer: 3000,
                        showConfirmButton: false,
                        didOpen: () => {
                            const audio = new Audio(document.getElementById(soundId).src);
                            audio.play();
                        },
                    });

                    refreshTabel();

                    // Setelah input manifest berhasil, kosongkan input
                    document.getElementById("inputManifest").value = "";

                    // Kemudian pindahkan fokus kembali ke input manifest
                    document.getElementById("inputManifest").focus();
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan di server", error);
                });
        }
    </script>
    @endsection
</div>
