<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $records_per_page = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start_from = ($page-1) * $records_per_page;
    
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $searchField = isset($_GET['field']) ? mysqli_real_escape_string($conn, $_GET['field']) : 'Lot_No';
    
    // Get total number of records
    $total_query = "SELECT COUNT(*) as total FROM records";
    if ($searchQuery != '') {
        $total_query .= " WHERE $searchField LIKE '%$searchQuery%'";
    }
    
    $result = mysqli_query($conn, $total_query);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    // Get records for current page
    $query = "SELECT * FROM records";
    if ($searchQuery != '') {
        // Use the selected field for searching
        $query .= " WHERE $searchField LIKE '%$searchQuery%'";
    }
    $query .= " LIMIT $start_from, $records_per_page";
    $result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Section</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="logoutmodal.css">

    <style>
        /* Previous styles remain the same */
       
       
        tbody, thead, .form-control, td {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;

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
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loading-spinner::after {
            content: "";
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn-edit {
            justify-content: center;
            text-align:center;
            padding-top:10px;
            width: 100px;
            height: 40px;
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
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5px 0;
            gap: 5px;
        }

        .pagination a {
            color: white;
            padding: 3px 8px;
            text-decoration: none;
            background-color: #4CAF50;
            border-radius: 4px;
            margin: 0 2px;
        }

        .pagination-info {
            text-align: center;
            color: white;
            margin: 4px 0;
        }

        .pagination a.active {
            background-color: #45a049;
            color: white;
        }

        .pagination a:hover:not(.active) {
            background-color: #45a049;
        }

        .disabled {
            background-color: #cccccc !important;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* New styles for search input */
        #searchInput {
            width: 20%;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #ddd;
            border-radius: 4px;     
        }
.clear-button {
    cursor: pointer;
    position: absolute;
    left: 32.5%; /* Adjust based on your design */
    top: 19.6%;
    transform: translateY(-50%);
    font-size: 25px; /* Adjust size as needed */
    color: #aaa; /* Color of the clear button */
}
.display {
    display: flex;
}
.select {
    height: 40px;
    margin-right: 10px;
    padding-left: 5px;
    font-family: 'MyFont';
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
        <div id="alertBox" class="alert"></div>
        <div class="table-responsive">
            <h1 id="header1">Records Section</h1>
            <a class="btn btn-add" href="admin_addRecord.php" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="input-icon">
                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                </svg>
                Add new record
            </a>
            <br>
           <div class="display">
           <select id="searchField" class="select" style="width: 150px;">
        <option value="Lot_No">Lot No.</option>
        <option value="mem_lots">Memorial Lots</option>
        <option value="mem_sts">Memorial Name</option>
        <option value="LO_name">Lot Owner</option>
    </select>
            <input class="form-control" type="text" id="searchInput" placeholder="Search records..." autocomplete="off">
            <span id="clearButton" class="clear-button" style="display: none;">&times;</span>
           </div>
            
            <table class="styled-table text-center">
                <thead>
                    <tr class="bg-dark text-black">
                        <th>Lot/Slot No.</th>
                        <th>Memorial Lots</th>
                        <th>Memorial Name</th>
                        <th>Lot Owner</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    <?php 
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr data-id="<?php echo $row['id']; ?>">
                            <td><?php echo ucwords(strtolower($row['Lot_No'])); ?></td>
                            <td><?php echo ucwords(strtolower($row['mem_lots'])); ?></td>
                            <td><?php echo ucwords(strtolower($row['mem_sts'])); ?></td>
                            <td><?php echo ucwords(strtolower($row['LO_name'])); ?></td>
                            <td><?php echo ucwords(strtolower($row['mem_address'])); ?></td>
                            <td class="action-buttons">
                                <a class='btn btn-edit' href='admin_update.php?id=<?php echo $row['id']; ?>'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>Edit</a>
                            </td>
                        </tr>
                        <tr class="divider-row">
                            <td colspan="6"></td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-info" id="paginationInfo">
                Page <?php echo $page; ?> of <?php echo $total_pages; ?>
            </div>
            <div class="pagination" id="paginationLinks">
                <?php if($total_pages > 0) : ?>
    <a href="?page=1<?php echo $searchQuery ? '&search='.$searchQuery.'&field='.$searchField : ''; ?>" 
       class="<?php echo $page <= 1 ? 'disabled' : ''; ?>">First</a>
    
    <a href="?page=<?php echo ($page-1); echo $searchQuery ? '&search='.$searchQuery.'&field='.$searchField : ''; ?>" 
       class="<?php echo $page <= 1 ? 'disabled' : ''; ?>">←</a>

    <?php for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++) : ?>
        <a href="?page=<?php echo $i; echo $searchQuery ? '&search='.$searchQuery.'&field='.$searchField : ''; ?>" 
           class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <a href="?page=<?php echo ($page+1); echo $searchQuery ? '&search='.$searchQuery.'&field='.$searchField : ''; ?>" 
       class="<?php echo $page >= $total_pages ? 'disabled' : ''; ?>">→</a>
    
    <a href="?page=<?php echo $total_pages; echo $searchQuery ? '&search='.$searchQuery.'&field='.$searchField : ''; ?>" 
       class="<?php echo $page >= $total_pages ? 'disabled' : ''; ?>">Last</a>
<?php endif; ?>
            </div>
        </div>
    </div>

                             <!-- Logout confirmation modal -->
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
    // Dynamic search functionality
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchField = document.getElementById('searchField');
    const clearButton = document.getElementById('clearButton');

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const searchValue = urlParams.get('search');
    const fieldValue = urlParams.get('field');

    // Set initial values from URL parameters
    if (searchValue) {
        searchInput.value = searchValue;
        clearButton.style.display = 'block';
    }
    if (fieldValue) {
        searchField.value = fieldValue;
    }

    function performSearch() {
        const searchQuery = searchInput.value.trim();
        const selectedField = searchField.value;
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `dynamic_pagination.php?search=${encodeURIComponent(searchQuery)}&field=${encodeURIComponent(selectedField)}`, true);
        
        xhr.onload = function() {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                
                // Update table body
                const tableBody = document.getElementById('recordsTableBody');
                tableBody.innerHTML = response.records || '<tr><td colspan="6">No records found</td></tr>';
                
                // Update pagination info and links while preserving search parameters
                document.getElementById('paginationInfo').innerHTML = response.pagination_info || '';
                document.getElementById('paginationLinks').innerHTML = response.pagination_links || '';
                
                // Update URL without refreshing the page
                const newUrl = window.location.pathname + 
                    `?search=${encodeURIComponent(searchQuery)}&field=${encodeURIComponent(selectedField)}`;
                window.history.pushState({ path: newUrl }, '', newUrl);
            }
        };
        
        xhr.send();
    }

    // Event listeners
    searchInput.addEventListener('input', function() {
        if (this.value) {
            clearButton.style.display = 'block';
        } else {
            clearButton.style.display = 'none';
        }
        performSearch();
    });

    searchField.addEventListener('change', performSearch);

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        clearButton.style.display = 'none';
        searchInput.focus();
        performSearch();
    });
});

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

        // clear search

        searchInput.addEventListener('input', function () {
        if (searchInput.value) {
            clearButton.style.display = 'block'; // Show clear button
        } else {
            clearButton.style.display = 'none'; // Hide clear button
        }
    });

    // Clear the input field when the clear button is clicked
    clearButton.addEventListener('click', function () {
        searchInput.value = ''; // Clear the input
        clearButton.style.display = 'none'; // Hide the clear button
        searchInput.focus(); // Optionally focus back on the input
        document.getElementById("suggestions").style.display = "none";
        clearHighlights();
    });

// for the clear button 
// Update the clear button event listener
clearButton.addEventListener('click', function () {
    searchInput.value = ''; // Clear the input
    clearButton.style.display = 'none'; // Hide the clear button
    searchInput.focus(); // Focus back on the input
    
    // Trigger the search with empty value to refresh the results
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'dynamic_pagination.php?search=', true);
    
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            
            // Update table body
            const tableBody = document.getElementById('recordsTableBody');
            tableBody.innerHTML = response.records || '<tr><td colspan="6">No records found</td></tr>';
            
            // Update pagination info
            document.getElementById('paginationInfo').innerHTML = response.pagination_info || '';
            
            // Update pagination links
            document.getElementById('paginationLinks').innerHTML = response.pagination_links || '';
        }
    };
    
    xhr.send();
    
    // Hide suggestions if they exist
    if (document.getElementById("suggestions")) {
        document.getElementById("suggestions").style.display = "none";
    }
    
    // Clear highlights if that function exists
    if (typeof clearHighlights === 'function') {
        clearHighlights();
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