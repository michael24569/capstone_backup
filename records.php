<?php
session_start();

require_once 'security_check.php';
checkStaffAccess();

require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $records_per_page = 7;
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $page = ($page !== false && $page > 0) ? $page : 1;
    $start_from = ($page-1) * $records_per_page;
    
    $searchQuery = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING) ?? '';
    $searchField = filter_input(INPUT_GET, 'field', FILTER_SANITIZE_STRING) ?? 'Lot_No';
    
    // Validate search field to prevent SQL injection
    $allowed_fields = ['Lot_No', 'mem_lots', 'mem_sts', 'LO_name'];
    if (!in_array($searchField, $allowed_fields)) {
        $searchField = 'Lot_No';
    }

    // Get total number of records using prepared statement
    if ($searchQuery != '') {
        $total_query = "SELECT COUNT(*) as total FROM records WHERE $searchField LIKE ?";
        $stmt = mysqli_prepare($conn, $total_query);
        $searchParam = "%$searchQuery%";
        mysqli_stmt_bind_param($stmt, "s", $searchParam);
    } else {
        $total_query = "SELECT COUNT(*) as total FROM records";
        $stmt = mysqli_prepare($conn, $total_query);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    // Get records for current page using prepared statement
    if ($searchQuery != '') {
        $query = "SELECT * FROM records WHERE $searchField LIKE ? LIMIT ?, ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sii", $searchParam, $start_from, $records_per_page);
    } else {
        $query = "SELECT * FROM records LIMIT ?, ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $start_from, $records_per_page);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Generate CSRF token
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

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
            text-align: center;
            padding: 10px 20px;
            width: auto;
            height: auto;
            background-color: #5aad5c;
            color: white;
            border: none;
            border-radius: 5px;
            transition: transform 0.3s ease, background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-edit:hover {
            transform: translateY(-5px);
            background-color: #479149;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-edit svg {
            fill: white;
            width: 16px;
            height: 16px;
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
            color: black;
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
            border: 2px solid #002d1c;
            border-radius: 20px;     
        }
.clear-button {
    cursor: pointer;
    position: absolute;
    left: 32.5%; /* Adjust based on your design */
    top: 15.3%;
    transform: translateY(-50%);
    font-size: 25px; /* Adjust size as needed */
    color: #aaa; /* Color of the clear button */
}
.select {
    border-collapse: collapse;
    height: 40px;
    margin-right: 10px;
    padding: 5px 10px;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    border: 2px solid #002d1c;
    border-radius: 20px;
    background-color: transparent;
    color: white;
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
}

.select:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.select option {
    background-color: #071c14;
    color: white;
    padding: 10px;
}

.select:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}

.display {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    justify-content: center; /* Center the elements horizontally */
}
/* Basic button styling */

/* Update the select styles */
.select {
    height: 42px;  /* Match input height */
    margin-right: 0; /* Remove right margin */
    padding: 5px 35px 5px 15px; /* Increased right padding for icon */
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    border: 2px solid #002d1c;
    border-radius: 20px;
    background-color: rgba(7, 28, 20, 0.95); /* Darker background */
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: calc(100% - 12px) center;
    color: rgba(255, 255, 255, 0.9); /* Brighter text */
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
    min-width: 150px;  /* Ensure minimum width */
    font-size: 14px;  /* Adjust font size */
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    text-shadow: 0 0 1px rgba(255, 255, 255, 0.5); /* Text glow effect */
}

.select:hover {
    background-color: rgba(7, 28, 20, 0.98);
    color: #fff;
    text-shadow: 0 0 2px rgba(255, 255, 255, 0.7);
}

.select option {
    background-color: #071c14;
    color: #fff;
    padding: 10px;
    font-size: 14px;
}

/* Hide default arrow in IE */
.select::-ms-expand {
    display: none;
}

/* Add select wrapper for better positioning if needed */
.select-wrapper {
    position: relative;
    display: inline-block;
}

/* Update the display container */
.display {
    display: flex;
    align-items: start;
    gap: 15px;
    margin-bottom: 20px;
    padding: 0 10px;
    justify-content: start; /* Center the elements horizontally */
}

/* Update the search input */
#searchInput {
    height: 42px;  /* Match select height */
    padding: 5px 15px;
    margin-bottom: 0;  /* Remove bottom margin */
    font-size: 14px;
    min-width: 250px;
}


/* Add these new styles for select animation */
.select option {
    transition: all 0.3s ease;
    transform-origin: top;
}

.select.collapsed option {
    transform: scaleY(0);
    opacity: 0;
    pointer-events: none;
}

.select-hidden {
    opacity: 0;
    transform: translateY(-10px);
    pointer-events: none;
}

/* Add these styles to fix the blinking line */
.divider-row {
    display: none; /* Hide the divider row completely */
}

.styled-table tr {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Add subtle border between rows */
}

