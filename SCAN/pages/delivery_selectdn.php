<?php
include_once("../connection.php");

// Sanitize and trim the input
$dnno = trim($_POST["dnno"]);

// Debugging output to verify input
// echo 'dnno = ' . htmlspecialchars($dnno) . '<br>';

// Check if dnno length is valid
if (strlen($dnno) > 16) {
    header("Location: delivery_smart.php?dn_no=$dnno&&val=scan");
    exit();
}

// Function to check status counts in a given table
function checkStatusCounts($mysqli, $table, $dnno)
{
    // Prepare SQL statement to check 'Open' status
    $stmtOpen = $mysqli->prepare("
        SELECT COUNT(*) AS open_count 
        FROM $table 
        WHERE dn_no = ? AND status = 'Open'
    ");
    $stmtOpen->bind_param("s", $dnno);
    $stmtOpen->execute();
    $resultOpen = $stmtOpen->get_result();
    $rowOpen = $resultOpen->fetch_assoc();
    $openCount = $rowOpen['open_count'];
    $stmtOpen->close();

    // Prepare SQL statement to check 'Close' status
    $stmtClose = $mysqli->prepare("
        SELECT COUNT(*) AS close_count 
        FROM $table 
        WHERE dn_no = ? AND status = 'Close'
    ");
    $stmtClose->bind_param("s", $dnno);
    $stmtClose->execute();
    $resultClose = $stmtClose->get_result();
    $rowClose = $resultClose->fetch_assoc();
    $closeCount = $rowClose['close_count'];
    $stmtClose->close();

    return [
        'openCount' => $openCount,
        'closeCount' => $closeCount
    ];
}

// Check in tbl_deliverynote first
$statusCounts = checkStatusCounts($mysqli, 'tbl_deliverynote', $dnno);

// If no records in tbl_deliverynote, check in tbl_deliveryadm
if ($statusCounts['openCount'] == 0 && $statusCounts['closeCount'] == 0) {
    $statusCounts = checkStatusCounts($mysqli, 'tbl_deliveryadm', $dnno);
}

// If no records in tbl_deliveryadm, check in tbl_deliveryhpm
if ($statusCounts['openCount'] == 0 && $statusCounts['closeCount'] == 0) {
    $statusCounts = checkStatusCounts($mysqli, 'tbl_deliveryhpm', $dnno);
}

// If no records in tbl_deliveryhpm, check in tbl_deliveryhino
if ($statusCounts['openCount'] == 0 && $statusCounts['closeCount'] == 0) {
    $statusCounts = checkStatusCounts($mysqli, 'tbl_deliveryhino', $dnno);
}

// If no records in tbl_deliveryhino, check in tbl_deliverytmmin
if ($statusCounts['openCount'] == 0 && $statusCounts['closeCount'] == 0) {
    $statusCounts = checkStatusCounts($mysqli, 'tbl_deliverytmmin', $dnno);
}

// If no records in tbl_deliverytmmin, check in tbl_deliverysuzuki
if ($statusCounts['openCount'] == 0 && $statusCounts['closeCount'] == 0) {
    $statusCounts = checkStatusCounts($mysqli, 'tbl_deliverysuzuki', $dnno);
}

// Redirect based on the found status counts
if ($statusCounts['openCount'] > 0) {
    // If there's any 'Open' status for the dn_no, proceed to process page
    header("Location: delivery_smart_process.php?dn_no=$dnno&&val=ok");
    exit();
} elseif ($statusCounts['closeCount'] > 0 && $statusCounts['openCount'] == 0) {
    // If all customerpart_no are 'Close' for the dn_no, redirect to complete page
    header("Location: delivery_smart.php?dn_no=$dnno&&val=complete");
    exit();
} else {
    // If there's no matching 'Open' or 'Close' records for the dn_no, or no records at all
    header("Location: delivery_smart.php?val=complete");
    exit();
}
