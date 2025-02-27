<?php  
session_start();

// Allow access for both database error and success message cases
if (!isset($_SESSION['database_error']) && !isset($_SESSION['setup_success'])) {
    header("Location: index.php");
    exit();
}

$error_message = '';
$success_message = '';

// Check for success message
if (isset($_SESSION['setup_success'])) {
    $success_message = $_SESSION['setup_success'];
    unset($_SESSION['setup_success']);
    // Don't unset database_error here to allow viewing the success message
}

$databaseName = 'db_simenteryo';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {     
    if (isset($_FILES['backup_file'])) {         
        $backupFile = $_FILES['backup_file']['tmp_name'];         
        $fileError = $_FILES['backup_file']['error'];                  

        if ($fileError !== UPLOAD_ERR_OK) {             
            $error_message = "Error uploading file: " . $fileError;         
        } else {             
            $conn = new mysqli("localhost", "root", "");             
            if ($conn->connect_error) {                 
                $error_message = "Connection failed: " . $conn->connect_error;             
            } else {                 
                $sql = "CREATE DATABASE IF NOT EXISTS `$databaseName`";                 
                if ($conn->query($sql) === TRUE) {                     
                    $conn->select_db($databaseName);                                          
                    $commands = file_get_contents($backupFile);                                          
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
                        $_SESSION['setup_success'] = "Database imported successfully.";
                        unset($_SESSION['database_error']);
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
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
    <script type="text/javascript">
    // Prevent back navigation
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, null, window.location.href);
    };
    // Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
    </script>
    <style>         
        .error-message {             
            color: red;             
            margin-top: 5px;             
            margin-bottom: 10px;             
            font-size: 14px;         
        }         
        .success-popup {             
            display: none;             
            position: fixed;             
            top: 30%;             
            left: 50%;             
            transform: translate(-50%, -50%);             
            padding: 20px;             
            background-color: #4CAF50;             
            color: white;             
            border-radius: 5px;             
            text-align: center;             
            z-index: 1000;         
        }         
        .overlay {             
            display: none;             
            position: fixed;             
            top: 0;             
            left: 0;             
            width: 100%;             
            height: 100%;             
            background: rgba(0, 0, 0, 0.5);             
            z-index: 999;         
        }     
    </style> 
</head>  
<body>     
    <div class="container">         
        <h1>Setup Database</h1>         
        <form method="post" enctype="multipart/form-data">             
            <?php if (!empty($error_message)): ?>                 
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>             
            <?php endif; ?>             
            <label for="backup_file">Select Backup File:</label>             
            <input type="file" id="backup_file" name="backup_file" accept=".sql" required>             
            <button type="submit">Import Database</button>         
        </form>     
    </div>     
    <div class="overlay" id="overlay"></div>     
    <div class="success-popup" id="success-popup">         
        <?php echo htmlspecialchars($success_message); ?>     
    </div>     
    <?php if (!empty($success_message)): ?>         
        <script>
            document.getElementById('overlay').style.display = 'block';             
            document.getElementById('success-popup').style.display = 'block';             
            setTimeout(function() {                 
                document.getElementById('overlay').style.display = 'none';                 
                document.getElementById('success-popup').style.display = 'none';                 
                window.location.href = "index.php";          
            }, 2000); // Increased timeout to 2 seconds for better visibility
        </script>     
    <?php endif; ?> 
</body> 
</html>