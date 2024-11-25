<?php
session_start();
require("db-connection.php");
require_once 'security_check.php';
checkAdminAccess();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // Number of records per page
    $recordsPerPage = 7;
    
    // Get current page number
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page); // Ensure page is at least 1
    
    $offset = ($page - 1) * $recordsPerPage;
    
    // Get search query if exists
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    
    // Base SQL for counting total records
    $countSql = "SELECT COUNT(*) as total FROM archive";
    
    // Base SQL for fetching records
    $sql = "SELECT * FROM archive";
    
    // Add search conditions if search query exists
    if ($searchQuery != '') {
        $searchCondition = " WHERE Lot_No LIKE '%$searchQuery%' 
                            OR mem_lots LIKE '%$searchQuery%' 
                            OR mem_sts LIKE '%$searchQuery%' 
                            OR LO_name LIKE '%$searchQuery%'";
        $countSql .= $searchCondition;
        $sql .= $searchCondition;
    }
    
    // Add pagination
    $sql .= " LIMIT $offset, $recordsPerPage";
    
    // Get total records for pagination
    $totalResult = mysqli_query($conn, $countSql);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalRecords = $totalRow['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);
    
    // Get records for current page
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
        /* Previous styles remain the same */
        
        /* Add pagination styles */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .pagination a, .pagination span {
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
    </style>
</head>
<body style="background: #071c14;">
<?php include 'admin_sidebar.php'; ?>
    
    <div id="recordsContent" class="center_record">
        <div class="table-responsive">
            <h1 id="header1">Archive Section</h1>
            <br>
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                    <br>
                    <button class='btn btn-search' type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon">
                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                        </svg>Search
                    </button>
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
                        <th>Timestamp</th>
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
                        <td><?php echo ucwords(strtolower(htmlspecialchars($row['timestamp']))); ?></td>
                    </tr>
                    <tr class="divider-row">
                        <td colspan="6"></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="pagination">
                <?php
                // Previous page link
                if ($page > 1) {
                    echo "<a href='?page=".($page-1)."&search=".urlencode($searchQuery)."'>&laquo; Previous</a>";
                } else {
                    echo "<span class='disabled'>&laquo; Previous</span>";
                }
                
                // Page numbers
                for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
                    if ($i == $page) {
                        echo "<span class='active'>$i</span>";
                    } else {
                        echo "<a href='?page=$i&search=".urlencode($searchQuery)."'>$i</a>";
                    }
                }
                
                // Next page link
                if ($page < $totalPages) {
                    echo "<a href='?page=".($page+1)."&search=".urlencode($searchQuery)."'>Next &raquo;</a>";
                } else {
                    echo "<span class='disabled'>Next &raquo;</span>";
                }
                ?>
            </div>
        </div>
    </div>
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
     // Anti-zoom script remains the same
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
<?php
} else {
    header("Location: index.php");
    exit();
}
?>