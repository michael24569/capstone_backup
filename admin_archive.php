<?php
session_start();
require("db-connection.php");

require_once 'security_check.php';
checkAdminAccess();


if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT * FROM archive";
    
    if ($searchQuery != '') {
        $sql .= " WHERE Lot_No LIKE '%$searchQuery%' 
                  OR mem_lots LIKE '%$searchQuery%' 
                  OR mem_sts LIKE '%$searchQuery%' 
                  OR LO_name LIKE '%$searchQuery%'";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive section</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="logoutmodal.css">
    <style>
         @font-face {
    font-family: 'MyFont';
    src: url('fonts/Inter.ttf') format('ttf'),
}
tbody, thead, .form-control, td {
    font-family: 'MyFont';
}
.top-left-button {
  fill: white;
  position: absolute;
  top: 10px;
  left: 10px;
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
    </style>
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
<button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>
<?php include 'admin_sidebar.php'; ?>

    <div id="recordsContent" class="center_record">
        <div class="table-responsive">
        <h1 id="header1">Archive Section</h1>
            <br>
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                    <br>
                    <button class='btn btn-search' type="submit">Search</button>
                </div>
            </form>

            <table class="styled-table text-center">
                <thead>
                    <tr class="bg-dark text-black">
                        <th>Lot No.</th>
                        <th>Memorial Lots</th>
                        <th>Memorial Name</th>
                        <th>Lot owner</th>
                        <th>Address</th>                  
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['Lot_No']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_lots']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_sts']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['LO_name']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_address']))); ?></td>

                    <tr class="divider-row">
                        <td colspan="6"></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- logout confirmation modal -->
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Logout Confirmation</h2>
        <p>Are you sure you want to logout?</p>
        <div class="modal-buttons">
            <button id="confirmButton" class="btn btn-confirm">Confirm</button>
            <button id="cancelButton" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>
               

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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
        });</script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
