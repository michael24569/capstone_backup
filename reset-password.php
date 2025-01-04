<?php
session_start();
include 'db-connection.php';
require_once 'security_check.php';
userCheckLogin();

unset($_SESSION['access_question']);
unset($_SESSION['forgot-passW']);

if(!isset($_SESSION['can_reset_password'])) {
    header("Location: index.php");
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'back_to_login') {
    unset($_SESSION['can_reset_password']);
    header("Location: index.php"); // Redirect to forgot password page
    exit();
  }

$passwordError = null;
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($newPassword) || empty($confirmPassword)) {
        $passwordError = "Both password fields are required";
    } elseif ($newPassword !== $confirmPassword) {
        $passwordError = "Passwords do not match";
    } elseif (strlen($newPassword) < 8) {
        $passwordError = "Password must be at least 8 characters long";
    } elseif (!preg_match("/[a-z]/", $newPassword)) {
        $error_message = "Password must contain at least one lowercaseletter.";
    }  elseif (!preg_match("/[A-Z]/", $newPassword)) {
        $error_message = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match("/[0-9]/", $newPassword)) {
        $error_message = "Password must contain at least one number.";
    } elseif (!preg_match("/[\W_]/", $newPassword)) { // Must contain at least one special character
        $error_message = "Password must contain at least one special character (e.g., !@#$%^&*).";
    } else {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Determine which table to update based on stored role
        $userId = $_SESSION['forgot_password_user']['id'];
        $role = $_SESSION['forgot_password_user']['role'];
        
        $sql = $role === 'Staff' 
            ? "UPDATE tbl_staff SET password = ? WHERE id = ?"
            : "UPDATE tbl_admin SET password = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            // Clear sessions and redirect
            unset($_SESSION['forgot_password_user']);
            unset($_SESSION['can_reset_password']);
            unset($_SESSION['access-question']);
            session_destroy();
            
            $_SESSION['success_message'] = "Password successfully reset. Please log in.";
            header("Location: index.php");
            exit();
        } else {
            $passwordError = "Error updating password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset.css">
     <script type="text/javascript">
    // Prevent back navigation
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, null, window.location.href);
    };
</script>
</head>
<body>
    

    <form method="post" action="">
    <?php if ($passwordError): ?>
        <p class="error"><?php echo htmlspecialchars($passwordError); ?></p>
    <?php endif; ?>
        <h1>Reset Password</h1>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        
        <br>
        <input type="submit" name="reset_password" value="Reset Password">
        <p><a href="index.php">← Back</a></p>
    </form>

    <script>
        const inputIds = ['new_password', 'confirm_password'];
        inputIds.forEach(id => {
            const input = document.getElementById(id);
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\s/g, ''); // Remove spaces
            });
        });
    </script>
</body>
</html>
