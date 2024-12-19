<?php
session_start(); 
require_once 'security_check.php';
checkStaffAccess();

if (isset($_GET["id"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "simenteryo";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $id = $_GET["id"];
    $fullname = $_SESSION['fullname'];
    $userRole = $_SESSION['role'];

    $sql = "SELECT * FROM records WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $lot = $row['Lot_No'];
        $mem_sts = $row['mem_sts'];
        $action = "archived"; 
        
        // Insert log entry
        $logSql = "INSERT INTO record_logs (role, fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
        $logStmt = $connection->prepare($logSql);
        $logStmt->bind_param("sssss", $userRole, $fullname, $lot, $mem_sts, $action);
        $logStmt->execute();
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
        // Insert record into archive table
        $archiveSql = "INSERT INTO archive ( Lot_No, mem_lots, mem_sts, LO_name, mem_address, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
        $archiveStmt = $connection->prepare($archiveSql);
        $archiveStmt->bind_param("sssss", $row['Lot_No'], $row['mem_lots'], $row['mem_sts'], $row['LO_name'], $row['mem_address']);
        $archiveStmt->execute();
    }

    // Delete the record from the records table
    $sql = "DELETE FROM records WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $connection->close();

    // Redirect with success message
    header("Location: records.php?m=1");
    exit();
} else {
    header("Location: records.php?status=error");
    exit();
}
?>
