<?php 
$token = $_GET["token"];
$token_hash = hash("sha256", $token);
$mysqli = require __DIR__ . "/db-connection.php";

// Check both staff and admin tables for the token
$sql = "SELECT 'staff' AS type, id, token_expiry FROM tbl_staff WHERE token_reset = ?
        UNION
        SELECT 'admin' AS type, id, token_expiry FROM tbl_admin WHERE token_reset = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $token_hash, $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user === null) {
    $error = "Token not found.";
} elseif (strtotime($user["token_expiry"]) <= time()) {
    $error = "Token has expired.";
}

require ("reset-password.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="recover.css">
</head>
<!-- Developers: Backend Developer: Michael Enoza, Frontednd Developer: Kyle Ambat -->
<body style="background: #001f14;">
<div class="container" id="signup">
    <h1 class="form-title">Reset Password</h1>
    <form action="" method="post">
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input class="height" type="password" name="password" id="password" placeholder="Create new password" required>
            <label for="password">Create new password</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input class="height" type="password" name="confirm_password" id="password" placeholder="Confirm Password" required>
            <label for="password">Confirm new password</label>
        </div>

        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if(isset($successful)) { echo "<p class='successful' id='success'>$successful</p>"; } ?>

        <input type="submit" class="btn" value="Confirm" name="confirm">
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
