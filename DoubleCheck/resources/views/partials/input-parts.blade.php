<form id="formParts">
    @csrf
    <div class="mb-3">
        <label for="inputParts" class="form-label">Label Customer</label>

        <div class="input-group">
            <input type="text" name="parts" id="inputParts" class="form-control" value="{{ old('parts') }}" placeholder="Scan Label Customer..." autofocus />
            <button class="btn btn-outline-secondary" type="button" id="btnOpenCamera" data-bs-toggle="modal" data-bs-target="#modalParts"
            >
                <i class="bi bi-camera"></i>
            </button>
        </div>
    </div>
</form>

<!-- Modal -->
<div
    class="modal fade"
    id="modalParts"
    tabindex="-1"
    aria-labelledby="modalPartsTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPartsTitle">
                    Scan Label Customer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="stopScanner3()"></button>
            </div>
            <div class="modal-body">
                <div id="qr-reader-3" style="width: 100%"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="stopScanner3()" >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    const modal3 = document.getElementById("modalParts");
    let html5QrCode3 = new Html5Qrcode("qr-reader-3");

    const qrCodeSuccessCallback3 = (decodedText, decodedResult) => {
        if (!canScan) return; // skip kalau masih cooldown
        canScan = false;

        document.getElementById("inputParts").value = decodedText;
        const enterEvent = new KeyboardEvent("keydown", {
            key: "Enter",
            code: "Enter",
            keyCode: 13,
            which: 13,
            bubbles: true,
        });
        document.getElementById("inputParts").dispatchEvent(enterEvent);

        setTimeout(() => {
            canScan = true;
            console.log("🔄 Scan 3 siap lagi");
        }, 2000);
    };

    modal3.addEventListener("shown.bs.modal", function () {
        html5QrCode3
            .start( { facingMode: "environment" }, qrConfig, qrCodeSuccessCallback3 )
            .catch((err) => console.error("Error start scanner:", err));
    });

    function stopScanner3() {
        if (html5QrCode3) {
            html5QrCode3.stop()
                .then(() => {
                    console.log("✅ Scanner Parts berhasil dihentikan");
                })
                .catch(err => {
                    console.error("❌ Gagal stop scanner Parts:", err);
                });
        }
    }

    modal3?.addEventListener("hidden.bs.modal", function () {
        stopScanner3();
    });
</script>
