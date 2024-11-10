<?php
session_start(); // Start session to store messages

$servername = "localhost";
$username = "root";
$password = "";
$database = "simenteryo";

// Establish a connection to the database
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    $_SESSION['error'] = 'Connection failed: ' . $connection->connect_error;
    header("Location: admin_backup.php");
    exit();
}

$connection->set_charset("utf8");

// Function to validate the admin password
function checkAdminPassword($inputPassword, $connection) {
    $query = "SELECT password FROM admin WHERE id = 1"; // Assuming admin ID is 1
    $result = $connection->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        return password_verify($inputPassword, $storedPassword); // Verify hashed passwords
    }
    return false;
}

$inputPassword = $_POST['password'] ?? '';
$error = '';
$successful = '';

// Check if password is empty
if (empty($inputPassword)) {
    $_SESSION['error'] = "Password cannot be null.";
    header("Location: admin_backup.php");
    exit();
}

if (checkAdminPassword($inputPassword, $connection)) {
    // Backup logic for the entire database
    $tables = [];
    $sqlScript = "";

    // Get all tables
    $query = "SHOW TABLES";
    $result = $connection->query($query);

    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    foreach ($tables as $table) {
        $query = "SHOW CREATE TABLE $table";
        $result = $connection->query($query);
        if ($result) {
            $row = $result->fetch_row();
            $sqlScript .= "\n\n" . $row[1] . ";\n\n";
            $query = "SELECT * FROM $table";
            $result = $connection->query($query);
            if ($result) {
                $columnCount = $result->field_count;
                while ($row = $result->fetch_row()) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $sqlScript .= isset($row[$j]) ? '"' . $connection->real_escape_string($row[$j]) . '"' : 'NULL';
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }
        } else {
            $_SESSION['error'] = "Failed to retrieve table structure for $table.";
        }
    }

    if (!empty($sqlScript)) {
        $backup_file_name = 'backup_' . time() . '.sql';
        file_put_contents($backup_file_name, $sqlScript);
        $_SESSION['successful'] = "Backup File is Ready";
        $_SESSION['backup_file'] = $backup_file_name;
        $_SESSION['backup_time'] = time(); // Store the time of backup creation
    } else {
        $_SESSION['error'] = "No data found to backup.";
    }
} else {
    $_SESSION['error'] = "Invalid password. Backup operation not executed.";
}

header("Location: admin_backup.php");
exit();

$connection->close();
?>
