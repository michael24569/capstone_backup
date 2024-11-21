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
  right:40px;
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
  bottom:15px;
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
  bottom:15px;
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

/* Sidebar toggle button */
/* Sidebar toggle button */
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

  .sidebar {
    transform: translateX(-100%); /* Hide sidebar by default */
    transition: transform 0.3s ease-in-out;
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
}s
    </style>
</head>
<body>
<button id="sidebarToggle" class="sidebar-toggle-btn">
<button class="top-left-button">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
      <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
    </svg>
  </button>
</button>
    <div class="container">
        <h1>About Us</h1>
        <div class="team-container">
            <div class="team-member">
                <img src="aboutimg/kyle.png" alt="Team Member 1">
                <div class="name">Kyle Cyrus Ambat <br><span>Developer<br>BSIT 4-1 </span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/michael.png" alt="Team Member 2">
                <div class="name">Michael Enoza <br><span>Developer <br>BSIT 4-1</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/david.png" alt="Team Member 3">
                <div class="name">John David Pasion <br><span>Documentation <br>BSIT 4-1</span></div>
            </div>
            <div class="team-member">
                <img src="aboutimg/malcom.png" alt="Team Member 4">
                <div class="name">Malcolm Yabia <br><span>Documentation <br>BSIT 4-1</span></div>
            </div>
        </div>
    </div>
    <script>

      
        //for clicking the button *not functioning/ need to fix*
document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggleButton = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    // Ensure elements exist
    if (sidebarToggleButton && sidebar) {
        sidebarToggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('active'); // Toggle active class on sidebar
        });
    }
});
</script>


    <?php include 'admin_sidebar.php'; ?>
</body>

</html>
