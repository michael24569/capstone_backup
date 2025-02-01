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
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="logoutmodal.css">
    
    
    <style>
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

.iconcolor{
  width: 24px; 
  height: 24px; 
  fill: #002d1c;
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



        body {
            
            
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
        .top-left-button {
  fill: white;
  position: absolute;
  top: 10px;
  left: 10px;
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

.info-container {
    background-color: white;
    margin: 50px auto; /* Changed to auto for horizontal centering */
    padding: 30px;
    width: 1000px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: block; /* Changed from absolute to block */
}

.info-container h2 {
    color: #071c14;
    margin-bottom: 20px;
    padding-top: 15px;
}

.info-container p {
    color: #333;
    line-height: 1.6;
    margin-bottom: 10px;
}
    </style>
</head>
<body>
<button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
  <!-- Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat -->
</button>
<?php include 'admin_sidebar.php'; ?>
    <div class="container">
        <h1>About Us</h1>
        <div class="team-container">
            <div class="team-member">
                <img src="aboutimg/kyle.png" alt="Team Member 1">
                <div class="name">Kyle Cyrus Ambat <br><span>Sub Programmer<br>BSIT 4-1 </span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/michael.png" alt="Team Member 2">
                <div class="name">Michael Enoza <br><span>Main Programmer<br>BSIT 4-1</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/david.png" alt="Team Member 3">
                <div class="name">John David Pasion <br><span>Documentation<br>BSIT 4-1</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/malcom.png" alt="Team Member 4">
                <div class="name">Malcolm Yabia <br><span>Documentation<br>BSIT 4-1</span></div>
            </div>
        </div>

        <div class="info-container">
            <h2>System Overview</h2>
            <p> This web-based system is designed to efficiently manage property ownership records, visualize mapping data, and streamline administrative tasks. It provides an integrated platform that ensures data accuracy, secure storage, and easy access for authorized users.
            </p>
            <br>
            <h2>Key Features:</h2>
            <br>
            <p><strong>Account Module:</strong> Manages user authentication and access control to ensure secure login and data protection.</p>
            <p><strong>Record Module:</strong> Enables adding, updating, and maintaining property owner records with high accuracy.</p>
            <p><strong>Mapping Module:</strong> Provides a dynamic 2D map interface to visualize property ownership and related data.</p>
            <p><strong>Report Module:</strong> Generates detailed reports showing the number of owned and available lots in specific areas like Saints, Columbarium, and Apartments.</p>
            <p><strong>Backup Module:</strong> Ensures data integrity through reliable backup and restoration processes.</p>
            <p><strong>Activity Log Module:</strong> Tracks all user activities within the system for monitoring and security purposes.
Purpose and Benefits:
The system aims to improve workflow efficiency by automating the retrieval of property owner records in Tagaytay Memorial Park, enhancing data accessibility, and ensuring secure record-keeping. It helps organizations manage property-related data seamlessly, making operations faster, more accurate, and more reliable.</p>
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
    <script>

      
       // Function to toggle the sidebar visibility with timer
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.add('active'); // Open the sidebar by adding the 'active' class
  
    // Set a timer to close the sidebar after 5 seconds
    setTimeout(function() {
      sidebar.classList.remove('active'); // Close the sidebar after 5 seconds
    }, 5000); // 5000 milliseconds = 5 seconds
  }
  

  
// anti zooom 
    
        // Prevent zoom using wheel event
        document.addEventListener('wheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        }, { passive: false });

        // Prevent zoom using keydown events
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === '+' || e.key === '-' || e.key === '=')) {
                e.preventDefault();
            }
        });
</script>

</body>

</html>
