<?php
session_start();
include 'db-connection.php';

unset($_SESSION['forgot-passW']);

// Check if user is locked out and assign error message instead of terminating
if (isset($_SESSION['security_lockout_until']) && time() < $_SESSION['security_lockout_until']) {
    $remaining = $_SESSION['security_lockout_until'] - time();
    $securityQuestionError = "Too many failed attempts. Please try again in {$remaining} seconds.";
}

if (!isset($_SESSION['access_question'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_answer'])) {
    // If a lockout is active, do not process the request further.
    if (isset($_SESSION['security_lockout_until']) && time() < $_SESSION['security_lockout_until']) {
        // Do nothing; the error message from above will be displayed.
    } else {
        // Initialize failure counter if not set
        if (!isset($_SESSION['security_failed_attempts'])) {
            $_SESSION['security_failed_attempts'] = 0;
        }
    
        $userAnswer = trim($_POST['security_answer'] ?? '');
    
        if (empty($userAnswer)) {
            $securityQuestionError = "Please provide an answer";
        } else {
            $userId = $_SESSION['forgot_password_user']['id'];
            $role = $_SESSION['forgot_password_user']['role'];
        
            // Verify security answer using password_verify()
            $sql = $role === 'Staff'
                ? "SELECT security_answer FROM tbl_staff WHERE id = ?"
                : "SELECT security_answer FROM tbl_admin WHERE id = ?";
            // Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if ($row = mysqli_fetch_assoc($result)) {
                // Use password_verify to compare the input with the hashed answer
                if (password_verify(strtolower($userAnswer), $row['security_answer'])) {
                    // Correct answer: reset failure counter and lockout duration
                    unset($_SESSION['security_failed_attempts'], $_SESSION['security_lockout_duration'], $_SESSION['security_lockout_until']);
                    $_SESSION['can_reset_password'] = true;
                    header("Location: reset-password.php");
                    exit();
                } else {
                    // Wrong answer: increment failure counter
                    $_SESSION['security_failed_attempts']++;
                    if ($_SESSION['security_failed_attempts'] >= 3) {
                        // Lockout logic: initial penalty is 180 seconds; each subsequent 3-failure cycle adds 120 seconds.
                        if (!isset($_SESSION['security_lockout_duration'])) {
                            $_SESSION['security_lockout_duration'] = 180; // 180 seconds for first cycle
                        } else {
                            $_SESSION['security_lockout_duration'] += 120; // add 120 seconds for subsequent cycles
                        }
                        $_SESSION['security_lockout_until'] = time() + $_SESSION['security_lockout_duration'];
                        $_SESSION['security_failed_attempts'] = 0; // reset attempts for next cycle
                        $securityQuestionError = "Too many failed attempts. Please wait {$_SESSION['security_lockout_duration']} seconds before trying again.";
                    } else {
                        $securityQuestionError = "Incorrect security answer";
                    }
                }
            } else {
                $securityQuestionError = "User not found";
            }
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
