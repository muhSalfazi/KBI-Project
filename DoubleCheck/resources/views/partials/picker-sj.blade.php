<link rel="stylesheet" href="{{ asset('assets/css/picker.css') }}" />

<div class="d-flex justify-content-center">
    <!-- Komponen picker yang bisa Anda salin ke Blade -->
    <div id="myPicker" class="option-picker">
        <div class="option-picker-item" data-value="1" onclick="manifest()">
            Scan Manifest
        </div>
        <div class="option-picker-item" data-value="2" onclick="parts()">
            Scan Parts
        </div>
    </div>
</div>

<!-- Sertakan JavaScript Bootstrap -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const picker = document.getElementById("myPicker");
        const options = picker.querySelectorAll(".option-picker-item");

        options.forEach((option) => {
            option.addEventListener("click", function () {
                // Hapus kelas 'active' dari semua opsi
                options.forEach((item) => {
                    item.classList.remove("active");
                });

                // Tambahkan kelas 'active' ke opsi yang baru diklik
                this.classList.add("active");
            });
        });
    });

    function manifest() {
        resetForms();
        document.getElementById("form2-container").style.display = "block";
        dataManifest(dateGlobal); // Refresh the manifest table

        const manifestInput = document.getElementById("inputManifest");
        if (manifestInput) {
            manifestInput.focus();
            manifestInput.select();
        }
    }

    function parts() {
        resetForms();
        document.getElementById("form3-container").style.display = "block";
        dataParts(); // Refresh the parts table
    }

    function resetForms() {
        document.getElementById("form2-container").style.display = "none";
        document.getElementById("form3-container").style.display = "none";
    }
</script>
