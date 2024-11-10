<?php
session_start();
require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Section</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">
</head>
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
                    <a href="#">
                        <span class="icon"><ion-icon name="alert-outline"></ion-icon></span>
                        <span class="text">About</span>
                    </a>
                </li>
            </div>
        </ul>
    </div>

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
                        <td><?php echo htmlspecialchars($row['Lot_No']); ?></td>
                        <td><?php echo htmlspecialchars($row['mem_lots']); ?></td>
                        <td><?php echo htmlspecialchars($row['mem_sts']); ?></td>
                        <td><?php echo htmlspecialchars($row['LO_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['mem_address']); ?></td>
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

    <style>
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
            gap: 10px;
        }
        .btn-confirm, .btn-cancel {
            padding: 10px 20px;
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
    </style>
    
    <script>
    function confirmArchive(event, id) {
        event.preventDefault();
        const modal = document.getElementById('confirmModal');
        const confirmButton = document.getElementById('confirmButton');
        const cancelButton = document.getElementById('cancelButton');

        // Show the modal
        modal.style.display = 'flex';

        // Handle Confirm button click
        confirmButton.onclick = function() {
            modal.style.display = 'none';
            console.log('Attempting to archive record with ID:', id);

            // Send the request to archive the record without reloading the page
            fetch('archive.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.text())
            .then(data => {
                console.log('Server response:', data);

                if (data.trim() === 'success') {
                    alert('Record archived successfully.');
                    // Reload the page to refresh the table
                    location.reload();
                } else {
                    alert('Failed to archive the record. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        };

        // Handle Cancel button click
        cancelButton.onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
