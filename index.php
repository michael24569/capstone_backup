<?php
session_start();

require_once 'security_check.php';
userCheckLogin();

require("loginCondition.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript">
   window.history.forward();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
   
</head>
<body >
<div class="blur-box">
 <!-- Animated Text Section -->
<div class="animated-container">
  <div class="animated-text">2D Mapping and<br>Management System</div>
  <div class="animated-text">for Tagaytay Memorial Park</div>
  <div class="line"></div>
  
</div>
<div class="seal">
    <img src ="images/seal.png" alt="Tagaytay City Seal">
  </div>
  <div class="cctlogo">
    <img src ="images/cctlogo.png" alt="City College of Tagaytay">
  </div>
    <div class="container" id="signin">
        <div class="login-form">
        <div class="icon-signIn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="signIn-icon"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M399 384.2C376.9 345.8 335.4 320 288 320l-64 0c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
      
        </div>
        <h1 class="form-title">Sign In</h1>
         <form action="" method="post">
            <div class="input-group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="input-icon">
      <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
    </svg>
  </div>
  <div class="input-field">
    <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
    <label for="username">Username</label>
            </div>
            <div class="input-group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="input-icon">
            <path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
  </div>
  <div class="input-field">
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="off">
                <label for="password">Password</label>
            </div>
            </div>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
            <input type="submit" class="btn" value="Sign In" name="signin">
        </form>
        </div>
    </div>
    <style>
    
 
    * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }
  .blur-box {
    width: 80%;
    height:90%;
    box-shadow: 0  0 30px 0px black;
    border-radius: 15px;
    
 }
  body {
    font-family: 'MyFont';
    height: 100vh;
    background-color: #c9d6ff;
    background: linear-gradient(to right,#e2e2e2,#c9d6ff);
    justify-content: center;
    align-items: center;
    display: flex;
    background: 
    linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
    url('images/s2.jpg');
    background-size: cover;
    background-position: center;
    z-index: 10;
    
  }
  .container {
    background-color:#ffffff93;

    backdrop-filter: blur(5px);
    width: 400px;
    padding:20px;
    margin-left: 55%;
    margin-top: 15%;
    border-radius: 5px;
    box-shadow: 0 8px 32px 0 #00000080;
}
  form{
    margin: 0 2rem;
  
  }
  .form-title{
    font-size: 4rem;
    font-weight: bold;
    text-align: center;
    padding: 1.3rem;
    margin-bottom: 0.4rem;
  }
  input{
    color: inherit;
    width: 100%;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid #757575;
    padding-left: 1.5rem;
    font-size: 15px;
  }
  
  .input-group{
    padding: 1% 0;
    position: relative;
  }
  .input-icon {
  width: 24px; /* Adjust icon size */
  height: 24px;
  fill: black; /* Icon color */
  flex-shrink: 0;
  margin-bottom: -22px;
}
  .input-group i{
    position: absolute;
    color: black;
  }
  input:focus{
    background-color: transparent;
    outline: transparent;
    border-bottom: 2px solid hsl(327, 90%, 28%);
  }
  input::placeholder{
    color: transparent;
  }
  label{
    color: black;
    position: relative;
    left: 1.7em;
    top: -1.2em;
    cursor: auto;
    transition: 0.3s ease all;
  }
  input:focus~label,input:not(:placeholder-shown)~label{
    top: -3em;
    color:hsl(327, 90%, 28%);
    font-size: 15px;
  }
  .btn{
    font-family: 'MyFont';
    font-size: 1.5rem;
    padding: 15px 0;
    border-radius: 50px;
    outline: none;
    border: none;
    width: 100%;
    background-color: #005434;
    color: white;
    cursor: pointer;
    transition: 0.9s;
  }
  .btn:hover{
    background-color: #337F5B;
  }
  .btn:focus {
    font-size: 1.1rem;
    padding: 15px 0;
    border-radius: 5px;
    outline: none;
    border: none;
    width: 100%;
    background-color: #337F5B;
    color: white;
    cursor: pointer;
    transition: 0.9s;
}
  .links{
    display: flex;
    justify-content: space-around;
    padding: 0 4rem;
    margin-top: 0.9rem;
    font-weight: bold;
  }
  button{
    color: rgb(125, 125, 235);
    border: none;
    background-color: transparent;
    font-size: 1rem;
    font-weight: bold;
  }
  button:hover{
    text-decoration: underline;
    color: blue;
  }
  .error {
    color: #af4242;
    background-color: #fde8ec;
    padding: 15px;
    transform: translateX(0px);
    margin-bottom: 10px;
    font-size: 15px;
  }
  .recover{
    text-align: right;
    font-size: 1rem;
    margin-bottom: 1rem;
  }
  .recover a{
    text-decoration: none;
    color: black;
  }
  .recover a:hover{
    color: blue;
    text-decoration: underline;
  }
  .back{
    color: blue;
    border: none;
    background-color: transparent;
    text-decoration: none;
    font-size: 1rem;
    font-weight: bold;
  }
  .back:hover{
    text-decoration: underline;
    color: blue;
  }
  .space{
    padding-left: 20px;
  }

  .seal {
    text-align: center;
    
    }

    .seal img {
    position:absolute;
    max-width: 8%; 
    height: auto; 
    margin-top:27%;
    margin-left:-26%;
    z-index: 10000;
    }
    .cctlogo {
    text-align: center;
    
    }

    .cctlogo img {
    position:absolute;
    max-width: 7%; 
    height: auto; 
    margin-top:27%;
    margin-left:-16%;
    z-index: 10000;
    }
/* animate */
  .animated-container {
    text-align: center;
    position: absolute;
    top: 43%;
    left: 32%;
    transform: translateX(-50%);
    width:100%;
    margin-top:-40px;
    
    
  }
  .animated-text {
    text-shadow: 
        1px 1px 0px #000,      /* Top-left shadow */
       -1px -1px 0px #000,    /* Bottom-right shadow */
        1px -1px 0px #000,     /* Bottom-left shadow */
       -1px 1px 0px #000;      /* Top-right shadow */
    
    font-size: 3.3rem;
    font-weight: bold;
    color: white;
    
}


  .line {
    border-radius:10px;
    width: 0; /* Initial width, since animation grows */
    height: 5px; /* Thickness of the line */
    background: white;
    margin: 10px auto; /* Centers it vertically */

    animation: growLine 1s ease-out 1s forwards;
    transform: rotate(90deg); /* Rotates the line */
    position: relative; /* Add relative positioning */
    left: 21%;
    bottom:40px;
  }

  

  @keyframes growLine {
    from {
      width: 0;
    }
    to {
      width: 410px;
    }
  }
  .signIn-icon {
    width: 60px;
    height: 60px;
  }
  .icon-signIn {
    margin-left: 45%;
  }
  </style>
  <script>
  // will not accept space
  document.getElementById('password').addEventListener('input', function(e) {
    this.value = this.value.replace(/\s/g, ''); // Remove spaces
  });
    // Function to hide the error message when the user starts typing
    function hideErrorMessage() {
        const errorMessage = document.querySelector('.error');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }

    // Attach input event listeners to email and password fields to hide error message
    document.addEventListener('DOMContentLoaded', () => {
        const usernameField = document.getElementById('username');
        const passwordField = document.getElementById('password');
        if (usernameField && passwordField) {
          usernameField.addEventListener('input', hideErrorMessage);
            passwordField.addEventListener('input', hideErrorMessage);
        }
    });



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
