<?php
session_start();
include 'db-connection.php';

unset($_SESSION['forgot-passW']);


if (!isset($_SESSION['access_question'])) {
    header("Location: index.php");
    exit();
}
$securityQuestionError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_answer'])) {
    $userAnswer = trim($_POST['security_answer'] ?? '');
    
    if (empty($userAnswer)) {
        $securityQuestionError = "Please provide an answer";
    } else {
        $userId = $_SESSION['forgot_password_user']['id'];
        $role = $_SESSION['forgot_password_user']['role'];
        
        // Verify security answer using password_verify()
        $sql = $role === 'Staff'
            ? "SELECT security_answer FROM staff WHERE id = ?"
            : "SELECT security_answer FROM admin WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Use password_verify to compare the input with the hashed answer
            if (password_verify(strtolower($userAnswer), $row['security_answer'])) {
                // Correct answer, proceed to reset password
                $_SESSION['can_reset_password'] = true;
                header("Location: reset-password.php");
                exit();
            } else {
                $securityQuestionError = "Incorrect security answer";
            }
        } else {
            $securityQuestionError = "User not found";
        }
    }
}

$securityQuestion = $_SESSION['forgot_password_user']['security_question'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Security Question</title>
    <link rel="stylesheet" href="security.css">
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
    <?php if ($securityQuestionError): ?>
        <p class="error"><?php echo htmlspecialchars($securityQuestionError); ?></p>
    <?php endif; ?>
        <h1>Security Question</h1>
        <p>Security Question: <?php echo htmlspecialchars($securityQuestion); ?></p>
        <label for="security_answer">Your Answer:</label>
        <input type="text" id="security_answer" name="security_answer" required autocomplete="off">
        <input type="submit" name="verify_answer" value="Verify">
        <p><a href="unset_question.php"> ← Back</a></p>
    </form>
</body>
</html>
