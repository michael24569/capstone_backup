<?php
session_start();
include 'db-connection.php';

unset($_SESSION['forgot-passW']);

// Set lockout expiry time for client-side countdown
$lockoutUntil = null;
if (isset($_COOKIE['security_lockout_until']) && time() < intval($_COOKIE['security_lockout_until'])) {
    $lockoutUntil = intval($_COOKIE['security_lockout_until']);
} elseif (isset($_SESSION['security_lockout_until']) && time() < $_SESSION['security_lockout_until']) {
    $lockoutUntil = $_SESSION['security_lockout_until'];
}

if (!isset($_SESSION['access_question'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_answer'])) {
    // If a persistent lockout is active, do not process further.
    if ((isset($_COOKIE['security_lockout_until']) && time() < intval($_COOKIE['security_lockout_until'])) ||
        (isset($_SESSION['security_lockout_until']) && time() < $_SESSION['security_lockout_until'])) {
        // Lockout is active; error displayed below.
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
                    // Correct answer: clear lockout from session and cookie
                    unset($_SESSION['security_failed_attempts'], $_SESSION['security_lockout_duration'], $_SESSION['security_lockout_until']);
                    setcookie('security_lockout_until', '', time()-3600, '/');
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
                        // Set a persistent cookie for lockout
                        setcookie('security_lockout_until', $_SESSION['security_lockout_until'], $_SESSION['security_lockout_until'], '/');
                        $_SESSION['security_failed_attempts'] = 0; // reset attempts for next cycle
                        $securityQuestionError = "Too many failed attempts. Please wait {$_SESSION['security_lockout_duration']} seconds before trying again.";
                        $lockoutUntil = $_SESSION['security_lockout_until'];
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
    <form method="post" action="" <?php echo ($lockoutUntil || isset($securityQuestionError)) ? 'style="margin-top:0;"' : ''; ?>>
    <?php if ($lockoutUntil): ?>
        <p id="lockoutError" class="error">Too many failed attempts. Please wait <span id="countdown"></span> seconds.</p>
    <?php elseif ($securityQuestionError): ?>
        <p class="error"><?php echo htmlspecialchars($securityQuestionError); ?></p>
    <?php endif; ?>
        <h1>Security Question</h1>
        <p>Security Question: <?php echo htmlspecialchars($securityQuestion); ?></p>
        <label for="security_answer">Your Answer:</label>
        <input type="text" id="security_answer" name="security_answer" required autocomplete="off">
        <input type="submit" name="verify_answer" value="Verify">
        <p><a href="unset_question.php"> ← Back</a></p>
    </form>
    
    <?php if ($lockoutUntil): ?>
    <script type="text/javascript">
        // Set lockout countdown timer using lockout expiry time from PHP (in seconds)
        var lockoutUntil = <?php echo $lockoutUntil; ?> * 1000; // Convert to milliseconds
        var errorElem = document.getElementById('lockoutError');
        var countdownElem = document.getElementById('countdown');
        var now = new Date().getTime();
        if (lockoutUntil - now <= 0) {
            if (errorElem) {
                errorElem.style.display = 'none';
            }
        } else {
            var interval = setInterval(function(){
                var now = new Date().getTime();
                var remaining = Math.floor((lockoutUntil - now) / 1000);
                if (remaining <= 0) {
                    clearInterval(interval);
                    if (errorElem) {
                        errorElem.style.display = 'none';
                    }
                } else {
                    countdownElem.innerHTML = remaining;
                }
            }, 1000);
        }
    </script>
    <?php endif; ?>
</body>
</html>
