<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start(); // Tambahkan ini

session_start();
include_once("../../connection.php");

$user = $_SESSION["id_user"];
$kbndnkbi = $_POST["kbndnkbi"];
$job_no = $_POST["job_no"];
$dndrkbndn = $_POST["kbndn"];
$dn = $_POST["dn"];
$dnno = $dn;
$seq_nos = substr($dndrkbndn, -4);

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

// Cek apakah kombinasi kbicode dan dn_no sudah ada
$check_kbi_query = "SELECT COUNT(*) AS count FROM tbl_kbndelivery WHERE kbicode = '$kbndnkbi' AND dn_no = '$dnno'";
$kbi = mysqli_query($mysqli, $check_kbi_query);
$kbi_data = mysqli_fetch_array($kbi);

// echo "Check existing KBI: " . $kbi_data['count'] . "<br>";
// Jika kombinasi kbicode dan dn_no sudah ada
if ($kbi_data['count'] > 0) {
    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");
    exit();
}

// Ekstraksi invid dari kbndnkbi
$invid = substr($kbndnkbi, 0, -11);

// Ambil job_no berdasarkan invid dari masterpart_mmki
$qjob_nokbi_mmki = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_mmki WHERE InvId = '$invid' AND JobNo = '$job_no'");
$rjob_nokbi_mmki = mysqli_fetch_array($qjob_nokbi_mmki);

