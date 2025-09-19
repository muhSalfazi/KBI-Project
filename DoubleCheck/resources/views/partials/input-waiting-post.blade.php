<div class="row">
    <div class="mb-3" id="div-input-wp">
        <label for="inputWP" class="form-label">Scan Waiting Post</label>
        <div class="input-group">
            <input type="text" name="waiting-post" id="inputWP" value="{{ old('customer') }}" placeholder="Scan waiting post..." class="form-control" autofocus/>
            <button class="btn btn-outline-secondary" type="button" id="btnOpenCamera" data-bs-toggle="modal" data-bs-target="#modalWaitingPost">
                <i class="bi bi-camera"></i>
            </button>

        </div>
    </div>
</div>

<div class="row d-none" id="div-detail-wp" >
    <div class="col-lg-4 col-4 my-3">
        <label for="inputCustomer" class="form-label">Customer</label>
        <input
            type="text"
            name="customer"
            id="inputCustomer"
            value="{{ old('customer') }}"
            placeholder="Scan customer..."
            class="form-control"
            autofocus
        />
    </div>

    <div class="col-lg-4 col-4 my-3">
        <label for="inputCycle" class="form-label">Cycle</label>
        <input
            type="text"
            name="cycle"
            id="inputCycle"
            class="form-control"
            value="{{ old('cycle') }}"
            placeholder="Scan cycle..."
        />
    </div>

    <div class="col-lg-4 col-4 my-3">
        <label for="inputRoute" class="form-label">Route</label>
        <input
            type="text"
            name="route"
            id="inputRoute"
            class="form-control"
            value="{{ old('route') }}"
            placeholder="Scan route..."
        />
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalWaitingPost" tabindex="-1" aria-labelledby="modalWaitingPostTitle" aria-hidden="true" data-bs-backdrop="false" data-bs-scroll="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalWaitingPostLabel">Scan Waiting Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Tempat kamera/preview -->
        <div id="qr-reader" style="width:100%"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
    const modal = document.getElementById('modalWaitingPost');
    let html5QrCode = new Html5Qrcode("qr-reader");

const qrCodeSuccessCallback = (decodedText, decodedResult) => {
    document.getElementById('inputWP').value = decodedText;

    parsingWP(decodedText);
    stopScanner();
};


modal.addEventListener('shown.bs.modal', function () {
    html5QrCode.start({ facingMode: "environment" }, qrConfig, qrCodeSuccessCallback)
        .catch(err => console.error("Error start scanner:", err));
});

 function parsingWP(decodedText) {
    // Coba parse input sebagai JSON
                        const scannedData = decodedText;
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
                        inputWP();
}

function stopScanner() {
    if (html5QrCode) {
            html5QrCode.stop()
                .then(() => {
                    console.log("✅ Scanner WaitingPost berhasil dihentikan");
                })
                .catch(err => {
                    console.error("❌ Gagal stop scanner WaitingPost:", err);
                });
        }
}

modal.addEventListener("hidden.bs.modal", function () {
        stopScanner();
    });
</script>
