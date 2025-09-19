<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Scanner Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 1.1em;
        }
        textarea {
            height: 150px;
        }
        .row {
            display: flex;
            gap: 10px;
        }
        .row input {
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Scanner Test Page</h2>
    <p>Fokuskan kursor di kolom input lalu tekan tombol <strong>SCAN</strong> pada perangkatmu.</p>

    <label for="scanInput">Scan Input</label>
    <input type="text" id="scanInput" placeholder="Scan di sini..." autofocus>

    <div class="row">
        <div style="flex: 1;">
            <label for="barcode1">Barcode 1</label>
            <input type="text" id="barcode1" placeholder="Hasil pertama" readonly>
        </div>
        <div style="flex: 1;">
            <label for="barcode2">Barcode 2</label>
            <input type="text" id="barcode2" placeholder="Hasil kedua" readonly>
        </div>
    </div>

    <label for="scanLog">Log Hasil Scan (riwayat):</label>
    <textarea id="scanLog" readonly></textarea>

    <script>
        const scanInput = document.getElementById('scanInput');
        const barcode1 = document.getElementById('barcode1');
        const barcode2 = document.getElementById('barcode2');
        const scanLog = document.getElementById('scanLog');

        scanInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                const scanned = scanInput.value.trim();
                if (scanned !== "") {
                    // Pisahkan dua bagian berdasarkan spasi panjang (1 atau lebih)
                    const parts = scanned.split(/\s{2,}/); // split jika ada 2 spasi atau lebih

                    barcode1.value = parts[0] || '';
                    barcode2.value = parts[1] || '';

                    // Tambahkan ke log
                    const waktu = new Date().toLocaleTimeString();
                    scanLog.value = `[${waktu}] ${parts[0] || ''} | ${parts[1] || ''}\n` + scanLog.value;

                    // Reset scan input
                    scanInput.value = "";
                }
            }
        });
    </script>
</body>
</html>