.styled-table tr:last-child {
    border-bottom: none; /* Remove border from last row */
}

        .display {
            display: flex;
            align-items: flex-start; /* Align elements to the left */
            gap: 10px;
            margin-bottom: 20px;
            padding: 0 10px;
        }
        .btn.btn-add {
            padding:7px 17px;
    margin-left:1280px;
    position: absolute;
    border: 2px solid #479149; /* Border color */
    border-radius: 5px;
    color: #479149;
    text-decoration: none;
    font-size: 16px;
    background: none; /* No background by default */
    overflow: hidden;
    z-index: 0;
}

/* Sliding background effect */
.btn.btn-add::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: #479149; /* Background color */
    z-index: -1;
    transition: left 0.5s ease-in-out;
}

/* On hover, slide the background in */
.btn.btn-add:hover::before {
    left: 0;
}

/* Text and SVG color change on hover */
.btn.btn-add:hover {
    color: white;
}

.input-icon {
    vertical-align: middle;
    fill: white;
    transition: fill 0.3s ease;
}
.addicon{
    fill: #479149;
    height:20px;
}

.btn.btn-add:hover .input-icon {
    fill: white;
}

        .select,
        #searchInput {
            margin-right: 0; /* Remove right margin */
        }
        .center_record {
            margin-top: -10px !important; /* Remove top margin */
            
        }
    </style>
</head>

<body style="background: #071c14;">
    <button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>
    <?php include 'staff_sidebar.php'; ?>
    
    <div id="recordsContent" class="center_record">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div id="alertBox" class="alert"></div>
        <div class="table-responsive">
            <h1 id="header1">Records Section</h1><br><br>
            <a class="btn btn-add" href="addRecord.php" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="input-icon addicon">
                        <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                    </svg>
                    Add new record
                </a>
            <div class="display">
                <select id="searchField" class="select">
                    <option value="Lot_No">Lot No.</option>
                    <option value="mem_lots">Memorial Lots</option>
                    <option value="mem_sts">Memorial Name</option>
                    <option value="LO_name">Lot Owner</option>
                </select>
                <input class="form-control" type="text" id="searchInput" placeholder="Search records" autocomplete="off">
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
                        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>">
                            <td><?php echo htmlspecialchars(ucwords(strtolower($row['Lot_No']))); ?></td>
                            <td><?php echo htmlspecialchars(ucwords(strtolower($row['mem_lots']))); ?></td>
                            <td><?php echo htmlspecialchars(ucwords(strtolower($row['mem_sts']))); ?></td>
                            <td><?php echo htmlspecialchars(ucwords(strtolower($row['LO_name']))); ?></td>
                            <td><?php echo htmlspecialchars(ucwords(strtolower($row['mem_address']))); ?></td>
                            <td class="action-buttons">
                                <a class='btn btn-edit' href='update.php?id=<?php echo htmlspecialchars($row['id']); ?>&csrf_token=<?php echo urlencode($_SESSION['csrf_token']); ?>'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>Edit</a>
                            </td>
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
    <a href="?page=1<?php echo $searchQuery ? '&search='.htmlspecialchars($searchQuery).'&field='.htmlspecialchars($searchField) : ''; ?>" 
    class="<?php echo $page <= 1 ? 'disabled' : ''; ?>">First</a>
    
    <a href="?page=<?php echo ($page-1); echo $searchQuery ? '&search='.htmlspecialchars($searchQuery).'&field='.htmlspecialchars($searchField) : ''; ?>" 
    class="<?php echo $page <= 1 ? 'disabled' : ''; ?>">←</a>

    <?php for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++) : ?>
        <a href="?page=<?php echo $i; echo $searchQuery ? '&search='.htmlspecialchars($searchQuery).'&field='.htmlspecialchars($searchField) : ''; ?>" 
        class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
        <!-- Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat -->
    <a href="?page=<?php echo ($page+1); echo $searchQuery ? '&search='.htmlspecialchars($searchQuery).'&field='.htmlspecialchars($searchField) : ''; ?>" 
    class="<?php echo $page >= $total_pages ? 'disabled' : ''; ?>">→</a>
    
    <a href="?page=<?php echo $total_pages; echo $searchQuery ? '&search='.htmlspecialchars($searchQuery).'&field='.htmlspecialchars($searchField) : ''; ?>" 
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
        const csrfToken = document.querySelector('input[name="csrf_token"]').value;
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `staff_dynamic_pagination.php?search=${encodeURIComponent(searchQuery)}&field=${encodeURIComponent(selectedField)}&csrf_token=${encodeURIComponent(csrfToken)}`, true);
        
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
    xhr.open('GET', 'staff_dynamic_pagination.php?search=', true);
    
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

// hide the select and the option when the sidebar is active when the user is hovering the sidebar
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const selectOptions = document.querySelector('.options');
    let hideTimeout;
    
    // Hide the options with delay
    const hideElements = () => {
        // Clear any existing timeout
        clearTimeout(hideTimeout);
        // Set new timeout for 300ms delay
        hideTimeout = setTimeout(() => {
            selectOptions.classList.add('select-hidden');
        }, 120); 
    };

    // Show the options immediately
    const showElements = () => {
        // Clear any pending hide timeout
        clearTimeout(hideTimeout);
        selectOptions.classList.remove('select-hidden');
    };

    sidebar.addEventListener('mouseenter', hideElements);
    sidebar.addEventListener('mouseleave', showElements);
});

