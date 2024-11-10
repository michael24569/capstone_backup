<?php
session_start(); 
require_once 'security_check.php';
checkAdminAccess();

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

    $sql = "SELECT Lot_No, mem_sts FROM records WHERE id = ?";
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
        $logSql = "INSERT INTO record_logs (role,fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
        $logStmt = $connection->prepare($logSql);
        $logStmt->bind_param("sssss",  $userRole, $fullname, $lot, $mem_sts, $action);
        $logStmt->execute();
    }

    // Delete the record
    $sql = "DELETE FROM records WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $connection->close();

    // Redirect with success message
    header("Location: admin_records.php?status=success");
    exit();
} else {
    header("Location: admin_records.php?status=error");
    exit();
}
