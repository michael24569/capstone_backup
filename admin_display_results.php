<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

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
        //apartment 3 to 1
        'grid-itemA3' => 'apartment 3 side a',
        'grid-itemB3' => 'apartment 3 side b',
        'grid-itemA2' => 'apartment 2 side a',
        'grid-itemB2' => 'apartment 2 side b',
        'grid-itemA' => 'apartment 1 side a',
        'grid-itemB' => 'apartment 1 side b',
    
        //columbarium 2 1st floor
        'grid-itemC2S1A' => 'columbarium 2 (1st floor block 1) side a',
        'grid-itemC2S1B' => 'columbarium 2 (1st floor block 1) side b',
        'grid-itemC2S2A' => 'columbarium 2 (1st floor block 2) side a',
        'grid-itemC2S2B' => 'columbarium 2 (1st floor block 2) side b',
        'grid-itemC2blk3A' => 'columbarium 2 (1st floor block 3) side a',
        'grid-itemC2blk3B' => 'columbarium 2 (1st floor block 3) side b',
        'grid-itemC2blk4A' => 'columbarium 2 (1st floor block 3) side a',
        'grid-itemC2blk4B' => 'columbarium 2 (1st floor block 3) side b',
        //columbarium 2 2nd floor
        'grid-itemC2S12A' => 'columbarium 2 (2nd floor block 1) side a',
        'grid-itemC2S12B' => 'columbarium 2 (2nd floor block 1) side b',
        'grid-itemC2S22A' => 'columbarium 2 (2nd floor block 2) side a',
        'grid-itemC2S22B' => 'columbarium 2 (2nd floor block 2) side b',
        'grid-itemblk3AC2' => 'columbarium 2 (2nd floor block 3) side a',
        'grid-itemblk3BC2' => 'columbarium 2 (2nd floor block 3) side b',
        'grid-itemblk4AC2' => 'columbarium 2 (2nd floor block 4) side a',
        'grid-itemblk4BC2' => 'columbarium 2 (2nd floor block 4) side b',
    
        //columbarium 1 1st floor
        'grid-itemC1S11A' => 'columbarium 1 (1st floor block 1) side a',
        'grid-itemC1S11B' => 'columbarium 1 (1st floor block 1) side b',
        'grid-itemC1S22A' => 'columbarium 1 (1st floor block 2) side a',
        'grid-itemC1S22B' => 'columbarium 1 (1st floor block 2) side b',
        'grid-itemC1BLK3A' => 'columbarium 1 (1st floor block 3) side a',
        'grid-itemC1BLK3B' => 'columbarium 1 (1st floor block 3) side b',
        'grid-itemC1BLK4A' => 'columbarium 1 (1st floor block 4) side a',
        'grid-itemC1BLK4B' => 'columbarium 1 (1st floor block 4) side b',
        //columbarium 1 2nd floor
        'grid-itemC1S1A' => 'columbarium 1 (2nd floor block 1) side a',
        'grid-itemC1S1B' => 'columbarium 1 (2nd floor block 1) side b',
        'grid-itemC1SA' => 'columbarium 1 (2nd floor block 2) side a',
        'grid-itemC1SB' => 'columbarium 1 (2nd floor block 2) side b',
        'grid-itemC1blk3A2nd' => 'columbarium 1 (2nd floor block 3) side a',
        'grid-itemC1blk3B2nd' => 'columbarium 1 (2nd floor block 3) side b',
        'grid-itemC1blk4A2nd' => 'columbarium 1 (2nd floor block 4) side a',
        'grid-itemC1blk4B2nd' => 'columbarium 1 (2nd floor block 4) side b',
    
        //all of the Saints
        'grid-itemRAF' => 'st. rafael',
        'grid-itempeter' => 'st. peter',
        'grid-itempaul' => 'st. paul',
        'grid-itemjude' => 'st. jude',
        'grid-itemjohn' => 'st. john',
        'grid-itemjoseph' => 'st. joseph',
        'grid-itemjames' => 'st. james',
        'grid-itemmatthew' => 'st. matthew',
        'grid-itemagustine' => 'st. agustine',
        'grid-itemdominic' => 'st. dominic',
        'grid-itemmark' => 'st. mark',
        'grid-itemluke' => 'st. luke',
        'grid-itemisidore' => 'st. isidore',
        'grid-itempm' => 'st. michael and st. patrick'
    ];
    
    asort($memorialNames);

    // Sort the recordStatus based on memorial names for consistent display order
    uksort($recordStatus, function($a, $b) use ($memorialNames) {
        $nameA = $memorialNames[$a] ?? $a;
        $nameB = $memorialNames[$b] ?? $b;
        return Strcmp($nameA, $nameB);
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
            background: #071c14;
            
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
            background-color: #004100;   
            color: white  
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
<body style="background: #071c14;"> 

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
.sidebar-toggle-btn {
  display: none; /* Default: hidden, visible in responsive view */
  position: absolute; /* Position inside the sidebar */
  top: 20px; /* Adjust position from the top of the sidebar */
  left: 15px; /* Align inside the sidebar */
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

  

  .sidebar.active {
    transform: translateX(0); /* Show sidebar when active */
  }
}
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
<?php include 'admin_sidebar.php'; ?>
<!-- Popup Structure -->
<button id="sidebarToggle" class="sidebar-toggle-btn">
    <ion-icon name="menu-outline"></ion-icon>
</button>
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
