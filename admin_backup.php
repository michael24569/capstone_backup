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
    <title>Backup Database</title>
    
    <link rel="stylesheet" href="backupButton.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="logoutmodal.css">
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
.top-left-button {
  fill: white;
  position: absolute;
  top: 10px;
  left: 0px;
  background-color: #4caf4f00;
  border: none;
  padding: 10px;
  cursor: pointer;
}

.top-left-button svg {
  width: 24px;
  height: 24px;
}

.main-content {
  text-align: center;
}
.input-icon {
  width: 24px; /* Adjust icon size */
  height: 24px;
  fill: black; /* Icon color */
  flex-shrink: 0;
  margin-bottom: -22px;

}
.input-group{
    padding: 1% 0;
    position: relative;
  }
  .successful {
            transition: opacity 0.5s ease-out;
        }
</style>
</head>
<body style="background: #071c14;">
<button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>
</button>

<?php include 'admin_sidebar.php'; ?> 

<div class="center_record">
    <div class="container">
        <h1 style= "font-size: 40px;"class="form-title">Backup Database</h1>

        <!-- Form for backup submission -->
        <form action="backupCondition.php" method="POST">
        <div class="input-group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="input-icon">
            <path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
  </div>
            <div class="input-group">
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
                <p id="successful" class="successful" style="color: green; background-color: #dfd; padding-left: 80px; margin-bottom: 10px;">
                    <?= htmlspecialchars($successful) ?>
                </p>
                <!-- Provide download link if backup is successful -->
                <?php if ($backup_file): ?>
                    <a href="downloadBackup.php?file=<?= urlencode($backup_file) ?>" class="button btn-download">Proceed Backup</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

            <button type="submit" class="button btn-edit">Confirm </button>
        </form>
    </div>
</div>
<!-- logout confirmation modal -->
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Logout Confirmation</h2>
        <p>Are you sure you want to logout?</p>
        <div class="modal-buttons">
            <button id="confirmButton" class="btn btn-confirm">Yes, log me out</button>
            <button id="cancelButton" class="btn btn-cancel">No, Stay here</button>
        </div>
    </div>
</div>
               
<script src="script.js"></script>
<script>
  
// anti zooom 
    
        // Prevent zoom using wheel event
        document.addEventListener('wheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        }, { passive: false });

        // Prevent zoom using keydown events
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === '+' || e.key === '-' || e.key === '=')) {
                e.preventDefault();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successful');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.opacity = '0';
                    setTimeout(function() {
                        successMessage.style.display = 'none';
                    }, 500);
                }, 2000);
            }
        });
</script>
<script src="paiyakan.js"></script>


</body>
</html>