// Add this to your existing JavaScript
window.onload = function() {
    // Store the current page state in sessionStorage
    sessionStorage.setItem('lastRecordsState', {
        page: <?php echo $page; ?>,
        search: '<?php echo $searchQuery; ?>',
        field: '<?php echo $searchField; ?>'
    });
};

// When coming back to this page
if (window.performance && window.performance.navigation.type === 2) {
    // 2 is for back/forward navigation
    const lastState = sessionStorage.getItem('lastRecordsState');
    if (lastState) {
        // Restore the previous state
        const state = JSON.parse(lastState);
        if (state.search) {
            document.getElementById('searchInput').value = state.search;
            document.getElementById('searchField').value = state.field;
        }
    }
}

// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const selectElement = document.getElementById('searchField');

    sidebar.addEventListener('mouseenter', function() {
        selectElement.blur(); // Remove focus from select
        if(selectElement.size > 1) {
            selectElement.size = 1; // Collapse the select options
        }
    });

    // Prevent select from opening when sidebar is active
    selectElement.addEventListener('mousedown', function(e) {
        if(sidebar.matches(':hover')) {
            e.preventDefault();
        }
    });
});

// Enhanced sidebar hover handling
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const selectElement = document.getElementById('searchField');
    let isSelectOpen = false;

    // Function to force close select
    function forceCloseSelect() {
        selectElement.blur();
        isSelectOpen = false;
        selectElement.classList.add('collapsed');
        // Force the select to close by temporarily disabling it
        selectElement.disabled = true;
        setTimeout(() => {
            selectElement.disabled = false;
        }, 10);
    }

    // Track select open state
    selectElement.addEventListener('mousedown', function(e) {
        if (sidebar.matches(':hover')) {
            e.preventDefault();
            return;
        }
        isSelectOpen = !isSelectOpen;
    });

    selectElement.addEventListener('focus', function() {
        if (sidebar.matches(':hover')) {
            forceCloseSelect();
        }
    });

    // Enhanced sidebar hover handling
    sidebar.addEventListener('mouseenter', function() {
        forceCloseSelect();
    });

    sidebar.addEventListener('mouseleave', function() {
        selectElement.classList.remove('collapsed');
    });

    // Close select when clicking elsewhere
    document.addEventListener('click', function(e) {
        if (!selectElement.contains(e.target)) {
            isSelectOpen = false;
            selectElement.classList.remove('collapsed');
        }
    });

    // Handle page visibility changes
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            forceCloseSelect();
        }
    });

    // Handle history navigation
    window.addEventListener('popstate', function() {
        forceCloseSelect();
    });

    // Check if we're returning from update page
    if (sessionStorage.getItem('returnFromUpdate') === 'true') {
        // Clear the flag
        sessionStorage.removeItem('returnFromUpdate');
        // Force close the select
        forceCloseSelect();
    }

    // Enhanced select element click handling
    selectElement.addEventListener('click', function(e) {
        if (sidebar.matches(':hover')) {
            e.preventDefault();
            forceCloseSelect();
            return false;
        }
    });

    // Add this to your existing popstate event listener
    window.addEventListener('popstate', function() {
        forceCloseSelect();
        if (selectElement.classList.contains('select-hidden')) {
            selectElement.classList.remove('select-hidden');
        }
    });

    // Add cleanup on page unload
    window.addEventListener('beforeunload', function() {
        forceCloseSelect();
    });
});

// Add this at the start of your DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const selectElement = document.getElementById('searchField');
    let isSelectOpen = false;

    // Enhanced force close function
    function forceCloseSelect() {
        if (!selectElement) return;
        
        selectElement.blur();
        isSelectOpen = false;
        selectElement.classList.add('collapsed');
        selectElement.size = 1; // Ensure dropdown is closed
        
        // Force the select to close
        selectElement.disabled = true;
        setTimeout(() => {
            selectElement.disabled = false;
            selectElement.style.pointerEvents = 'auto';
        }, 100);
    }

    // Check for return flags immediately on page load
    if (sessionStorage.getItem('returnFromUpdate') === 'true' || 
        sessionStorage.getItem('forceCloseSelect') === 'true') {
        
        // Clear all related flags
        sessionStorage.removeItem('returnFromUpdate');
        sessionStorage.removeItem('forceCloseSelect');
        
        // Force close with slight delay to ensure DOM is ready
        setTimeout(forceCloseSelect, 0);
    }

    // Prevent select from opening on return
    selectElement.addEventListener('mousedown', function(e) {
        if (sessionStorage.getItem('forceCloseSelect') === 'true') {
            e.preventDefault();
            return false;
        }
    });

    // ...rest of your existing event listeners...

    // Enhanced page visibility handling
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden && sessionStorage.getItem('forceCloseSelect') === 'true') {
            forceCloseSelect();
            sessionStorage.removeItem('forceCloseSelect');
        }
    });
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