<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

require("db-connection.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // Handle AJAX requests for additional records
    if(isset($_GET['fetch_records'])) {
        $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
        $limit = 20; // Number of records per load
        $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

        $sql = "SELECT Lot_No, mem_lots, mem_sts, LO_name, mem_address, id FROM records";
        if ($searchQuery != '') {
            $sql .= " WHERE Lot_No LIKE ? OR mem_lots LIKE ? OR mem_sts LIKE ? OR LO_name LIKE ?";
        }
        $sql .= " LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);

        if ($searchQuery != '') {
            $searchTerm = "%$searchQuery%";
            $stmt->bind_param('ssssii', $searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
        } else {
            $stmt->bind_param('ii', $limit, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $records = array();
        while($row = mysqli_fetch_assoc($result)) {
            $records[] = array(
                'id' => $row['id'],
                'Lot_No' => ucwords(strtolower($row['Lot_No'])),
                'mem_lots' => ucwords(strtolower($row['mem_lots'])),
                'mem_sts' => ucwords(strtolower($row['mem_sts'])),
                'LO_name' => ucwords(strtolower($row['LO_name'])),
                'mem_address' => ucwords(strtolower($row['mem_address']))
            );
        }
        
        header('Content-Type: application/json');
        echo json_encode($records);
        exit;
    }

    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
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
        <div class="table-responsive">
            <h1 id="header1">Records Section</h1>
            <a class="btn btn-primary btn-add" href="admin_addRecord.php" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="input-icon">
                    <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                </svg>
                Add new record
            </a>
            <br>
            <form method="GET" action="" id="searchForm">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" autocomplete="off">
                    <br>
                    <button class='btn btn-search' type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="input-icon">
                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                        </svg>
                        Search
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
                <tbody id="recordsTableBody">
                    <!-- Records will be loaded here via JavaScript -->
                </tbody>
            </table>
            <div id="loadingSpinner" class="loading-spinner"></div>
            <?php if (isset($_GET['m'])) : ?>
            <div class="flash-data" data-flashdata="<?= htmlspecialchars($_GET['m']); ?>"></div>
        <?php endif; ?> 
        </div>
    </div>

    <!-- Logout confirmation modal -->
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
        let offset = 0;
        let loading = false;
        let allRecordsLoaded = false;

        // Function to load records
        function loadRecords() {
            if (loading || allRecordsLoaded) return;
            
            loading = true;
            document.getElementById('loadingSpinner').style.display = 'block';
            
            const searchQuery = document.querySelector('input[name="search"]').value;
            
            fetch(`?fetch_records=1&offset=${offset}&search=${encodeURIComponent(searchQuery)}`)
                .then(response => response.json())
                .then(records => {
                    if (records.length === 0) {
                        allRecordsLoaded = true;
                        if (offset === 0) {
                            document.getElementById('noRecordsModal').style.display = 'flex';
                        }
                    } else {
                        const tableBody = document.getElementById('recordsTableBody');
                        
                        records.forEach(record => {
                            const row = `
                                <tr data-id="${record.id}">
                                    <td>${record.Lot_No}</td>
                                    <td>${record.mem_lots}</td>
                                    <td>${record.mem_sts}</td>
                                    <td>${record.LO_name}</td>
                                    <td>${record.mem_address}</td>
                                    <td class="action-buttons">
                                        <a class='btn btn-edit' href='admin_update.php?id=${record.id}'>Edit</a>
                                        <a href="admin_archiveCondition.php?id=${record.id}" class="btn btn-archive">Archive</a>
                                    </td>
                                </tr>
                                <tr class="divider-row">
                                    <td colspan="6"></td>
                                </tr>`;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                        
                        offset += records.length;
                        
                        // Reattach event listeners for newly added archive buttons
                        attachArchiveListeners();
                    }
                })
                .finally(() => {
                    loading = false;
                    document.getElementById('loadingSpinner').style.display = 'none';
                });
        }

        // Function to attach archive button listeners
        function attachArchiveListeners() {
            $('.btn-archive').off('click').on('click', function (e) {
                e.preventDefault();
                const href = $(this).attr('href');

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
                        document.location.href = href;
                    }
                });
            });
        }

        // Initial load
        loadRecords();

        // Infinite scroll
        window.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
            
            if (scrollTop + clientHeight >= scrollHeight - 5) {
                loadRecords();
            }
        });

        // Handle search
        document.getElementById('searchForm').addEventListener('submit', (e) => {
            e.preventDefault();
            offset = 0;
            allRecordsLoaded = false;
            document.getElementById('recordsTableBody').innerHTML = '';
            loadRecords();
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

        function showAlert(message, type) {
            const alertBox = document.getElementById('alertBox');
            alertBox.className = 'alert ' + (type === 'success' ? 'alert-success' : 'alert-error');
            alertBox.textContent = message;
            alertBox.style.display = 'block';

            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
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
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>