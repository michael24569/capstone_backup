<?php
require("db-connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['status']);

    // Check the number of active accounts
    $result = mysqli_query($conn, "SELECT COUNT(*) as active_count FROM staff WHERE accountStatus = 'Active'");
    $row = mysqli_fetch_assoc($result);

    if ($row['active_count'] >= 3 && $newStatus == 'Active') {
        echo 'max_reached';
    } else {
        // Update the status in the database
        $sql = "UPDATE staff SET accountStatus = '$newStatus' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>
