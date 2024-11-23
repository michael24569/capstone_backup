<?php
include 'db-connection.php';
session_start();

require_once 'security_check.php';
checkAdminAccess();

$sql = "SELECT role, fullname, Lot_No, mem_sts, action, timestamp FROM record_logs ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
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

/* Sidebar Toggle Button Styles */
.sidebar-toggle-btn {
    </style>
    <style>
        .sidebar-toggle-btn {
  display: none; /* Default: hidden, visible in responsive view */
  position: absolute; 
  top: 20px;
  left: 15px;
  background: none;
  border: none;
  padding: 10px;
  cursor: pointer;
  z-index: 1000; /* Ensure it appears above other elements */
}

.sidebar-toggle-btn svg {
  font-size: 2rem; /* Adjust icon size */
  color: white; /* White icon color */
  transition: color 0.3s ease; /* Smooth hover effect */
}

/* Hover effect for toggle button */
.sidebar-toggle-btn:hover svg {
  color: #b3d1b3; /* Change icon color on hover */
}

/* Responsive design for smaller screens */
@media screen and (max-width: 768px) {
  .sidebar-toggle-btn {
    display: block; /* Show the toggle button on smaller screens */
  }

  .sidebar {
    transform: translateX(-100%); /* Hide sidebar by default */
    transition: transform 0.3s ease-in-out; /* Smooth transition for sliding effect */
  }

  .sidebar.active {
    transform: translateX(0); /* Show sidebar when active */
  }
}

@media screen and (max-width: 480px) {
  .sidebar {
    width: 50px;
  }

  .sidebar:hover {
    width: 150px;
  }

  .sidebar ul li a .icon {
    min-width: 50px;
    height: 50px;
    font-size: 1.2rem;
  }

  .sidebar ul li a .text {
    font-size: 9px;
  }

  .sidebar .icon-logo .text {
    font-size: 10px;
  }
}

/* Page Content Styling */
.align {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin: 0 auto;
}
.center_record {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin: 0 auto;
}
.align img {
  margin-top: 30px;
  width: 70%;
  height: auto;
  border-radius: 25px;
}

.popup {
  position: absolute;
  width: 50%;
  height: 80%;
  padding: 30px 20px;
  background: #7c9785;
  border-radius: 20px;
  z-index: 2;
  box-sizing: border-box;
  text-align: center;
  justify-content: center;
  align-items: center;
  display: none;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.blur {
  filter: blur(5px); /* Adjust the blur amount as needed */
}

/* Records Table Styling */
.table-responsive {
  margin-top: 20px;
  width: 100%;
  background-color: #f3f3f3;
  border-radius: 10px;
  margin-right: 10px;
  margin-left: 5rem;
  padding: 10px;
}
.audit {
    margin-top: 20px;
    width: 93%;
    background-color: #f3f3f3;
    border-radius: 10px;
    margin-right: 10px;
    margin-left: 5rem;

}

.styled-table {
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 0.9em;
  font-family: 'Poppins', sans-serif;
  width: 100%;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
  background-color: #033512;
  color: #ffffff;
  text-align: center;
}

.styled-table th,
.styled-table td {
  padding: 12px 15px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

.styled-table tr {
  background-color: #ffffff;
}

.styled-table tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.styled-table tr:last-of-type {
  border-bottom: 2px solid #033512;
  
}

.styled-table th {
  font-weight: bold;
  font-size: 1.1em;
}

/* Buttons Styling */
.btn {
  padding: 10px 20px;
  color: #ffffff;
  text-decoration: none;
  border-radius: 5px;
  margin: 2px;
  font-weight: bold;
  font-size: 0.9em;
  display: flex;
}

.btn-add {
  background-color: #4CAF50;
  margin-bottom: 20px;
  display: inline-block;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  text-align: center;
}
.btn-edit {
  background-color: #4CAF50;
  margin-right: 5px;
  
}

.btn-archive {
  background-color: #f44336;
}
.btn-search {
  background-color: #3f2afc;
  margin-left: 10px;
}

/* Aligning Edit and Archive Buttons */
.action-buttons {
  display: flex;
  justify-content: center;
}

.divider-row {
  background-color: #009879;
  height: 2px;
  border: none;
}
.input-group {
  display: flex;
  
}
#header1 {
  text-align: center;
}
#header {
  font-weight: bold;
  padding-left: 20px;
}
.form-control {
  padding-left: 10px;
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
    </style>
</head>
<body>
<<button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>
<?php include 'admin_sidebar.php'; ?>
   
    <div class="audit" >
        <div id="header">
        <h2 >Activity Logs</h2>
        </div>
        <table class="styled-table text-center">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Staff Fullname</th>
                    <th>Lot No.</th>
                    <th>Memorial Name</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['role']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['fullname']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['Lot_No']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_sts']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['action']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['timestamp']))); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
    </script>
<script src="paiyakan.js"></script>
    
</body>
</html>
