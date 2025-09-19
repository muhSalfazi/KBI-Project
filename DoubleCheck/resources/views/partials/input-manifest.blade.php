<form method="POST" id="formManifest">
@csrf

<div class="mb-3">
    <label for="inputManifest" class="form-label">Manifest</label>
    <div class="input-group">
        <input type="text" name="manifest" id="inputManifest" class="form-control" placeholder="Scan Manifest...">
            <button class="btn btn-outline-secondary" type="button" id="btnOpenCamera" data-bs-toggle="modal" data-bs-target="#modalManifest">
            <i class="bi bi-camera"></i>
        </button>
    </div>
</div>
</form>

<!-- Modal -->
<div class="modal fade" id="modalManifest" tabindex="-1" aria-labelledby="modalManifestTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalManifestLabel">Scan Manifest</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="stopScanner2()"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Tempat kamera/preview -->
        <div id="qr-reader-2" style="width:100%"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="stopScanner2()">Tutup</button>
      </div>
    </div>
  </div>
</div>


<script>
    const modal2 = document.getElementById('modalManifest');
    let html5QrCode2 = new Html5Qrcode("qr-reader-2");

    const qrCodeSuccessCallback2 = (decodedText, decodedResult) => {
         if (!canScan) return; // skip kalau masih cooldown
        canScan = false;
        document.getElementById('inputManifest').value = decodedText;

        const enterEvent = new KeyboardEvent("keydown", {
            key: "Enter",
            code: "Enter",
            keyCode: 13,
            which: 13,
            bubbles: true
        });
        document.getElementById('inputManifest').dispatchEvent(enterEvent);
        setTimeout(() => {
            canScan = true;
            console.log("🔄 Scan 2 siap lagi");
        }, 2000);
    };

    modal2.addEventListener('shown.bs.modal', function () {
        html5QrCode2.start({ facingMode: "environment" }, qrConfig, qrCodeSuccessCallback2)
            .catch(err => console.error("Error start scanner:", err));
    });

    function stopScanner2() {
        html5QrCode2.stop().then(() => {
            console.log("Scanner 2 manually stopped");
        }).catch(err => console.error("Failed to stop scanning:", err));

            // Tutup modal
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    }
</script>




