<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {

    // Fetch search query
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT * FROM staff";
    
    if ($searchQuery != '') {
        $sql .= " WHERE fullname LIKE '%$searchQuery%'";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status in the database
    $sql = "UPDATE staff SET accountStatus = '$newStatus' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff Accounts</title>

    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="logoutmodal.css">
</head>
<body style="background: #071c14;">
<button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>
<?php include 'admin_sidebar.php'; ?>


    <div id="statusAccount" class="center_record">
        <div class="table-responsive">
            <h1 id="header1">Manage  Accounts</h1>
            <br>
            <a href="register.php" class="btn btn-primary btn-add"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>Add new staff account</a>
                <br>
                
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Staff" value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                    <br>
                    <button class='btn btn-search' type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>Search</button>
                    <div class="emailUpdate">
                    <a href="edit_admin.php" class="btn btn-green"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>Edit Admin Information</a>
                    </div>
                </div>
            </form>

            <table class="styled-table text-center">
                <thead>
                    <tr class="bg-dark text-black">
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Account Status</th>
                        <th>Action</th>           
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['fullname']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['username']))); ?></td>
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['email']))); ?></td>
                        <td id="status-<?php echo $row['id']; ?>"><?php echo ucwords(strtolower(htmlspecialchars($row['accountStatus']))); ?></td>
<td class="action-buttons">
<a href="edit_staff.php?id=<?php echo $row['id']; ?>" class="btn btn-green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>Edit</a>
<button 
    id="status-btn-<?php echo $row['id']; ?>"
    class="btn <?php echo $row['accountStatus'] == 'Active' ? 'btn-red' : 'btn-green'; ?>"
    onclick="updateStatus(<?php echo $row['id']; ?>, '<?php echo $row['accountStatus']; ?>')">
    <?php if($row['accountStatus'] == 'Active'): ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128l-192 0c-70.7 0-128-57.3-128-128s57.3-128 128-128l192 0zM576 256c0-106-86-192-192-192L192 64C86 64 0 150 0 256S86 448 192 448l192 0c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
              
        Deactivate
    <?php else: ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M192 64C86 64 0 150 0 256S86 448 192 448l192 0c106 0 192-86 192-192s-86-192-192-192L192 64zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                
        Activate
    <?php endif; ?>
</button>

</td>

                    </tr>
                    <tr class="divider-row">
                        <td colspan="4"></td>
                    </tr>
                    <?php } ?>
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
            <button id="confirmButton" class="btn btn-confirm">Yes, log me out</button>
            <button id="cancelButton" class="btn btn-cancel">No, Stay here</button>
        </div>
    </div>
</div>
               

    <script src="script.js"></script>

    <script>
// Function to update status
function updateStatus(id, currentStatus) {
    const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';

    // Send AJAX request to update status
    fetch('statusCondition.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&status=${newStatus}`
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            // Update the status text and button text without reloading
            document.getElementById(`status-${id}`).textContent = newStatus;
            const button = document.getElementById(`status-btn-${id}`);

            // Create SVG elements based on new status
            const svgIcon = newStatus === 'Active' ? `
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="input-icon">
                   <path d="M384 128c70.7 0 128 57.3 128 128s-57.3 128-128 128l-192 0c-70.7 0-128-57.3-128-128s57.3-128 128-128l192 0zM576 256c0-106-86-192-192-192L192 64C86 64 0 150 0 256S86 448 192 448l192 0c106 0 192-86 192-192zM192 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/>
               </svg>
               Deactivate
            ` : `
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="input-icon">
                   <path d="M192 64C86 64 0 150 0 256S86 448 192 448l192 0c106 0 192-86 192-192s-86-192-192-192L192 64zm192 96a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/>
               </svg>
               Activate
            `;
            button.innerHTML = svgIcon;

            // Update the button's color based on new status
            if (newStatus === 'Active') {
                button.classList.remove('btn-green');
                button.classList.add('btn-red');
            } else {
                button.classList.remove('btn-red');
                button.classList.add('btn-green');
            }

            // Update the onclick attribute with the new status
            button.setAttribute('onclick', `updateStatus(${id}, '${newStatus}')`);
        } else {
            // Display custom notification for failure
            showNotification('Failed to Update Status');
        }
    })
    .catch(error => showNotification(`Error: ${error.message}`));
}

// Function to show custom notification
function showNotification(message) {
    // Inject styles dynamically
    const style = document.createElement('style');
    style.textContent = `
        .notification-popup {
            font-size: 27px;
            align-items: center;
            position: fixed;
            top: 40%;
            right: 40%;
            background: white;
            color: black;
            padding: 45px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            z-index: 100000;
        }
        .notification-popup.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .notification-popup button {
            margin-left:90px;
            margin-top: 30px;
            padding: 10px 20px;
            background: green;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }
        .notification-popup button:hover {
            background: #029902;
        }
    `;
    document.head.appendChild(style);

    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification-popup';
    notification.innerHTML = `
        <div>${message}</div>
        <button onclick="this.parentElement.remove()">Confirm</button>
    `;

    document.body.appendChild(notification);

    // Animate notification
    setTimeout(() => {
        notification.classList.add('visible');
    }, 10);

    // Automatically remove after 5 seconds
    setTimeout(() => {
        notification.classList.remove('visible');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Anti-zoom functionality
document.addEventListener('wheel', function(e) {
    if (e.ctrlKey) {
        e.preventDefault();
    }
}, { passive: false });

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && (e.key === '+' || e.key === '-' || e.key === '=')) {
        e.preventDefault();
    }
});

</script>
<style>
    @font-face {
    font-family: 'MyFont';
    src: url('fonts/Inter.ttf') format('ttf'),
}
tbody, thead, .form-control, td {
    font-family: 'MyFont';
}
      

    .btn-green {
  background-color: #479149;
  justify-content: center;
  display: inline-block;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  text-align: center;
  cursor: pointer;
}
.btn-green:hover {
    background-color: #4CAF50;
}
.btn-red {
  background-color: #c3352b;
  justify-content: center;
  display: inline-block;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  text-align: center;
  cursor: pointer;
}
.btn-red:hover {
    background-color: #f44336;
}
.emailUpdate{
    justify-content: flex-end;
    display: flex;
   margin-left: 950px;
}
.input-group {
    display: flex;
    
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
    
</body>  
<!-- gi -->
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
