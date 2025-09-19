@extends('layouts.app', ['title' => 'Leader']) @section('content') @php use
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
                </form>

                <form method="POST" id="formWaitingPost">
                    @csrf
                    <div class="mb-3">
                        <label for="dateInput" class="form-label"
                            >Tanggal Delivery</label
                        >
                        <input
                            type="date"
                            name="date"
                            id="dateInput"
                            class="form-control"
                            value="{{ request('date') }}"
                            autofocus
                        />
                    </div>

                    @include('partials.input-waiting-post')
                </form>

                <div id="form2-container" style="display: none">
                    @include('partials.input-manifest')

                    {{-- input parts untuk leader --}}
                    <div id="form3-container" style="display: none">
                        @include('partials.input-parts')
                    </div>

                    <div id="table-container">
                        {{-- tampilkan di sini --}}
                    </div>
                </div>

                <audio
                    src="{{ asset('assets/sound/error.mp3') }}"
                    id="errorSound"
                ></audio>
                <audio
                    src="{{ asset('assets/sound/lanjut.wav') }}"
                    id="lanjutSound"
                ></audio>
                <audio
                    src="{{ asset('assets/sound/scan-dn-selesai.m4a') }}"
                    id="dnSound"
                ></audio>
                <audio
                    src="{{ asset('assets/sound/ng-manifest.m4a') }}"
                    id="errorDnSound"
                ></audio>
                <audio
                    src="{{ asset('assets/sound/warning-manifest.m4a') }}"
                    id="warningSound"
                ></audio>
                <audio
                    src="{{ asset('assets/sound/success.wav') }}"
                    id="successSound"
                ></audio>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    // var global
                    let dateGlobal = null;
                    let rowCount = 0;
                    let counter = 0;
                    let inputed = new Set();

                    document
                        .getElementById("inputWP")
                        .addEventListener("keydown", async function (e) {
                            if (e.key === "Enter") {
                                e.preventDefault();

                                try {
                                    // Coba parse input
                                    const scannedData = e.target.value;
                                    const parse = scannedData.split(";");
                                    const data = {
                                        customer: parse[0],
                                        route: parse[1],
                                        cycle: parse[2],
                                    };
                                    // Isi otomatis field lainnya jika data JSON valid
                                    if (data.customer) {
                                        document.getElementById(
                                            "inputCustomer"
                                        ).value = data.customer;
                                    }
                                    if (data.route) {
                                        document.getElementById(
                                            "inputRoute"
                                        ).value = data.route;
                                    }
                                    if (data.cycle) {
                                        document.getElementById(
                                            "inputCycle"
                                        ).value = data.cycle;
                                    }
                                    await inputWP();
                                } catch (error) {
                                    // Jika bukan JSON, lanjutkan dengan input biasa
                                    await inputWP();
                                }
                            }
                        });
                    document
                        .getElementById("dateInput")
                        .addEventListener("change", handleEnter);
                    document
                        .getElementById("inputManifest")
                        .addEventListener("keydown", handleEnter);
                    document
                        .getElementById("inputParts")
                        .addEventListener("keydown", handleEnter);

                    document.getElementById("inputManifest").onclick =
                        function () {
                            console.log("Input Manifest clicked");
                            document.getElementById("inputManifest").value = "";
                            document.getElementById("inputManifest").focus();
                        };

                    async function handleEnter(e) {
                        if (e.key === "Enter") {
                            e.preventDefault();
                            if (e.target.id === "inputManifest") {
                                await inputManifest();
                            } else if (e.target.id === "inputParts") {
                                await inputParts();
                            }
                        }
                    }

                    async function inputManifest() {
                        const manifest =
                            document.getElementById("inputManifest").value;
                        const csrfToken = document.querySelector(
                            'input[name="_token"]'
                        ).value;

                        try {
                            const response = await fetch(
                                "{{ route('label.parts-data') }}",
                                {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": csrfToken,
                                        Accept: "application/json",
                                    },
                                    body: JSON.stringify({
                                        manifest: manifest,
                                        date: dateGlobal,
                                    }),
                                }
                            );

                            const data = await response.json();
                            if (data.success === true) {
                                document.getElementById(
                                    "form3-container"
                                ).style.display = "block";
                                document.getElementById(
                                    "table-container"
                                ).innerHTML = data.html;
                                rowCount = data.totalRow;

                                const partsInput =
                                    document.getElementById("inputParts");
                                partsInput.focus();
                                partsInput.select();
                            }

                            Swal.fire({
                                title: data.success ? "OK!" : "NG!",
                                text: data.message,
                                icon: data.success ? "success" : "error",
                                timer: 3000,
                                showConfirmButton: false,
                                didOpen: () => {
                                    const audio = new Audio(
                                        data.success
                                            ? document.getElementById(
                                                  "lanjutSound"
                                              ).src
                                            : document.getElementById(
                                                  "errorDnSound"
                                              ).src
                                    );
                                    audio.play();
                                },
                            });
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

                    async function dataManifest() {
                        let route = "{{ route('wp.data-table-sj') }}";
                        if (dateGlobal) {
                            route = `{{ route('wp.data-table-sj') }}?date=${dateGlobal}`;
                        }
                        const response = await fetch(route, {
                            method: "GET",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest",
                            },
                        });
                        const data = await response.json();
                        document.getElementById("table-container").innerHTML =
                            data.html;
                    }
                    // counter input baris
                    function setTotalRow(j) {
                        rowCount = j;
                        inputCounter = 0;
                        inputed.clear();
                    }
                    async function inputParts() {
                        const parts =
                            document.getElementById("inputParts").value;
                        const manifest =
                            document.getElementById("inputManifest").value;
                        const csrfToken = document.querySelector(
                            'input[name="_token"]'
                        ).value;

                        const response = await fetch(
                            "{{ route('label.store-scan') }}",
                            {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken,
                                    Accept: "application/json",
                                },
                                body: JSON.stringify({
                                    parts: parts,
                                    manifest: manifest,
                                    date: dateGlobal,
                                }),
                            }
                        );

                        const data = await response.json();
                        if (data.success === true) {
                            document.getElementById(
                                "table-container"
                            ).innerHTML = data.html;

                            if (!inputed.has(parts)) {
                                inputed.add(parts);
                                counter++;
                            }
                        }
                        console.log(data);

                        let soundId;
                        switch (data.type) {
                            case "warning":
                                soundId = "warningSound";
                                break;
                            case "error":
                                soundId = "errorDnSound";
                                break;
                            case "success":
                                if (
                                    counter >= rowCount ||
                                    data.checkedAll == true
                                ) {
                                    soundId = "dnSound";
                                    counter = 0;
                                } else {
                                    soundId = "lanjutSound";
                                }
                                break;
                            default:
                                soundId = "errorDnSound"; // fallback
                        }

                        Swal.fire({
                            title:
                                data.type === "success"
                                    ? "OK!"
                                    : data.type === "warning"
                                    ? "Warning!"
                                    : "NG!",
                            text: data.message,
                            icon: data.type,
                            timer: 3000,
                            showConfirmButton: false,
                            didOpen: () => {
                                const audio = new Audio(
                                    document.getElementById(soundId).src
                                );
                                audio.play();
                            },
                        });
                        // Setelah input label berhasil, kosongkan input
                        document.getElementById("inputParts").value = "";
                        document.getElementById("inputParts").focus();
                    }
                    async function inputWP() {
                        const customer =
                            document.getElementById("inputCustomer").value;
                        const cycle =
                            document.getElementById("inputCycle").value;
                        const route =
                            document.getElementById("inputRoute").value;
                        const date = document.getElementById("dateInput").value;
                        dateGlobal = date;

                        const csrfToken = document.querySelector(
                            'input[name="_token"]'
                        ).value;

                        try {
                            const response = await fetch(
                                "{{ route('wp.store-scan-2') }}",
                                {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": csrfToken,
                                        Accept: "application/json",
                                    },
                                    body: JSON.stringify({
                                        customer: customer,
                                        cycle: cycle,
                                        date: date,
                                        route: route,
                                    }),
                                }
                            );

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
                                            ? document.getElementById(
                                                  "lanjutSound"
                                              ).src
                                            : document.getElementById(
                                                  "errorSound"
                                              ).src
                                    );
                                    audio.play();
                                },
                            });

                            if (data.success) {
                                const form1Inputs = document.querySelectorAll(
                                    "#formWaitingPost input"
                                );
                                form1Inputs.forEach((input) => {
                                    if (input.name !== "date")
                                        input.disabled = true;
                                });

                                document.getElementById(
                                    "div-input-wp"
                                ).style.display = "none";
                                document
                                    .getElementById("div-detail-wp")
                                    .classList.remove("d-none");

                                document.getElementById(
                                    "form2-container"
                                ).style.display = "block";
                                await dataManifest();

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
                </script>
            </div>
        </div>
    </div>
    @endsection
</div>
