<?php require("send-password-reset.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recover</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="recover.css">

</head>
<body style="background: #001f14;">


   <div class="container" id="signin">
    <h1 class="form-title">Forgot Password?</h1>

    <form action="" method="post">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input class="height" type="email" name="email" id="email" placeholder="Email" >
            <label for="email">Email</label>
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
        <input type="submit" class="btn" value="Submit" name="submit" >
        <p class="recover"><a href="index.php">Back to Login Page</a></p>
    </form>
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
