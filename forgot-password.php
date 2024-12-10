<?php
session_start();
include 'db-connection.php';

$error = null;
$securityQuestionError = null;

// Fetch security questions
$securityQuestions = [
   'In what city were you born?',
    'What was the name of your first school?',
    'What was the first exam you failed?',
    'What was the name of your first pet?',
    'What is your favorite book?',
    'What was your favorite subject in school?',
    'Who was your childhood hero?'
];

// Check if username exists and has a security question set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_username'])) {
    $username = trim($_POST['username'] ?? '');
    
    if (empty($username)) {
        $error = "Please enter a username";
    } else {
        // Check in both staff and admin tables
        $sql = "SELECT id, security_question, security_answer, 'Staff' AS role FROM staff WHERE username = ?
                UNION
                SELECT id, security_question, security_answer, 'Admin' AS role FROM admin WHERE username = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            // Store user details in session for next step
            $_SESSION['forgot_password_user'] = [
                'id' => $row['id'],
                'role' => $row['role'],
                'security_question' => $row['security_question']
            ];
            
            header("Location: security-question.php");
            exit();
        } else {
            $error = "Username not found";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet"href="forgotpass.css">
<head>
    <title>Forgot Password</title>
</head>
<body>


    <form method="post" action="">
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
        <br>
        <h1>Forgot Password</h1>
        <br>
        
        <input type="text" id="username" name="username" required autocomplete="off" placeholder="Username">
        <input type="submit" name="check_username" value="Next">
        <p><a href="index.php"> ← Back to Login</a></p>
    </form>
</body>
</html>