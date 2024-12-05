<?php
include 'db-connection.php';
session_start();

require_once 'security_check.php';
checkAdminAccess();

// Pagination settings
$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $recordsPerPage;

// Get total records count
$countSql = "SELECT COUNT(*) as total FROM record_logs";
$totalResult = mysqli_query($conn, $countSql);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get records for current page
$sql = "SELECT role, fullname, Lot_No, mem_sts, action, timestamp 
        FROM record_logs 
        ORDER BY timestamp DESC 
        LIMIT $offset, $recordsPerPage";
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
        .main-container {
            padding: 20px;
            margin-left: 5rem;
            width: calc(100% - 5rem);
        }

        .table-container {
            background-color: #f3f3f3;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .table-header {
            margin-bottom: 20px;
            text-align: center;
        }

        .styled-table {
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 0.9em;
            font-family: 'MyFont';
            width: 100%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            background-color: white;
        }

        .styled-table thead tr {
            background-color: #033512;
            color: white;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f8f8f8;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 10px 0;
        }
        
        .pagination a, 
        .pagination span {
            padding: 8px 16px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .pagination a:hover {
            background-color: #45a049;
        }
        
        .pagination .active {
            background-color: #367c39;
        }
        
        .pagination .disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .top-left-button {
            fill: white;
            position: absolute;
            top: 10px;
            left: 0px;
            background-color: transparent;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .top-left-button svg {
            width: 24px;
            height: 24px;
        }

        @media screen and (max-width: 768px) {
            .main-container {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }

            .table-container {
                padding: 10px;
            }

            .styled-table {
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <button class="top-left-button" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
        </svg>
    </button>

    <?php include 'admin_sidebar.php'; ?>
   
    <div class="main-container">
        <div class="table-container">
            <div class="table-header">
                <h1>Activity Logs</h1>
            </div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>User Fullname</th>
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

            <div class="pagination">
                <?php
                // Previous page link
                if ($page > 1) {
                    echo "<a href='?page=" . ($page-1) . "'>&laquo; Previous</a>";
                } else {
                    echo "<span class='disabled'>&laquo; Previous</span>";
                }
                
                // Page numbers
                for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
                    if ($i == $page) {
                        echo "<span class='active'>$i</span>";
                    } else {
                        echo "<a href='?page=$i'>$i</a>";
                    }
                }
                
                // Next page link
                if ($page < $totalPages) {
                    echo "<a href='?page=" . ($page+1) . "'>Next &raquo;</a>";
                } else {
                    echo "<span class='disabled'>Next &raquo;</span>";
                }
                ?>
            </div>
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
    <script src="paiyakan.js"></script>
    <script>
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
</body>
</html>