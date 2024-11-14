<?php
session_start(); // Start session to retrieve messages

require_once 'security_check.php';
checkAdminAccess();

$error = $_SESSION['error'] ?? '';
$successful = $_SESSION['successful'] ?? '';
$backup_file = $_SESSION['backup_file'] ?? '';

// Clear session messages after displaying them
unset($_SESSION['error']);
unset($_SESSION['successful']);
unset($_SESSION['backup_file']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Records</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="backupButton.css">
    <link rel="stylesheet" href="style1.css">

</head>
<body style= "font-family: Michroma, sans-serif;" style="background: #071c14;">

<?php include 'admin_sidebar.php'; ?> 

<div class="center_record">
    <div class="container">
        <h1 class="form-title">Backup Records</h1>

        <!-- Form for backup submission -->
        <form action="backupCondition.php" method="POST">
            <div class="input-group">
            <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Enter Password" >
                <label for="password">Password</label>
            </div>

            
        <!-- Display success or error messages -->
        <div id="responseMessage">
            <?php if ($error): ?>
                <p class="error" style="color: red; background-color: #fdd; padding: 10px; margin-bottom: 10px;">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>
            <?php if ($successful): ?>
                <p class="successful" style="color: green; background-color: #dfd; padding-left: 80px; margin-bottom: 10px;">
                    <?= htmlspecialchars($successful) ?>
                </p>
                <!-- Provide download link if backup is successful -->
                <?php if ($backup_file): ?>
                    <a href="downloadBackup.php?file=<?= urlencode($backup_file) ?>" class="btn btn-download">Proceed Backup</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

            <button type="submit" class="btn btn-edit">Confirm</button>
        </form>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>