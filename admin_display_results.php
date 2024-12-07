<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

function handlePostRequest() {
    $json = file_get_contents('php://input');
    $recordStatus = json_decode($json, true);

    if ($recordStatus && is_array($recordStatus)) {
        $_SESSION['record_status'] = $recordStatus;
        echo json_encode(['status' => 'success', 'message' => 'Record status saved successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
}

function groupRecords($recordStatus, $memorialNames) {
    $grouped = [
        'apartment1' => ['name' => 'Apartment 1', 'items' => []],
        'apartment2' => ['name' => 'Apartment 2', 'items' => []],
        'apartment3' => ['name' => 'Apartment 3', 'items' => []],
        'columbarium1' => ['name' => 'Columbarium 1', 'items' => []],
        'columbarium2' => ['name' => 'Columbarium 2', 'items' => []],
        'saints' => ['name' => 'Saints', 'items' => []]
    ];

    foreach ($recordStatus as $class => $counts) {
        $memorialName = $memorialNames[$class] ?? $class;
        
        if (strpos(strtolower($memorialName), 'apartment 1') !== false) {
            $grouped['apartment1']['items'][$class] = ['name' => $memorialName, 'counts' => $counts];
        } elseif (strpos(strtolower($memorialName), 'apartment 2') !== false) {
            $grouped['apartment2']['items'][$class] = ['name' => $memorialName, 'counts' => $counts];
        } elseif (strpos(strtolower($memorialName), 'apartment 3') !== false) {
            $grouped['apartment3']['items'][$class] = ['name' => $memorialName, 'counts' => $counts];
        } elseif (strpos($memorialName, 'Columbarium 1') !== false) {
            $grouped['columbarium1']['items'][$class] = ['name' => $memorialName, 'counts' => $counts];
        } elseif (strpos($memorialName, 'Columbarium 2') !== false) {
            $grouped['columbarium2']['items'][$class] = ['name' => $memorialName, 'counts' => $counts];
        } elseif (strpos($memorialName, 'St.') !== false) {
            $grouped['saints']['items'][$class] = ['name' => $memorialName, 'counts' => $counts];
        }
    }

    foreach ($grouped as &$group) {
        $group['total_matched'] = array_sum(array_column(array_column($group['items'], 'counts'), 'matched'));
        $group['total_unmatched'] = array_sum(array_column(array_column($group['items'], 'counts'), 'unmatched'));
    }

    return $grouped;
}

function displayRecordStatus() {
    if (!isset($_SESSION['record_status'])) {
        echo "No record status available.";
        return;
    }

   $recordStatus = $_SESSION['record_status'];
    $memorialNames = [
        'grid-itemA3' => 'Apartment 3 side a',
        'grid-itemB3' => 'Apartment 3 side b',
        'grid-itemA2' => 'Apartment 2 side a',
        'grid-itemB2' => 'Apartment 2 side b',
        'grid-itemA' => 'Apartment 1 side a',
        'grid-itemB' => 'Apartment 1 side b',
        'grid-itemC2S1A' => 'Columbarium 2 (1st floor block 1) side a',
        'grid-itemC2S1B' => 'Columbarium 2 (1st floor block 1) side b',
        'grid-itemC2S2A' => 'Columbarium 2 (1st floor block 2) side a',
        'grid-itemC2S2B' => 'Columbarium 2 (1st floor block 2) side b',
        'grid-itemC2blk3A' => 'Columbarium 2 (1st floor block 3) side a',
        'grid-itemC2blk3B' => 'Columbarium 2 (1st floor block 3) side b',
        'grid-itemC2blk4A' => 'Columbarium 2 (1st floor block 4) side a', 
        'grid-itemC2blk4B' => 'Columbarium 2 (1st floor block 4) side b', 
        'grid-itemC2S12A' => 'Columbarium 2 (2nd floor block 1) side a',
        'grid-itemC2S12B' => 'Columbarium 2 (2nd floor block 1) side b',
        'grid-itemC2S22A' => 'Columbarium 2 (2nd floor block 2) side a',
        'grid-itemC2S22B' => 'Columbarium 2 (2nd floor block 2) side b',
        'grid-itemblk3AC2' => 'Columbarium 2 (2nd floor block 3) side a',
        'grid-itemblk3BC2' => 'Columbarium 2 (2nd floor block 3) side b',
        'grid-itemblk4AC2' => 'Columbarium 2 (2nd floor block 4) side a',
        'grid-itemblk4BC2' => 'Columbarium 2 (2nd floor block 4) side b',
        'grid-itemC1S11A' => 'Columbarium 1 (1st floor block 1) side a',
        'grid-itemC1S11B' => 'Columbarium 1 (1st floor block 1) side b',
        'grid-itemC1S22A' => 'Columbarium 1 (1st floor block 2) side a',
        'grid-itemC1S22B' => 'Columbarium 1 (1st floor block 2) side b',
        'grid-itemC1BLK3A' => 'Columbarium 1 (1st floor block 3) side a',
        'grid-itemC1BLK3B' => 'Columbarium 1 (1st floor block 3) side b',
        'grid-itemC1BLK4A' => 'Columbarium 1 (1st floor block 4) side a',
        'grid-itemC1BLK4B' => 'Columbarium 1 (1st floor block 4) side b',
        'grid-itemC1S1A' => 'Columbarium 1 (2nd floor block 1) side a',
        'grid-itemC1S1B' => 'Columbarium 1 (2nd floor block 1) side b',
        'grid-itemC1SA' => 'Columbarium 1 (2nd floor block 2) side a',
        'grid-itemC1SB' => 'Columbarium 1 (2nd floor block 2) side b',
        'grid-itemC1blk3A2nd' => 'Columbarium 1 (2nd floor block 3) side a',
        'grid-itemC1blk3B2nd' => 'Columbarium 1 (2nd floor block 3) side b',
        'grid-itemC1blk4A2nd' => 'Columbarium 1 (2nd floor block 4) side a',
        'grid-itemC1blk4B2nd' => 'Columbarium 1 (2nd floor block 4) side b',
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

    $grouped = groupRecords($recordStatus, $memorialNames);

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary of Status Report</title>
    <style>

        .summary-table {
            width: 95%;
            margin: 30px auto;
            border-collapse: collapse;
            margin-left: 70px;
            margin-top: 20px;
        }
        .summary-table th, .summary-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #004100;
        }
        .summary-table th {
            background-color: #004100;
            color: white;
        }
        .summary-table td {
            background-color: #f2f2f2;
            color: black;
        }
        .view-details {
            background-color: #3d8b40;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-family: "MyFont";
        }
        .view-details:hover {
            background-color: #4CAF50;
        }
        .details-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 5px;
            position: relative;
            max-height: 80vh;
            overflow-y: auto;
        }
        .close-modal {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .details-table th {
            background-color: #004100;
            color: white;
        }
        h1 {
            margin-top:110px;
            color: white;
            text-align: center;
        }
       /* Hide elements by default on main page */
.seal, .cctlogo, .address {
    display: none;
}

/* Main page background */
body {
    display: block;
    justify-content: start;
    align-items: start;
    height: 100vh;
    padding-top: 20px;
    background: #071c14;
}

/* Print-specific styles */
/* Existing styles remain the same until the print media query */
@media print {
    .print-button { display: none; }
    .view-details, .close-modal { display: none; }
    .sidebar { display: none !important; }
    .summary-table { display: none !important; }

    .details-modal {
        display: block !important;
        position: static;
        background: white;
        border: none;
        box-shadow: none;
    }

    .details-modal .modal-content {
        width: 100%;
        margin: 0;
        margin-bottom: 20px;
    }

    body {
        background: white;
        margin: 0;
    }

    .details-modal {
        position: static;
        display: block;
        width: 100%;
        height: auto;
        background: none;
    }

    .modal-content {
        margin: 0;
        padding: 0;
        width: 100%;
        box-shadow: none;
    }

    .seal {
        display: block;
        text-align: center;
    }

    .seal img {
        position: absolute;
        max-width: 10.5%;
        height: auto;
        margin-top: -1%;
        margin-left: -41%;
        z-index: 10000;
    }

    .cctlogo {
        display: block;
        text-align: center;
    }

    .cctlogo img {
        position: absolute;
        max-width: 8.5%;
        height: auto;
        margin-top: -1%;
        margin-left: 38%;
        z-index: 10000;
    }

    .address {
        display: block;
        color: black;
        position: absolute;
        top: 2%;
        left: 50%;
        transform: translate(-50%, 0);
        text-align: center;
        z-index: 1000;
    }

    .address h3 {
        margin-bottom: 10px;
    }

    .address h2 {
        font-weight: bold;
        margin: -5px;
    }

    /* Modified reportHeader positioning for print */
    .reportHeader {
        margin-top: 120px !important; /* Increased margin for print */
        position: relative;
        width: 100%;
        text-align: center;
    }

    /* New styles for headers and table headers */
    h1, h2, h3, h4, h5, h6 {
        color: black !important;
    }

    table th {
        color: black !important;
        background-color: #f0f0f0 !important; /* Light gray background */
    }

    table {
        border-collapse: collapse;
    }

    table, table th, table td {
        border: 1px solid black !important;
        background-color: #f0f0f0 !important;
        color: black !important;
    }


  table thead,
    table thead tr,
    table thead th {
        background-color: #006800 !important;
        color: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Fallback for browsers that might have issues */
    table th {
        background-color: #006800 !important;
        color: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}


/* Sidebar Styles */
.sidebar {
  font-size: 15px;
  bottom: 0px;
  position: fixed;
  width: 60px; /* Sidebar width when collapsed */
  height: 100vh;
  background: #dee7e2;
  overflow: hidden;
  transition: width 0.5s ease, box-shadow 0.3s ease; /* Smooth transition for width and box-shadow */
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  box-shadow: 0 50px 40px black;
}

.sidebar.active {
  width: 300px; /* Expanded sidebar width */
}

.sidebar:hover {
  width: 300px; /* Ensure that hover expands the sidebar */
}

/* Sidebar Content Styles */
.sidebar ul {
  position: relative;
  height: 100vh;
}

.sidebar ul li {
  list-style: none;
}

.sidebar ul li:hover {
  transition: 0.8s;
  background: #b3d1b3;
}

.sidebar ul li a {
  position: relative;
  display: flex;
  white-space: nowrap;
  text-decoration: none;
}

.sidebar ul li a .icon {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  min-width: 60px;
  height: 60px;
  font-size: 1.5rem;
  color: #222222;
}

.sidebar ul li a .text {
  font-family: "MyFont";
  position: relative;
  height: 60px;
  display: flex;
  align-items: center;
  font-size: 15px;
  color: #222222;
  text-transform: uppercase;
}

.sidebar .icon-logo {
  margin-bottom: 20px;
}

.sidebar .icon-logo .text {
  font-size: 11px;
  font-weight: 300;
  font-weight: bold;
}

.sidebar .icon-logo .text:hover {
  background: #dee7e2;
}

.bottom {
  position: absolute;
  bottom: 0;
  width: 100%;
}

/* Sidebar Toggle Button Styles */
.sidebar-toggle-btn {
  display: none; /* Default: hidden, visible in responsive view */
  position: absolute; 
  top: 20px;
  left: 15px;
  background: none;
  border: none;
  padding: 10px;
  cursor: pointer;
  z-index: 1000; /* Ensure it appears above other elements */
}



/* Responsive design for smaller screens */
@media screen and (max-width: 768px) {
  .sidebar-toggle-btn {
    display: block; /* Show the toggle button on smaller screens */
  }

  .sidebar {
    transform: translateX(-100%); /* Hide sidebar by default */
    transition: transform 0.3s ease-in-out; /* Smooth transition for sliding effect */
  }

  .sidebar.active {
    transform: translateX(0); /* Show sidebar when active */
  }
}

@media screen and (max-width: 480px) {
  .sidebar {
    width: 50px;
  }

  .sidebar:hover {
    width: 150px;
  }

  .sidebar ul li a .icon {
    min-width: 50px;
    height: 50px;
    font-size: 1.2rem;
  }

  .sidebar ul li a .text {
    font-size: 9px;
  }

  .sidebar .icon-logo .text {
    font-size: 10px;
  }
}
.sidebar-header:hover{
  cursor: default;
  background: #dee7e2;
}






/* Page Content Styling */
.align {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin: 0 auto;
}
.center_record {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin: 0 auto;
  overflow-x: auto;
}
.align img {
  margin-top: 30px;
  width: 70%;
  height: auto;
  border-radius: 25px;
}

.popup {
  position: absolute;
  width: 50%;
  height: 80%;
  padding: 30px 20px;
  background: #7c9785;
  border-radius: 20px;
  z-index: 2;
  box-sizing: border-box;
  text-align: center;
  justify-content: center;
  align-items: center;
  display: none;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.blur {
  filter: blur(5px); /* Adjust the blur amount as needed */
}

/* Records Table Styling */
@media (max-width: 600px) {
  th, td {
    font-size: 0.9em;
  }
}
.table-responsive {
  margin-top: 15px;
  width: 100%;
  background-color: #f3f3f3;
  border-radius: 10px;
  margin-right: 10px;
  margin-left: 5rem;
  padding: 10px;
  border-collapse: collapse;
}
.audit {
    margin-top: 20px;
    width: 93%;
    background-color: #f3f3f3;
    border-radius: 10px;
    margin-right: 10px;
    margin-left: 5rem;

}

.styled-table {
  border-collapse: collapse;
  margin: 10px 0;
  font-size: 0.9em;
  font-family: "MyFont";
  width: 100%;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
  background-color: #033512;
  color: #ffffff;
  text-align: center;
}

.styled-table th,
.styled-table td {
  padding: 12px 15px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

.styled-table tr {
  background-color: #ffffff;
}

.styled-table tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.styled-table tr:last-of-type {
  border-bottom: 2px solid #033512;
;
}

.styled-table th {
  font-weight: bold;
  font-size: 1.1em;
}

/* Buttons Styling */
.btn {
  padding: 10px 20px;
  color: #ffffff;
  text-decoration: none;
  border-radius: 5px;
  margin: 2px;
  font-weight: bold;
  font-size: 0.9em;
  display: flex;
  
}

.btn-add {
  background-color: #479149;
  margin-bottom: 20px;
  display: inline-block;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  text-align: center;
 transition: 0.5 ease-in;
 
}
.btn-add:hover{
  background-color: #4CAF50;

} 
.btn-edit {
  right: 100px;
  border-radius: 10px;
  background-color: #479149;
  margin-right: 5px;
  padding: 10px;
  
}
.btn-edit:hover{
  background-color: #4CAF50;

}

.btn-archive {
  background-color: #f44336;
}
.btn-archive:hover {
  background-color: #c4372d;
}
.btn-search {
  cursor: pointer;
  border-radius: 10px;
  padding-left:15px;
  background-color: #2e21a7;
  text-align: center;
  font-family: "MyFont";
}
.btn-search:hover{
  background-color: #3f2afc;

  
}
@font-face {
  font-family: "MyFont";
  src: url("fonts/Inter.ttf") format("ttf"),
}

/* Aligning Edit and Archive Buttons */
.action-buttons {
  display: flex;
  justify-content: center;
}

.divider-row {
  background-color: #009879;
  height: 2px;
  border: none;
}
.input-group {
  display: flex;
  
  
}  
  #print {
    font-family: "MyFont";
    position: absolute;
    top:95px;
    right: 10px;
    background-color: #479149;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 10;
}
    .input-icon {
  height:15px; fill:white;
  margin-right: 10px;
}
  @keyframes popIn {
    0% {
        opacity: 0;           /* Start fully transparent */
        transform: scale(0.8); /* Start slightly smaller */
    }
    100% {
        opacity: 1;           /* Fully visible */
        transform: scale(1);  /* Full size */
    }
}

.mudal {
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

.modal-contint {
    background: white;
    border-radius: 8px;
    text-align: center;
    padding: 70px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    animation: popIn 0.3s ease-out; /* Apply pop-in animation */
}
h2 {
    text-align: start;
    margin-bottom: -10px;
}
p {
    padding-top: 1%;
}

.modal-buttons {
    display: flex;
    justify-content: center;
    margin-bottom: -45px;
    padding-top: 30px;
    gap: 15px;
}

.btn-confirm, .btn-cancel {
    padding: 10px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 1s ease;
}


.btn-confirm {
    background-color: #28a745;
    color: white;
}

.btn-cancel {
    background-color: #dc3545;
    color: white;
}
.btn-cancel:hover{
    background-color: #b82e3c;
    transform: scale(1.2);
    
}
.btn-confirm:hover{
    background-color: #218d3a;
    
    transform: scale(1.2);
    
}
.alert {
    position: fixed;
    top: 20%;
    right: 38%;
    padding: 10px 20px;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    display: none; /* Start hidden */
    z-index: 1000;
    animation: popIn 0.3s ease-out; /* Apply pop-in animation */
    
}

.alert-success {
    background-color: #28a745;
}

.alert-error {
    background-color: #dc3545;
}

.reportHeader {
margin-top: -10px;
  }
  
    </style>
</head>
 <link rel="stylesheet" href="style1.css">
<body>

<div class="sidebar">

    <ul>
            <li>
            <a class="sidebar-header">
                <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"  style="width: 24px; height: 24px; fill: #002d1c;"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M176 0c-26.5 0-48 21.5-48 48l0 80-80 0c-26.5 0-48 21.5-48 48l0 32c0 26.5 21.5 48 48 48l80 0 0 208c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-208 80 0c26.5 0 48-21.5 48-48l0-32c0-26.5-21.5-48-48-48l-80 0 0-80c0-26.5-21.5-48-48-48L176 0z"/></svg>
            </span>
                <span class="text" style="font-size: 15px;">Tagaytay Memorial Park</span>
            </a>
        </li>
        <br>
        <li>
            <a href="admin_map.php" onclick="showHome()">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"  style="width: 24px; height: 24px; fill: #002d1c;">
                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
                </span>
                <span class="text">Home</span>
            </a>
        </li>
        <li>
            <a href="admin_records.php" onclick="showRecords()">
                <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"  style="width: 24px; height: 24px; fill: #002d1c;"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5l0-377.4c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8L0 454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5l0-370.3c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11L304 456c0 11.4 11.7 19.3 22.4 15.5z"/></svg>
                </span>
                <span class="text">Records</span>
            </a>
        </li>
        <li>
            <a href="admin_status.php" onclick="showStatus()">
                <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"  style="width: 24px; height: 24px; fill: #002d1c;"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM609.3 512l-137.8 0c5.4-9.4 8.6-20.3 8.6-32l0-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2l61.4 0C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/></svg>
                </span>
                <span class="text">Manage Accounts</span>
            </a>
        </li>
        <li>
            <a href="admin_display_results.php">
                <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  style="width: 24px; height: 24px; fill: #002d1c;"s><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M168 80c-13.3 0-24 10.7-24 24l0 304c0 8.4-1.4 16.5-4.1 24L440 432c13.3 0 24-10.7 24-24l0-304c0-13.3-10.7-24-24-24L168 80zM72 480c-39.8 0-72-32.2-72-72L0 112C0 98.7 10.7 88 24 88s24 10.7 24 24l0 296c0 13.3 10.7 24 24 24s24-10.7 24-24l0-304c0-39.8 32.2-72 72-72l272 0c39.8 0 72 32.2 72 72l0 304c0 39.8-32.2 72-72 72L72 480zM176 136c0-13.3 10.7-24 24-24l96 0c13.3 0 24 10.7 24 24l0 80c0 13.3-10.7 24-24 24l-96 0c-13.3 0-24-10.7-24-24l0-80zm200-24l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"/></svg>
                </span>
                <span class="text">Report</span>
            </a>
        </li>
        <li>
            <a href="admin_backup.php">
                <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"  style="width: 24px; height: 24px; fill: #002d1c;">
                    <path d="M384 336l-192 0c-8.8 0-16-7.2-16-16l0-256c0-8.8 7.2-16 16-16l140.1 0L400 115.9 400 320c0 8.8-7.2 16-16 16zM192 384l192 0c35.3 0 64-28.7 64-64l0-204.1c0-12.7-5.1-24.9-14.1-33.9L366.1 14.1c-9-9-21.2-14.1-33.9-14.1L192 0c-35.3 0-64 28.7-64 64l0 256c0 35.3 28.7 64 64 64zM64 128c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l192 0c35.3 0 64-28.7 64-64l0-32-48 0 0 32c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256c0-8.8 7.2-16 16-16l32 0 0-48-32 0z"/></svg>
                </span>
                <span class="text">Backup Database</span>
            </a>
        </li>
        <li>
            <a href="admin_activity_log.php">
                <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  style="width: 24px; height: 24px; fill: #002d1c;">
                    
                    <path d="M40 48C26.7 48 16 58.7 16 72l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24L40 48zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 64zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zM16 232l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0z"/></svg>
                </span>
                <span class="text">Activity Log</span>
            </a>
        </li>
        <div class="bottom">
            <li>
                <a href="" id="sidebarLogoutButton" class="logout-btn">
                    <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  style="width: 24px; height: 24px; fill: #002d1c;"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
                    </span>
                    <span class="text">Logout</span>
                </a>
            </li>
            <li>
                <a href="admin_about.php">
                    <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"  style="width: 24px; height: 24px; fill: #002d1c;">
                        <path d="M96 64c0-17.7-14.3-32-32-32S32 46.3 32 64l0 256c0 17.7 14.3 32 32 32s32-14.3 32-32L96 64zM64 480a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/></svg>
                    </span>
                    <span class="text">About</span>
                </a>
            </li>
        </div>
    </ul>
</div>
<button id="print" class="print-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  class="input-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>Print</button>
    
<br><div class="seal">
    <img src ="images/seal.png" alt="Tagaytay City Seal">
  </div>
  <div class="cctlogo">
    <img src ="images/cctlogo.png" alt="Tagaytay City Seal">
  </div>
<br>
<div class="address">
    <h3>Republic of the Philippines</h3>
    <h3>City of Tagaytay</h3>
    <h2>Office of the City Assessor</h2><br>
</div>


    <h1 class="reportHeader">Summary of Status Report</h1>
    <br>
    <br>
    <table class="summary-table">
        <tr>
            <th>Location</th>
            <th>Total Owned Lots/Slots</th>
            <th>Total Available Lots/Slots</th>
            <th>Action</th>
        </tr>';
        
    foreach ($grouped as $key => $group) {
        echo "<tr>
            <td>{$group['name']}</td>
            <td>{$group['total_matched']}</td>
            <td>{$group['total_unmatched']}</td>
            <td><button class='view-details' onclick='showDetails(\"$key\")'>View Details</button></td>
        </tr>";
    }

    echo '</table>';
    

    // Create modals for each group
    foreach ($grouped as $key => $group) {
        echo "<div id='modal-$key' class='details-modal'>
            <div class='modal-content'>
                <span class='close-modal' onclick='hideDetails(\"$key\")'>&times;</span>
                <h2 style='color: #004100;margin-top: 1px;'>{$group['name']} Details</h2>
                <table class='details-table'>
                    <tr>
                        <th>Location</th>
                        <th>Owned Lots/Slots</th>
                        <th>Available Lots/Slots</th>
                    </tr>";
        
        foreach ($group['items'] as $item) {
            echo "<tr>
                <td>{$item['name']}</td>
                <td>{$item['counts']['matched']}</td>
                <td>{$item['counts']['unmatched']}</td>
            </tr>";
        }
        
        echo "</table>
            </div>
        </div>
        
         <div id='confirmModal' class='mudal' style='display: none;'>
        <div class='modal-contint'>
            <h2>Logout Confirmation</h2>
            <p>Are you sure you want to logout?</p>
            <br>
            <div class='modal-buttons'>
                <button id='confirmButton' class='btn btn-confirm'>Yes, log me out</button>
                <button id='cancelButton' class='btn btn-cancel'>No, Stay here</button>
            </div>
        </div>
    </div>
        ";
    }

    echo '<script>
    function showDetails(groupId) {
        document.getElementById("modal-" + groupId).style.display = "block";
    }
    
    function hideDetails(groupId) {
        document.getElementById("modal-" + groupId).style.display = "none";
    }
    
    window.onclick = function(event) {
        if (event.target.classList.contains("details-modal")) {
            event.target.style.display = "none";
        }
    }

       // Prevent zoom using wheel event
        document.addEventListener("wheel", function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        }, { passive: false });

        // Prevent zoom using keydown events
        document.addEventListener("keydown", function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === "+" || e.key === "-" || e.key === "=")) {
                e.preventDefault();
            }
        });

        document.getElementById("print").addEventListener("click", function() {
    window.print();
});

    // When the user clicks the logout button, show the modal
document.getElementById("sidebarLogoutButton").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default logout action
    const modal = document.getElementById("confirmModal");
    modal.style.display = "flex"; // Show the modal
});

// When the user clicks the cancel button, hide the modal
document.getElementById("cancelButton").addEventListener("click", function() {
    const modal = document.getElementById("confirmModal");
    modal.style.display = "none"; // Hide the modal
});


// When the user clicks the confirm button, proceed with the logout
document.getElementById("confirmButton").addEventListener("click", function() {
    window.location.href = "logout.php"; // Redirect to the logout page
});
    </script>
</body>
</html>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
} else {
    displayRecordStatus();
}
?>