<?php
session_start();  // Ensure session is started

if (isset($_POST["id"])) { // Change from $_GET to $_POST
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "simenteryo";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $id = $_POST["id"]; // Now using POST
    $fullname = $_SESSION['fullname'];  // Retrieve the logged-in staff's fullname

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
        
        // Insert into log table
        $logSql = "INSERT INTO record_logs (fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $connection->prepare($logSql);
        $logStmt->bind_param("ssss", $fullname, $lot, $mem_sts, $action);
        $logStmt->execute();
    }

    // Delete the record
    $sql = "DELETE FROM records WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $connection->close();

    // Return success response
    echo 'success';
} else {
    echo 'error'; // Handle case where ID is not set
}
?>
