<?php require("registerCondition.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Staff Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">

   
</head>
<body style="background: #001f14;">

   <div class="container" id="signup" >
    <h1 class="form-title">Create New Account</h1>
    <form action="" method="post">
    
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="fullname" id="fullname" placeholder="Full Name" required >
            <label for="fullname">Full Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required >
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Create Password" required>
            <label for="password">Create Password</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" id="password" placeholder="Confirm Password" required>
            <label for="password">Confirm Password</label>
        </div>

        
        <?php
    if(isset($error)) {
        echo "<p class='error'>$error</p>";
    } 
    ?>
         <?php
    if(isset($successful)) {
        echo "<p class='successful' id='success' >$successful</p>";

    } 
    ?>
    
        <input type="submit" class="btn" value="Create Account" name="signup">
        
    </form>
    <br>
    <div class="back">
        <div class="space">
        <i class="fas fa-angle-left" ></i>
        <a href="admin_status.php" class="back">Back</a>
        </div>
    </div>

   </div> 
<script>
    var success = document.getElementById('success');

    success.style.color = "#4caf50";
    success.style.backgroundColor = "#e8f5e9";
    success.style.padding = "15px";
    success.style.marginBottom = "10px";
    success.style.fontSize = "15px";

</script>
</body>
</html>