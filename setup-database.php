<?php 
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $databaseName = trim($_POST['database_name']);
    
    // Validate database name first
    if ($databaseName !== 'simenteryo') {
        $error_message = "Database name must be 'simenteryo'. Please enter the correct database name.";
    } else if (isset($_FILES['backup_file'])) {
        $backupFile = $_FILES['backup_file']['tmp_name'];
        $fileError = $_FILES['backup_file']['error'];
        
        if ($fileError !== UPLOAD_ERR_OK) {
            $error_message = "Error uploading file: " . $fileError;
        } else {
            // Connect to MySQL without specifying the database
            $conn = new mysqli("localhost", "root", "");
            if ($conn->connect_error) {
                $error_message = "Connection failed: " . $conn->connect_error;
            } else {
                // Create the database if it doesn't exist
                $sql = "CREATE DATABASE IF NOT EXISTS `$databaseName`";
                if ($conn->query($sql) === TRUE) {
                    $conn->select_db($databaseName);
                    
                    // Read the SQL file
                    $commands = file_get_contents($backupFile);
                    
                    // Split commands by the default delimiter
                    $statements = explode(';', $commands);
                    
                    $has_error = false;
                    foreach ($statements as $statement) {
                        $statement = trim($statement);
                        if (!empty($statement)) {
                            try {
                                if ($conn->query($statement) === FALSE) {
                                    $error_message = "Error executing statement: " . $conn->error;
                                    $has_error = true;
                                    break;
                                }
                            } catch (mysqli_sql_exception $e) {
                                $error_message = "Error executing statement: " . $e->getMessage();
                                $has_error = true;
                                break;
                            }
                        }
                    }
                    
                    if (!$has_error) {
                        echo "<div class='message1 success'>Database imported successfully.</div>";
                        echo "<a href='index.php' class='button'>Go back to login</a>";
                    }
                } else {
                    $error_message = "Error creating database: " . $conn->error;
                }
                
                $conn->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Database</title>
    <link rel="stylesheet" href="setupdb.css">
    <style>
        .error-message {
            color: red;
            margin-top: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Setup Database</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="database_name">Database Name:</label>
            <input type="text" id="database_name" name="database_name" required>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <label for="backup_file">Select Backup File:</label>
            <input type="file" id="backup_file" name="backup_file" accept=".sql" required>
            
            <button type="submit">Upload and Import</button>
        </form>
    </div>
</body>
</html>