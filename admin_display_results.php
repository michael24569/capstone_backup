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
    
        //Columbarium 2 1st floor
        'grid-itemC2S1A' => 'Columbarium 2 (1st floor block 1) side a',
        'grid-itemC2S1B' => 'Columbarium 2 (1st floor block 1) side b',
        'grid-itemC2S2A' => 'Columbarium 2 (1st floor block 2) side a',
        'grid-itemC2S2B' => 'Columbarium 2 (1st floor block 2) side b',
        'grid-itemC2blk3A' => 'Columbarium 2 (1st floor block 3) side a',
        'grid-itemC2blk3B' => 'Columbarium 2 (1st floor block 3) side b',
        'grid-itemC2blk4A' => 'Columbarium 2 (1st floor block 3) side a',
        'grid-itemC2blk4B' => 'Columbarium 2 (1st floor block 3) side b',
        //Columbarium 2 2nd floor
        'grid-itemC2S12A' => 'Columbarium 2 (2nd floor block 1) side a',
        'grid-itemC2S12B' => 'Columbarium 2 (2nd floor block 1) side b',
        'grid-itemC2S22A' => 'Columbarium 2 (2nd floor block 2) side a',
        'grid-itemC2S22B' => 'Columbarium 2 (2nd floor block 2) side b',
        'grid-itemblk3AC2' => 'Columbarium 2 (2nd floor block 3) side a',
        'grid-itemblk3BC2' => 'Columbarium 2 (2nd floor block 3) side b',
        'grid-itemblk4AC2' => 'Columbarium 2 (2nd floor block 4) side a',
        'grid-itemblk4BC2' => 'Columbarium 2 (2nd floor block 4) side b',
    
        //Columbarium 1 1st floor
        'grid-itemC1S11A' => 'Columbarium 1 (1st floor block 1) side a',
        'grid-itemC1S11B' => 'Columbarium 1 (1st floor block 1) side b',
        'grid-itemC1S22A' => 'Columbarium 1 (1st floor block 2) side a',
        'grid-itemC1S22B' => 'Columbarium 1 (1st floor block 2) side b',
        'grid-itemC1BLK3A' => 'Columbarium 1 (1st floor block 3) side a',
        'grid-itemC1BLK3B' => 'Columbarium 1 (1st floor block 3) side b',
        'grid-itemC1BLK4A' => 'Columbarium 1 (1st floor block 4) side a',
        'grid-itemC1BLK4B' => 'Columbarium 1 (1st floor block 4) side b',
        //Columbarium 1 2nd floor
        'grid-itemC1S1A' => 'Columbarium 1 (2nd floor block 1) side a',
        'grid-itemC1S1B' => 'Columbarium 1 (2nd floor block 1) side b',
        'grid-itemC1SA' => 'Columbarium 1 (2nd floor block 2) side a',
        'grid-itemC1SB' => 'Columbarium 1 (2nd floor block 2) side b',
        'grid-itemC1blk3A2nd' => 'Columbarium 1 (2nd floor block 3) side a',
        'grid-itemC1blk3B2nd' => 'Columbarium 1 (2nd floor block 3) side b',
        'grid-itemC1blk4A2nd' => 'Columbarium 1 (2nd floor block 4) side a',
        'grid-itemC1blk4B2nd' => 'Columbarium 1 (2nd floor block 4) side b',
    
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
        'grid-itempm' => 'St. Michael and St. Patrick'
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
           @font-face {
    font-family: 'MyFont';
    src: url('fonts/Inter.ttf') format('ttf'),
}
body {
    font-family: 'MyFont';
}


        .center-record {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            
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
  z-index: 10;
 
}

.top-left-button svg {
  width: 24px;
  height: 24px;
  z-index: 10;
}

.main-content {
  text-align: center;
  z-index: 10;
}
    </style>
</head>
<body>
<?php include 'admin_sidebar.php'; ?>
<!-- Popup Structure -->
<button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
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
<script src="paiyakan.js"></script>


</body>
</html>
