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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body >
   <div class="container" id="signin">
        <div class="login-form">
        <h1 class="form-title">Sign In</h1>
        <form action="" method="post">
            <div class="input-group">
                <i class="fas fa-person"></i>
                <input type="username" name="username" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <p class="recover"><a href="recover.php">Forgot password?</a></p>
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
  
  body {
    font-family: "Michroma", sans-serif;
    height: 100vh;
    background-color: #c9d6ff;
    background: linear-gradient(to right,#e2e2e2,#c9d6ff);
    justify-content: center;
    align-items: center;
    display: flex;
    background-image: url('images/loginIMG.jpg');
    background-size: cover;
    background-position: center;
    z-index: 10;
  }
  .container {
    background: linear-gradient(135deg, #ffffff1a, #ffffff00);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    width: 450px;
    padding: 1.5rem;
    margin: 50px auto;
    border-radius: 10px;
    box-shadow: 0 8px 32px 0 #00000080;
}
  form{
    margin: 0 2rem;
  
  }
  .form-title{
    font-size: 1.5rem;
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
    left: 1.2em;
    top: -1.3em;
    cursor: auto;
    transition: 0.3s ease all;
  }
  input:focus~label,input:not(:placeholder-shown)~label{
    top: -3em;
    color:hsl(327, 90%, 28%);
    font-size: 15px;
  }
  .btn{
    font-size: 1.1rem;
    padding: 15px 0;
    border-radius: 5px;
    outline: none;
    border: none;
    width: 100%;
    background-color: #005434;
    color: white;
    cursor: pointer;
    transition: 0.9s;
  }
  .btn:hover{
    background: #540020;
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
  </style>
  <script>
  
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

</script>

</body>
</html>
