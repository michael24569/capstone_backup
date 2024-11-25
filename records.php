<?php
session_start();

require_once 'security_check.php';
checkStaffAccess();

require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    if (isset($_GET['refresh'])) {
        $searchQuery = ''; // Clear search query
    } else {
        $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    }
    $itemsPerPage = 100; // Define items per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $itemsPerPage;

    // Use prepared statements for security
    $sql = "SELECT Lot_No, mem_lots, mem_sts, LO_name, mem_address, id FROM records";
    if ($searchQuery != '') {
        $sql .= " WHERE Lot_No LIKE ? OR mem_lots LIKE ? OR mem_sts LIKE ? OR LO_name LIKE ?";
    }
    $sql .= " LIMIT ?, ?";
    $stmt = $conn->prepare($sql);

    if ($searchQuery != '') {
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param('ssssii', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $offset, $itemsPerPage);
    } else {
        $stmt->bind_param('ii', $offset, $itemsPerPage);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $noRecords = $result->num_rows == 0;

    $stmtTotal = $conn->prepare("SELECT COUNT(*) as total FROM records");
    $stmtTotal->execute();
    $totalResult = $stmtTotal->get_result()->fetch_assoc();
    $totalRecords = $totalResult['total'];
    $totalPages = ceil($totalRecords / $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Section</title>
    <link rel="stylesheet" href="style1.css">

    <style>
    .sidebar-toggle-btn {
  display: none; /* Default: hidden, visible in responsive view */
  position: absolute; /* Position inside the sidebar */
  top: 20px; /* Adjust position from the top of the sidebar */
  left: -5px; /* Align inside the sidebar */
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
           @font-face {
    font-family: 'MyFont';
    src: url('fonts/Inter.ttf') format('ttf'),
}
tbody, thead, .form-control, td {
    font-family: 'MyFont';
}
        .refresh-icon {
            background-color: #00000093;
            margin-left: 10px;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            border-radius: 40%; 
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            margin-top: 10px;
            justify-content: center;
            width: 30px;
            height: 30px;
        }
        .refresh-icon:hover {
            background-color: gray;
        }
        .refresh-icon:hover .icon {
            animation: spin 1s linear; 
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<link rel="stylesheet" href="logoutmodal.css">
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="sweetalert/jquery-3.7.1.min.js"></script>
<script src="sweetalert/sweetalert2.all.min.js"></script>

<body style="background: #071c14;"> 
<button id="sidebarToggle" class="sidebar-toggle-btn">
    <ion-icon name="menu-outline"></ion-icon>
</button>
<?php include 'staff_sidebar.php'; ?>
    <div id="recordsContent" class="center_record">
    <!-- Success/Error Alert Box -->
    <div id="alertBox" class="alert"></div>
<div id="recordsContent" class="center_record">
    <div class="table-responsive">
        <h1 id="header1">Records Section</h1>
        <a class="btn btn-primary btn-add" href="addRecord.php" role="button">Add new record <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="height: 19px; margin-left: 5px; fill:white;"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></a>
        <br>
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                <br>
                <button class='btn btn-search' type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height:20px; fill:white;"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>Search</button> 
                <button class="refresh-icon" type="submit" name="refresh" value="1">
                    <span class="icon">&#x21bb;</span> 
                </button>
            </div>
        </form>
        <table class="styled-table text-center">
            <thead>
                <tr class="bg-dark text-black">
                    <th>Lot No.</th>
                    <th>Memorial Lots</th>
                    <th>Memorial Name</th>
                    <th>Lot Owner</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr data-id="<?php echo htmlspecialchars($row['id']); ?>">
                <td><?php echo ucwords(strtolower(htmlspecialchars($row['Lot_No']))); ?></td>
                <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_lots']))); ?></td>
                <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_sts']))); ?></td>
                <td><?php echo ucwords(strtolower(htmlspecialchars($row['LO_name']))); ?></td>
                <td><?php echo ucwords(strtolower(htmlspecialchars($row['mem_address']))); ?></td>

                    <td class="action-buttons">
                        <a class='btn btn-edit' href='update.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>Edit</a>
                        <a href="archive.php?id=<?= $row['id']; ?>" class="btn btn-archive">Archive</a>

                    </td>
                </tr>
                <tr class="divider-row">
                    <td colspan="6"></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (isset($_GET['m'])) : ?>
            <div class="flash-data" data-flashdata="<?= htmlspecialchars($_GET['m']); ?>"></div>
        <?php endif; ?> 

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
               

<!-- No Records Modal -->
<div id="noRecordsModal" class="modal">
    <div class="modal-content">
        <h5>No Records Found</h5>
        <p>No records found matching your search criteria.</p>
        <div class="modal-buttons">
            <button class="btn btn-cancel" onclick="document.getElementById('noRecordsModal').style.display='none'">Close</button>
        </div>
    </div>
</div>


    <script src="script.js"></script>
<script>

    $(document).ready(function () {
    // Event listener for the archive button
    $('.btn-archive').on('click', function (e) {
        e.preventDefault(); // Prevent the default anchor click action
        const href = $(this).attr('href'); // Get the URL from the href attribute

        Swal.fire({
            title: 'Are you sure?',
            text: 'Record will be archived!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the archive link if confirmed
                document.location.href = href;
            }
        });
    });

    // Handle flash messages
    const flashdata = $('.flash-data').data('flashdata');
    if (flashdata) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Record has been archived.',
        });
    }
});


    // Show modal if no records found
    <?php if ($noRecords): ?>
        document.getElementById('noRecordsModal').style.display = 'flex';
    <?php endif; ?>

    function showAlert(message, type) {
        const alertBox = document.getElementById('alertBox');
        alertBox.className = 'alert ' + (type === 'success' ? 'alert-success' : 'alert-error');
        alertBox.textContent = message;
        alertBox.style.display = 'block';

        // Hide alert after 3 seconds
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 3000);
    }

    // Show alert based on URL parameter
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        showAlert('Record archived successfully.', 'success');
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        showAlert('Error archiving record.', 'error');
    <?php endif; ?>


    
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
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}