// Jika ditemukan di masterpart_mmki, gunakan JobNo tersebut
if ($rjob_nokbi_mmki) {
    $job_nokbi = $rjob_nokbi_mmki['JobNo'];
} else {
    // Jika tidak ditemukan di masterpart_mmki, cek di masterpart_adm
    $qjob_nokbi_adm = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_adm WHERE InvId = '$invid' AND JobNo = '$job_no'");
    $rjob_nokbi_adm = mysqli_fetch_array($qjob_nokbi_adm);

    // Jika ditemukan di masterpart_adm, gunakan JobNo tersebut
    if ($rjob_nokbi_adm) {
        $job_nokbi = $rjob_nokbi_adm['JobNo'];
    } else {
        // Jika tidak ditemukan di masterpart_adm, cek di masterpart_hpm
        $qjob_nokbi_hpm = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_hpm WHERE InvId = '$invid' AND JobNo = '$job_no'");
        $rjob_nokbi_hpm = mysqli_fetch_array($qjob_nokbi_hpm);

        // Jika ditemukan di masterpart_hpm, gunakan JobNo tersebut
        if ($rjob_nokbi_hpm) {
            $job_nokbi = $rjob_nokbi_hpm['JobNo'];
        } else {
            // Jika tidak ditemukan di masterpart_hpm, cek di masterpart_hino
            $qjob_nokbi_hino = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_hino WHERE InvId = '$invid' AND JobNo = '$job_no'");
            $rjob_nokbi_hino = mysqli_fetch_array($qjob_nokbi_hino);

            // Jika ditemukan di masterpart_hino, gunakan JobNo tersebut
            if ($rjob_nokbi_hino) {
                $job_nokbi = $rjob_nokbi_hino['JobNo'];
            } else {
                // Jika tidak ditemukan di masterpart_hino, cek di masterpart_tmmin
                $qjob_nokbi_tmmin = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_tmmin WHERE InvId = '$invid' AND JobNo = '$job_no'");
                $rjob_nokbi_tmmin = mysqli_fetch_array($qjob_nokbi_tmmin);

                // Jika ditemukan di masterpart_tmmin, gunakan JobNo tersebut
                if ($rjob_nokbi_tmmin) {
                    $job_nokbi = $rjob_nokbi_tmmin['JobNo'];
                } else {
                    // Jika tidak ditemukan di masterpart_hino, cek di masterpart_tmmin
                    $qjob_nokbi_suzuki = mysqli_query($mysqli, "SELECT JobNo FROM masterpart_suzuki WHERE InvId = '$invid' AND JobNo = '$job_no'");
                    $rjob_nokbi_suzuki = mysqli_fetch_array($qjob_nokbi_suzuki);

                    // Jika ditemukan di masterpart_suzuki, gunakan JobNo tersebut
                    if ($rjob_nokbi_suzuki) {
                        $job_nokbi = $rjob_nokbi_suzuki['JobNo'];
                    } else {
                        // Jika tidak ditemukan di kedua tabel, arahkan dengan pesan error
                        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");
                        exit();
                }
            }
        }
    }
}

// Jika job_no sesuai
// echo "job_nokbi: " . $job_nokbi . "<br>";
// echo "job_no: " . $job_no . "<br>";
// exit(); // Untuk menghentikan eksekusi script dan memeriksa output

echo "🟡 Sampai sini, cek job_nokbi = $job_nokbi";
exit();
if ($job_nokbi == $job_no) {
    $Insert = mysqli_query($mysqli, "INSERT INTO tbl_kbndelivery (kbndn_no, dn_no, job_no, seq_no, kbicode, user, invid) 
                                     VALUES ('$dndrkbndn', '$dnno', '$job_no', '$seq_nos', '$kbndnkbi', '$user', '$invid')");

    // Query untuk mengecek data dari masterpart_mmki
    $cekqtydelivery_mmki = mysqli_query(
        $mysqli,
        "SELECT 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    tbl_deliverynote.qty_pcs, 
                    masterpart_mmki.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*)*QtyPerKbn AS totalpcs 
                 FROM tbl_kbndelivery 
                 INNER JOIN masterpart_mmki ON masterpart_mmki.JobNo = tbl_kbndelivery.job_no 
                 INNER JOIN tbl_deliverynote ON tbl_deliverynote.dn_no = tbl_kbndelivery.dn_no 
                    AND tbl_deliverynote.job_no = tbl_kbndelivery.job_no 
                 WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no = '$job_no'
                 GROUP BY 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    masterpart_mmki.QtyPerKbn, 
                    tbl_deliverynote.qty_pcs"
    );
    $result_mmki = mysqli_fetch_array($cekqtydelivery_mmki);

    // Query untuk mengecek data dari masterpart_adm
    $cekqtydelivery_adm = mysqli_query(
        $mysqli,
        "SELECT 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    tbl_deliveryadm.qty_pcs, 
                    masterpart_adm.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*)*QtyPerKbn AS totalpcs 
                 FROM tbl_kbndelivery 
                 INNER JOIN masterpart_adm ON masterpart_adm.JobNo = tbl_kbndelivery.job_no 
                 INNER JOIN tbl_deliveryadm ON tbl_deliveryadm.dn_no = tbl_kbndelivery.dn_no 
                    AND tbl_deliveryadm.job_no = tbl_kbndelivery.job_no 
                 WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no = '$job_no'
                 GROUP BY 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    masterpart_adm.QtyPerKbn, 
                    tbl_deliveryadm.qty_pcs"
    );
    $result_adm = mysqli_fetch_array($cekqtydelivery_adm);

    // Query untuk mengecek data dari masterpart_hpm
    $cekqtydelivery_hpm = mysqli_query(
        $mysqli,
        "SELECT 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    tbl_deliveryhpm.qty_pcs, 
                    masterpart_hpm.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*)*QtyPerKbn AS totalpcs 
                 FROM tbl_kbndelivery 
                 INNER JOIN masterpart_hpm ON masterpart_hpm.JobNo = tbl_kbndelivery.job_no 
                 INNER JOIN tbl_deliveryhpm ON tbl_deliveryhpm.dn_no = tbl_kbndelivery.dn_no 
                    AND tbl_deliveryhpm.job_no = tbl_kbndelivery.job_no 
                 WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no = '$job_no'
                 GROUP BY 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    masterpart_hpm.QtyPerKbn, 
                    tbl_deliveryhpm.qty_pcs"
    );
    $result_hpm = mysqli_fetch_array($cekqtydelivery_hpm);

    // Query untuk mengecek data dari masterpart_hino
    $cekqtydelivery_hino = mysqli_query(
        $mysqli,
        "SELECT 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    tbl_deliveryhino.qty_pcs, 
                    masterpart_hino.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*)*QtyPerKbn AS totalpcs 
                 FROM tbl_kbndelivery 
                 INNER JOIN masterpart_hino ON masterpart_hino.JobNo = tbl_kbndelivery.job_no 
                 INNER JOIN tbl_deliveryhino ON tbl_deliveryhino.dn_no = tbl_kbndelivery.dn_no 
                    AND tbl_deliveryhino.job_no = tbl_kbndelivery.job_no 
                 WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no = '$job_no'
                 GROUP BY 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    masterpart_hino.QtyPerKbn, 
                    tbl_deliveryhino.qty_pcs"
    );
    $result_hino = mysqli_fetch_array($cekqtydelivery_hino);

    // Query untuk mengecek data dari masterpart_tmmin
    $cekqtydelivery_tmmin = mysqli_query(
        $mysqli,
        "SELECT 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    tbl_deliverytmmin.qty_pcs, 
                    masterpart_tmmin.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*)*QtyPerKbn AS totalpcs 
                 FROM tbl_kbndelivery 
                 INNER JOIN masterpart_tmmin ON masterpart_tmmin.JobNo = tbl_kbndelivery.job_no 
                 INNER JOIN tbl_deliverytmmin ON tbl_deliverytmmin.dn_no = tbl_kbndelivery.dn_no 
                    AND tbl_deliverytmmin.job_no = tbl_kbndelivery.job_no 
                 WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no = '$job_no'
                 GROUP BY 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    masterpart_tmmin.QtyPerKbn, 
                    tbl_deliverytmmin.qty_pcs"
    );
    $result_tmmin = mysqli_fetch_array($cekqtydelivery_tmmin);

    // Query untuk mengecek data dari masterpart_suzuki
    $cekqtydelivery_suzuki = mysqli_query(
        $mysqli,
        "SELECT 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    tbl_deliverysuzuki.qty_pcs, 
                    masterpart_suzuki.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*)*QtyPerKbn AS totalpcs 
                 FROM tbl_kbndelivery 
                 INNER JOIN masterpart_suzuki ON masterpart_suzuki.JobNo = tbl_kbndelivery.job_no 
                 INNER JOIN tbl_deliverysuzuki ON tbl_deliverysuzuki.dn_no = tbl_kbndelivery.dn_no 
                    AND tbl_deliverysuzuki.job_no = tbl_kbndelivery.job_no 
                 WHERE tbl_kbndelivery.dn_no = '$dnno' AND tbl_kbndelivery.job_no = '$job_no'
                 GROUP BY 
                    tbl_kbndelivery.dn_no, 
                    tbl_kbndelivery.job_no, 
                    masterpart_suzuki.QtyPerKbn, 
                    tbl_deliverysuzuki.qty_pcs"
    );
    $result_suzuki = mysqli_fetch_array($cekqtydelivery_suzuki);

    // Tentukan outstanding berdasarkan tabel yang memiliki data
    if ($result_mmki) {
        // Menggunakan result_mmki untuk outstanding
        $outstanding_mmki = $result_mmki['qty_pcs'] - $result_mmki['totalpcs'];
    } elseif ($result_adm) {
        // Menggunakan result_adm untuk outstanding
        $outstanding_adm = $result_adm['qty_pcs'] - $result_adm['totalpcs'];
    } elseif ($result_hpm) {
        // Menggunakan result_hpm untuk outstanding
        $outstanding_hpm = $result_hpm['qty_pcs'] - $result_hpm['totalpcs'];
    } elseif ($result_hino) {
        // Menggunakan result_hino untuk outstanding
        $outstanding_hino = $result_hino['qty_pcs'] - $result_hino['totalpcs'];
    } elseif ($result_tmmin) {
        // Menggunakan result_tmmin untuk outstanding
        $outstanding_tmmin = $result_tmmin['qty_pcs'] - $result_tmmin['totalpcs'];
    } elseif ($result_suzuki) {
        // Menggunakan result_suzuki untuk outstanding
        $outstanding_suzuki = $result_suzuki['qty_pcs'] - $result_suzuki['totalpcs'];
    } else {
        // Jika tidak ada data untuk outstanding
        $outstanding_mmki = $outstanding_adm = $outstanding_hpm = $outstanding_hino = $outstanding_tmmin = $outstanding_suzuki = 0;
    }

    // Jika salah satu dari outstanding adalah 0
    if ($outstanding_mmki === 0) {
        // Jika outstanding dari result_mmki, update tbl_deliverynote
        $updateStatus = mysqli_query($mysqli, "UPDATE tbl_deliverynote SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
        exit();
    } elseif ($outstanding_adm === 0) {
        // Jika outstanding dari result_adm, update tbl_deliveryadm
        $updateStatus = mysqli_query($mysqli, "UPDATE tbl_deliveryadm SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
        exit();
    } elseif ($outstanding_hpm === 0) {
        // Jika outstanding dari result_hpm, update tbl_deliveryhpm
        $updateStatus = mysqli_query($mysqli, "UPDATE tbl_deliveryhpm SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
        exit();
    } elseif ($outstanding_hino === 0) {
        // Jika outstanding dari result_hino, update tbl_deliveryhino
        $updateStatus = mysqli_query($mysqli, "UPDATE tbl_deliveryhino SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
        exit();
    } elseif ($outstanding_tmmin === 0) {
        // Jika outstanding dari result_tmmin, update tbl_deliverytmmin
        $updateStatus = mysqli_query($mysqli, "UPDATE tbl_deliverytmmin SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
        exit();
    } elseif ($outstanding_suzuki === 0) {
        // Jika outstanding dari result_suzuki, update tbl_deliverysuzuki
        $updateStatus = mysqli_query($mysqli, "UPDATE tbl_deliverysuzuki SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
        exit();
    } else {
        // Jika masih ada outstanding, lanjut ke proses selanjutnya
        header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=ok");
        exit();
    }
    exit();
} else {
    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=noscan");
    exit();
}
}