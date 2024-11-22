<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

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
        /* Modal styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            display: none; /* Start hidden */
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            gap: 10px;
        }
        .btn-confirm, .btn-cancel {
            padding: 10px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-confirm {
            background-color: #28a745;
            color: white;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        .alert {
            position: fixed;
            top: 20%;
            right: 38%;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            display: none;
            z-index: 1000;
        }
        .alert-success {
            background-color: #28a745;
        }
        .alert-error {
            background-color: #dc3545;
        }
    </style>
</head>

<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="sweetalert/jquery-3.7.1.min.js"></script>
<script src="sweetalert/sweetalert2.all.min.js"></script>
<body style="background: #071c14;"> 
<button id="sidebarToggle" class="sidebar-toggle-btn">
    <ion-icon name="menu-outline"></ion-icon>
</button>
<?php include 'admin_sidebar.php'; ?>
    <div id="recordsContent" class="center_record">
    <!-- Success/Error Alert Box -->
    <div id="alertBox" class="alert"></div>
<div id="recordsContent" class="center_record">
    <div class="table-responsive">
        <h1 id="header1">Records Section</h1>
        <a class="btn btn-primary btn-add" href="admin_addRecord.php" role="button">Add new record</a>
        <br>
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <br>
                <button class='btn btn-search' type="submit">Search</button> 
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
                        <a class='btn btn-edit' href='admin_update.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>Edit</a>
                        <a href="admin_archiveCondition.php?id=<?= $row['id']; ?>" class="btn btn-archive">Archive</a>

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

<!-- Custom confirmation modal
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to archive this record?</p>
        <div class="modal-buttons">
            <button id="confirmButton" class="btn btn-confirm">Confirm</button>
            <button id="cancelButton" class="btn btn-cancel">Cancel</button>
        </div>
    </div>
</div>
                -->
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

<script>
    /* Confirm Archive function
    function confirmArchive(event, id) {
        event.preventDefault();
        const modal = document.getElementById('confirmModal');
        modal.style.display = 'flex';

        document.getElementById('confirmButton').onclick = function() {
            window.location.href = 'archive.php?id=' + id;
        };

        document.getElementById('cancelButton').onclick = function() {
            modal.style.display = 'none';
        };
    }*/
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
</script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}

