<!-- Path: /barcode-delivery/index.php -->
<!DOCTYPE html>
<?php
$lastUpdate = getLastModifiedDate(__DIR__);

function getLastModifiedDate($folder) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
    $lastModified = 0;

    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $mtime = $file->getMTime();
            if ($mtime > $lastModified) {
                $lastModified = $mtime;
            }
        }
    }

    return date("d-m-Y", $lastModified);
}
?>

<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barcode Delivery - Landing Page</title>
  <link rel="icon" type="image/png" sizes="100px" href="MVC/pages/gambar/kbi.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @font-face {
      font-family: 'sf-pro-display';
      src: url('asset/font/SFPRODISPLAYREGULAR.otf') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family: 'sf-pro-display', sans-serif;
    }

    .bg-cover-center {
      background-image: url('asset/kbi.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: auto;
    }

    .bg-dark-overlay::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }

    .content-wrapper {
        position: relative;
        z-index: 2;
    }

    .menu-btn {
      width: 160px;
      height: 160px;
      font-size: 1.5rem;
      font-weight: 400;
      border-radius: 20px;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .footer-text {
      font-size: 0.875rem;
      color: white;
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-cover-center bg-dark-overlay text-center">
    <div class="content-wrapper text-center">
        <img src="asset/logo-kbi.png" alt="KYORAKU Logo" style="max-width: 90%; height:auto; margin-bottom: 10px">
        <h1 class="text-white fw-bold mb-4">Warehouse Delivery System</h1>

        <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
        <a href="dashboard.php" target="_blank" class="menu-btn bg-primary text-decoration-none">Delivery</a>
        <a href="SCAN/" target="_blank" class="menu-btn bg-success text-decoration-none">Scan</a>
        <a href="http://kyoraku-apps.com/sto" target="_blank" class="menu-btn text-decoration-none" style="background-color: #70757b;">STO</a>
        <a href="http://kyoraku-apps.com/spd" target="_blank" class="menu-btn bg-black text-decoration-none">SPD</a>
        </div>

      </div>
      <div class="content-wrapper w-100 px-3 d-flex justify-content-between align-items-center mt-4" style="position: absolute; bottom: 0; left: 0; right: 0;">
          <small class="footer-text">Last Update: <?= $lastUpdate ?></small>
          <small class="footer-text">Kyoraku Blowmolding Indonesia</small>
      </div>
   
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
