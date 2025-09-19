<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

session_start();
include_once("../../connection.php");

function find_jobno(mysqli $conn, string $invid, string $job_no): ?string {
    $tables = [
        'masterpart_mmki',
        'masterpart_adm',
        'masterpart_hpm',
        'masterpart_hino',
        'masterpart_tmmin',
        'masterpart_suzuki'
    ];

    foreach ($tables as $table) {
        $sql = "SELECT JobNo FROM $table WHERE InvId = '$invid' AND JobNo = '$job_no'";
        $res = mysqli_query($conn, $sql);
        if ($res && $row = mysqli_fetch_assoc($res)) {
            return $row['JobNo'];
        }
    }

    return null;
}

$user = $_SESSION["id_user"];
$kbndnkbi = $_POST["kbndnkbi"];
$job_no = trim($_POST["job_no"]);
$dndrkbndn = $_POST["kbndn"];
$dn = $_POST["dn"];
$dnno = $dn;
$seq_nos = substr($dndrkbndn, -4);
$invid = trim(substr($kbndnkbi, 0, -11));
// print_r($dndrkbndn);
// die;

$check_kbi_query = "SELECT COUNT(*) AS count FROM tbl_kbndelivery WHERE kbicode = '$kbndnkbi' AND dn_no = '$dnno'";
$kbi = mysqli_query($mysqli, $check_kbi_query);
$kbi_data = mysqli_fetch_array($kbi);
if ($kbi_data['count'] > 0) {
    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");
    exit();
}

$job_nokbi = find_jobno($mysqli, $invid, $job_no);
if (!$job_nokbi) {
    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=no");
    exit();
}

if ($job_nokbi == $job_no) {
    $Insert = mysqli_query($mysqli, "INSERT INTO tbl_kbndelivery (kbndn_no, dn_no, job_no, seq_no, kbicode, user, invid)  
                                     VALUES ('$dndrkbndn', '$dnno', '$job_no', '$seq_nos', '$kbndnkbi', '$user', '$invid')");

    $delivery_tables = [
        'mmki' => ['tbl_deliverynote', 'masterpart_mmki'],
        'adm' => ['tbl_deliveryadm', 'masterpart_adm'],
        'hpm' => ['tbl_deliveryhpm', 'masterpart_hpm'],
        'hino' => ['tbl_deliveryhino', 'masterpart_hino'],
        'tmmin' => ['tbl_deliverytmmin', 'masterpart_tmmin'],
        'suzuki' => ['tbl_deliverysuzuki', 'masterpart_suzuki']
    ];

    foreach ($delivery_tables as $brand => [$delivery_table, $master_table]) {
        $query = "SELECT 
                    d.qty_pcs, 
                    m.QtyPerKbn, 
                    COUNT(*) AS total, 
                    COUNT(*) * m.QtyPerKbn AS totalpcs 
                  FROM tbl_kbndelivery t 
                  INNER JOIN $master_table m ON m.JobNo = t.job_no 
                  INNER JOIN $delivery_table d ON d.dn_no = t.dn_no AND d.job_no = t.job_no 
                  WHERE t.dn_no = '$dnno' AND t.job_no = '$job_no'
                  GROUP BY d.qty_pcs, m.QtyPerKbn";

        $res = mysqli_query($mysqli, $query);
        if ($res && $row = mysqli_fetch_assoc($res)) {
            $outstanding = $row['qty_pcs'] - $row['totalpcs'];
            if ($outstanding === 0) {
                mysqli_query($mysqli, "UPDATE $delivery_table SET status = 'Close' WHERE dn_no = '$dnno' AND job_no = '$job_no'");
                header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=complete");
                exit();
            }
            break;
        }
    }

    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=ok");
    exit();
} else {
    header("Location: ../delivery_smart_process.php?dn_no=$dnno&&val=noscan");
    exit();
}
