<?php
session_start();
require_once 'security_check.php';
checkAdminAccess();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">
    <style>
        .sidebar {
            bottom: 0px;
            position: fixed;
            width: 60px;
            height: 100vh;
            background: #dee7e2;
            overflow: hidden;
            transition: 0.5s;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 50px 40px black;
        }
        .sidebar:hover {
            width: 300px;
        }
        .sidebar ul {
            position: relative;
            height: 100vh;
            margin-left: -40px;
            margin-top: -0px;
        }
        .sidebar ul li {
            list-style: none;
        }
        .sidebar ul li:hover {
            background: #dae2de;
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
            font-family: "Michroma", sans-serif;
            position: relative;
            height: 60px;
            display: flex;
            align-items: center;
            font-size: 10px;
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
        body {
            font-family: "Michroma", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #071c14;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        .team-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 100px;
        }
        .team-member {
            width: 100%;
            max-width: 250px;
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        .team-member img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }
        .team-member:hover {
            transform: scale(1.05);
        }
        .team-member .name {
            margin-top: 10px;
            font-size: 1.2em;
            font-weight: bold;
            color: white;
            opacity: 0;
            filter: blur(4px);
            animation: fadeInBlur 2s forwards;
        }
        .team-member .name span {
            font-size: 0.9em;
            font-weight: normal;
            color: #ddd;
            position: relative;
            top: -20px;
            opacity: 0;
            transition: all 0.5s ease;
        }
        .team-member:hover .name span {
            top: 0;
            opacity: 1;
            
        }
        @keyframes fadeInBlur {
            0% {
                opacity: 0;
                filter: blur(4px);
            }
            100% {
                opacity: 1;
                filter: blur(0);
            }
        }
        @media (max-width: 768px) {
            .team-member {
                width: 100%;
                max-width: 300px;
            }
        }
        @media (max-width: 480px) {
            h1 {
                font-size: 1.5em;
            }
            .team-member .name {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>About Us</h1>
        <div class="team-container">
            <div class="team-member">
                <img src="aboutimg/kyle.png" alt="Team Member 1">
                <div class="name">Kyle Cyrus Ambat <br><span>Role</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/michael.jfif" alt="Team Member 2">
                <div class="name">Michael Enoza <br><span>Role</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/david.png" alt="Team Member 3">
                <div class="name">John David Pasion <br><span>Role</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/malcom.png" alt="Team Member 4">
                <div class="name">Malcolm Yabia <br><span>Role</span></div>
            </div>
        </div>
    </div>
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
                    <span class="text">Manage Accounts</span>
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
                    <span class="icon"><ion-icon name="receipt-outline"></ion-icon></span>
                    <span class="text">Activity Log</span>
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
                    <a href="about.html">
                        <span class="icon"><ion-icon name="alert-outline"></ion-icon></span>
                        <span class="text">About</span>
                    </a>
                </li>
            </div>
        </ul>
    </div>
</body>
</html>
