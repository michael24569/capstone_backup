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

    $sql = "SELECT * FROM records";
    
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

    // Check if records exist
    $noRecords = mysqli_num_rows($result) == 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Section</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">

    <style>
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
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<body>
<div class="sidebar" id="sidebar">
    <ul>
            <li class="icon-logo">
                <a href="#">
                    <span class="icon"><ion-icon name="help-buoy"></ion-icon></span>
                    <span class="text">Tagaytay Memorial Park</span>
                </a>
            </li>
            <li>
                <a href="home.php" onclick="showHome()">
                    <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="records.php" onclick="showRecords()">
                    <span class="icon"><ion-icon name="book-outline"></ion-icon></span>
                    <span class="text">Records</span>
                </a>
            </li>
           
            <div class="bottom">
                <li>
                    <a href="logout.php">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="text">Logout</span>
                    </a>
                </li>
                <li>
                    <a href="about.html">
                        <span class="icon"><ion-icon name="alert-outline"></ion-icon></span>
                        <span class="text">About</span>
                    </a>
                </li>
            </div>
        </ul>
    </div>


    <div id="recordsContent" class="center_record">
    <!-- Success/Error Alert Box -->
    <div id="alertBox" class="alert"></div>
<div id="recordsContent" class="center_record">
    <div class="table-responsive">
        <h1 id="header1">Records Section</h1>
        <a class="btn btn-primary btn-add" href="addRecord.php" role="button">Add new record</a>
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
                    <td><?php echo strtolower(htmlspecialchars($row['Lot_No'])); ?></td>
                    <td><?php echo strtolower(htmlspecialchars($row['mem_lots'])); ?></td>
                    <td><?php echo strtolower(htmlspecialchars($row['mem_sts'])); ?></td>
                    <td><?php echo strtolower(htmlspecialchars($row['LO_name'])); ?></td>
                    <td><?php echo strtolower(htmlspecialchars($row['mem_address'])); ?></td>
                    <td class="action-buttons">
                        <a class='btn btn-edit' href='update.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>Edit</a>
                        <a class='btn btn-archive' href='#' onclick="confirmArchive(event, '<?php echo htmlspecialchars($row["id"]); ?>')">Archive</a>
                    </td>
                </tr>
                <tr class="divider-row">
                    <td colspan="6"></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Custom confirmation modal -->
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to archive this record?</p>
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

<script>
    // Confirm Archive function
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
    }

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

