<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['backup_file'])) {
    $databaseName = trim($_POST['database_name']);
    $backupFile = $_FILES['backup_file']['tmp_name'];
    $fileError = $_FILES['backup_file']['error'];
    
    // Validate database name
    if ($databaseName !== 'simenteryo') {
        die("Error: Database name must be 'simenteryo'. Please enter the correct database name.");
    }

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
                        echo "Error executing statement: " . $conn->error . "<br>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "Error executing statement: " . $e->getMessage() . "<br>";
                }
            }
        }
        echo "Database imported successfully. <a href='index.php'>Go back to login</a>";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Setup Database</title>
    <style>
        .error {
            color: red;
            display: none;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Setup Database</h1>
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="database_name">Database Name:</label>
        <input type="text" id="database_name" name="database_name" required>
        <div id="name_error" class="error">Database name must be 'simenteryo'</div>
        <br><br>
        <label for="backup_file">Select Backup File:</label>
        <input type="file" id="backup_file" name="backup_file" accept=".sql" required>
        <br><br>
        <button type="submit">Upload and Import</button>
    </form>

    <script>
        function validateForm() {
            const databaseName = document.getElementById('database_name').value.trim();
            const errorElement = document.getElementById('name_error');
            
            if (databaseName !== 'simenteryo') {
                errorElement.style.display = 'block';
                return false;
            }
            
            errorElement.style.display = 'none';
            return true;
        }

        // Real-time validation
        document.getElementById('database_name').addEventListener('input', function() {
            const errorElement = document.getElementById('name_error');
            if (this.value.trim() !== 'simenteryo') {
                errorElement.style.display = 'block';
            } else {
                errorElement.style.display = 'none';
            }
        });
    </script>
</body>
</html>