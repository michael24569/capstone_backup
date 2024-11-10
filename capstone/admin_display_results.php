<?php
session_start();

function handlePostRequest() {
    // Get the JSON input
    $json = file_get_contents('php://input');
    $recordStatus = json_decode($json, true);

    // If the data is valid, store it in the session
    if ($recordStatus && is_array($recordStatus)) {
        $_SESSION['record_status'] = $recordStatus;
        echo json_encode(['status' => 'success', 'message' => 'Record status saved successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
}

function displayRecordStatus() {
    if (isset($_SESSION['record_status'])) {
        $recordStatus = $_SESSION['record_status'];
    } else {
        echo "No record status available.";
        return;
    }

    $memorialNames = [
        //Apartment 3 to 1
        'grid-itemA3' => 'Apartment 3 Side A',
        'grid-itemB3' => 'Apartment 3 Side B',
        'grid-itemA2' => 'Apartment 2 Side A',
        'grid-itemB2' => 'Apartment 2 Side B',
        'grid-itemA' => 'Apartment 1 Side A',
        'grid-itemB' => 'Apartment 1 Side B',
    
        //columbarium 2 1st floor
        'grid-itemC2S1A' => 'Columbarium 2 (1st floor Block 1) Side A',
        'grid-itemC2S1B' => 'Columbarium 2 (1st floor Block 1) Side B',
        'grid-itemC2S2A' => 'Columbarium 2 (1st floor Block 2) Side A',
        'grid-itemC2S2B' => 'Columbarium 2 (1st floor Block 2) Side B',
        'grid-itemC2blk3A' => 'Columbarium 2 (1st floor Block 3) Side A',
        'grid-itemC2blk3B' => 'Columbarium 2 (1st floor Block 3) Side B',
        'grid-itemC2blk4A' => 'Columbarium 2 (1st floor Block 3) Side A',
        'grid-itemC2blk4B' => 'Columbarium 2 (1st floor Block 3) Side B',
        //columbarium 2 2nd floor
        'grid-itemC2S12A' => 'Columbarium 2 (2nd floor Block 1) Side A',
        'grid-itemC2S12B' => 'Columbarium 2 (2nd floor BLock 1) Side B',
        'grid-itemC2S22A' => 'Columbarium 2 (2nd floor Block 2) Side A',
        'grid-itemC2S22B' => 'Columbarium 2 (2nd floor Block 2) Side B',
        'grid-itemblk3AC2' => 'Columbarium 2 (2nd floor Block 3) Side A',
        'grid-itemblk3BC2' => 'Columbarium 2 (2nd floor Block 3) Side B',
        'grid-itemblk4AC2' => 'Columbarium 2 (2nd floor Block 4) Side A',
        'grid-itemblk4BC2' => 'Columbarium 2 (2nd floor Block 4) Side B',
    
        //columbarium 1 1st floor
        'grid-itemC1S11A' => 'Columbarium 1 (1st floor Block 1) Side A',
        'grid-itemC1S11B' => 'Columbarium 1 (1st floor Block 1) Side B',
        'grid-itemC1S22A' => 'Columbarium 1 (1st floor Block 2) Side A',
        'grid-itemC1S22B' => 'Columbarium 1 (1st floor Block 2) Side B',
        'grid-itemC1BLK3A' => 'Columbarium 1 (1st floor Block 3) Side A',
        'grid-itemC1BLK3B' => 'Columbarium 1 (1st floor Block 3) Side B',
        'grid-itemC1BLK4A' => 'Columbarium 1 (1st floor Block 4) Side A',
        'grid-itemC1BLK4B' => 'Columbarium 1 (1st floor Block 4) Side B',
        //columbarium 1 2nd floor
        'grid-itemC1S1A' => 'Columbarium 1 (2nd floor Block 1) Side A',
        'grid-itemC1S1B' => 'Columbarium 1 (2nd floor Block 1) Side B',
        'grid-itemC1SA' => 'Columbarium 1 (2nd floor Block 2) Side A',
        'grid-itemC1SB' => 'Columbarium 1 (2nd floor Block 2) Side B',
        'grid-itemC1blk3A2nd' => 'Columbarium 1 (2nd floor Block 3) Side A',
        'grid-itemC1blk3B2nd' => 'Columbarium 1 (2nd floor Block 3) Side B',
        'grid-itemC1blk4A2nd' => 'Columbarium 1 (2nd floor Block 4) Side A',
        'grid-itemC1blk4B2nd' => 'Columbarium 1 (2nd floor Block 4) Side B',
    
        //all of the Saints
        'grid-itemRAF' => 'St. Rafael',
        'grid-itempeter' => 'St. Peter',
        'grid-itempaul' => 'St. Paul',
        'grid-itemjude' => 'St. Jude',
        'grid-itemjohn' => 'St. John',
        'grid-itemjoseph' => 'St. Joseph',
        'grid-itemjames' => 'St. James',
        'grid-itemmatthew' => 'St. Matthew',
        'grid-itemagustine' => 'St. Agustine',
        'grid-itemdominic' => 'St. Dominic',
        'grid-itemmark' => 'St. Mark',
        'grid-itemluke' => 'St. Luke',
        'grid-itemisidore' => 'St. Isidore',
    ];
    
    asort($memorialNames);

    // Sort the recordStatus based on memorial names for consistent display order
    uksort($recordStatus, function($a, $b) use ($memorialNames) {
        $nameA = $memorialNames[$a] ?? $a;
        $nameB = $memorialNames[$b] ?? $b;
        return strcmp($nameA, $nameB);
    });

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Status Summary</title>
    <style>
    
        body {
            display: block;
            justify-content: start;
            align-items: start;
            height: 100vh;
            padding-top: 20px;
            
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin-left:70px;
        }
        table, th, td {
            border: 1px solid black;
            

        }
        th, td {
            padding: 10px;
            text-align: center;
            
        }
        th {
            background-color: #caf2cb;
           
        }
            h1{
            color:white;
            text-align:center;
            }
            td{
            background-color: #f2f2f2;
            color: black;
        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Summary of Status Report</h1><br>

<table>
    <tr>
        <th>Memorial Name</th>
        <th>Occupied</th>
        <th>Available</th>
    </tr>';
    
    foreach ($recordStatus as $class => $counts) {
        $memorialName = isset($memorialNames[$class]) ? $memorialNames[$class] : $class; // Default to class name if no mapping exists
        echo "<tr>
            <td>" . htmlspecialchars($memorialName) . "</td>
            <td>" . htmlspecialchars($counts['matched']) . "</td>
            <td>" . htmlspecialchars($counts['unmatched']) . "</td>
        </tr>";
    }

    echo '</table>
</body>
</html>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
} else {
    displayRecordStatus();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Report</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>

        .center-record {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
</head>
<body>
 <div class="sidebar">
        <ul>
            <li class="icon-logo">
                <a href="#">
                    <span class="icon"><ion-icon name="help-buoy"></ion-icon></span>
                    <span class="text">Tagaytay Memorial Park</span>
                </a>
            </li>
            <li>
                <a href="admin_map.php" onclick="showHome()">
                    <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="admin_records.php" onclick="showRecords()">
                    <span class="icon"><ion-icon name="book-outline"></ion-icon></span>
                    <span class="text">Records</span>
                </a>
            </li>
            <li>
                <a href="admin_status.php" onclick="showStatus()">
                    <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                    <span class="text">Manage Staffs Account</span>
                </a>
            </li>
            <li>
                <a href="admin_display_results.php" onclick="">
                    <span class="icon"><ion-icon name="newspaper-outline"></ion-icon></span>
                    <span class="text">Report</span>
                </a>
            </li>
            <li>
                <a href="admin_backup.php" onclick="">
                    <span class="icon"><ion-icon name="copy-outline"></ion-icon></span>
                    <span class="text">Backup Records</span>
                </a>
            </li>
            <li>
                <a href="admin_archive.php" onclick="">
                    <span class="icon"><ion-icon name="document-outline"></ion-icon></span>
                    <span class="text">Archived Records</span>
                </a>
            </li>
            <li>
                <a href="admin_activity_log.php" onclick="">
                    <span class="icon"><ion-icon name="receipt-outline"></ion-icon></ion-icon></span>
                    <span class="text">Activity Log </span>
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
<!-- Popup Structure -->
<div id="reportPopup" class="center-record" style="display:none;">
    <div id="reportContent" class="table-responsive"></div>
    <button id="closeReportPopup">Close</button>
</div>

<script>
function displayReportPopup(event) {
    event.preventDefault(); // Prevent the default anchor action

    // Fetch the report content
    fetch('admin_display_results.php')
        .then(response => response.text())
        .then(data => {
            const reportPopup = document.getElementById('reportPopup');
            const reportContent = document.getElementById('reportContent');

            // Display the fetched data inside the popup
            reportContent.innerHTML = data;

            // Show the popup
            reportPopup.style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching report:', error);
        });
}

// Close popup logic
document.getElementById('closeReportPopup').addEventListener('click', function() {
    const reportPopup = document.getElementById('reportPopup');
    reportPopup.style.display = 'none';
});
</script>
</body>
</html>
