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
    
    <link rel="stylesheet" href="backupButton.css">
    <link rel="stylesheet" href="style1.css">
<style>
    .sidebar-toggle-btn {
  display: none; /* Default: hidden, visible in responsive view */
  position: absolute; /* Position inside the sidebar */
  top: 20px; /* Adjust position from the top of the sidebar */
  left: 15px; /* Align inside the sidebar */
  background: none; /* No background */
  border: none; /* Remove border */
  padding: 10px;
  cursor: pointer;
  z-index: 1000; /* Ensure it appears above other elements */
}

.sidebar-toggle-btn ion-icon {
  font-size: 2rem; /* Adjust icon size */
  color: white; /* White icon color */
  transition: color 0.3s ease; /* Smooth hover effect */
}

/* Hover effect for toggle button */
.sidebar-toggle-btn:hover ion-icon {
  color: #b3d1b3; /* Change icon color on hover */
}

/* Responsive design for smaller screens */
@media screen and (max-width: 768px) {
  .sidebar-toggle-btn {
    display: block; /* Show the toggle button on smaller screens */
  }

 
  .sidebar.active {
    transform: translateX(0); /* Show sidebar when active */
  }
}
</style>
</head>
<body style="background: #071c14;">
<button id="sidebarToggle" class="sidebar-toggle-btn">
    <ion-icon name="menu-outline"></ion-icon>
</button>

<?php include 'admin_sidebar.php'; ?> 

<div class="center_record">
    <div class="container">
        <h1 style= "font-size: 40px;"class="form-title">Backup Records</h1>

        <!-- Form for backup submission -->
        <form action="backupCondition.php" method="POST">
            <div class="input-group">
            <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Enter Password">
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


</body>
</html>