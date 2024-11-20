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
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"> 
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <style>
        /* General Styling */
@import url('https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,900&display=swap');
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  scroll-behavior: smooth;
}    @font-face {
    font-family: 'MyFont';
    src: url('fonts/Inter.ttf') format('ttf'),
}
body {
  font-family: 'MyFont';
  height: 100vh;
  background-color: #071c14;";
}
tbody, thead, .form-control, td {
    font-family: 'MyFont';
}
/* Sidebar Styling */
.sidebar {
  bottom: 0px;
  position: fixed;
  width: 60px;
  height: 100vh;
  background: #dee7e2;
  overflow: hidden;
  transition: 0.5s;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  box-shadow: 0 50px 40px black;
}

.sidebar:hover {
  width: 300px;
}

.sidebar ul {
  position: relative;
  height: 100vh;
  right:30px;
}

.sidebar ul li {
  list-style: none;
  
}

.sidebar ul li:hover {
  transition: 0.8s;
  background: #b3d1b3;
}

.sidebar ul li a {
  position: relative;
  display: flex;
  white-space: nowrap;
  text-decoration: none;
}

.sidebar ul li a .icon {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  min-width: 60px;
  height: 60px;
  font-size: 1.5rem;
  color: #222222;
}
.sidebar ul li a .text{
  font-family: 'MyFont';
  position: relative;
  height: 60px;
  display: flex;
  align-items: center;
  font-size: 10px;
  color: #222222;
  text-transform: uppercase;
}

.sidebar .icon-logo {
  margin-bottom: 20px;
}

.sidebar .icon-logo .text {
  font-size: 11px;
  font-weight: 300;
  font-weight: bold;
}

.sidebar .icon-logo .text:hover {
  background: #dee7e2;
}

.bottom {
  position: absolute;
  bottom: 0;
  width: 100%;
}

/* Sidebar toggle button */
/* Sidebar toggle button */
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

  .sidebar {
    transform: translateX(-100%); /* Hide sidebar by default */
    transition: transform 0.3s ease-in-out;
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
    </style>
</head>
<body>
<button id="sidebarToggle" class="sidebar-toggle-btn">
    <ion-icon name="menu-outline"></ion-icon>
</button>s
<?php include 'admin_sidebar.php'; ?>
   
    <div class="audit" >
        <h2 id="header">Activity Logs</h2>
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
</body>
</html>
