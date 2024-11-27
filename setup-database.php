<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['backup_file'])) {
    $databaseName = trim($_POST['database_name']);
    $backupFile = $_FILES['backup_file']['tmp_name'];
    $fileError = $_FILES['backup_file']['error'];

    if ($fileError !== UPLOAD_ERR_OK) {
        die("Error uploading file: " . $fileError);
    }

    // Connect to MySQL without specifying the database
    $conn = new mysqli("localhost", "root", "", "");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$databaseName`";
    if ($conn->query($sql) === TRUE) {
        $conn->select_db($databaseName);

        // Read the SQL file
        $commands = file_get_contents($backupFile);

        // Split commands by the default delimiter
        $statements = explode(';', $commands);

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                try {
                    if ($conn->query($statement) === FALSE) {
                        echo "<div class='message error'>Error executing statement: " . $conn->error . "</div>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo"<div class='message error'>Error executing statement: " . $e->getMessage() . "</div>";
                }
            }
        }
        echo "<div class='message1 success'>Database imported successfully.</div>";
        echo "<a href='index.php' class='button'>Go back to login</a>";
    } else {
        echo "<div class='message error'>Error creating database: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Database</title>
    <link rel="stylesheet" href="setupdb.css">
</head>

<body>
    <div class="container">
        <h1>Setup Database</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="database_name">Database Name:</label>
            <input type="text" id="database_name" name="database_name" required>

            <label for="backup_file">Select Backup File:</label>
            <input type="file" id="backup_file" name="backup_file" accept=".sql" required>

            <button type="submit">Upload and Import</button>
        </form>
    </div>
</body>
</html>
