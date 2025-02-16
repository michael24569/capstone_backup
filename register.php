<?php
session_start(); // Start session to retrieve messages
require("registerCondition.php");

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Define security questions
$securityQuestions = [
    'In what city were you born?',
    'What was the name of your first school?',
    'What was the first exam you failed?',
    'What was the name of your first pet?',
    'What is your favorite book?',
    'What was your favorite subject in school?',
    'Who was your childhood hero?'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .input-group select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body style="background: #001f14;">
    <div class="container" id="signup">
        <h1 class="form-title">Create New Account</h1>
        <form action="" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fullname" id="fullname" placeholder="Full Name" 
                    value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>" required autocomplete="off"
                    pattern="[A-Za-z.\s]+" title="Only letters, dots, and spaces allowed">
                <label for="fullname">Full Name</label>
            </div>
            
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="username" name="username" id="username" placeholder="Username" 
                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required autocomplete="off">
                <label for="username">Username</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Create Password" required autocomplete="off">
                <label for="password">Create Password</label>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" id="confirmPass" placeholder="Confirm Password" required autocomplete="off">
                <label for="confirmPass">Confirm Password</label>
            </div>
            
            <div class="input-group">
                <i class="fas fa-question-circle"></i>
                <select name="security_question" required>
                    <option value="">Select Security Question</option>
                    <?php foreach ($securityQuestions as $question): ?>
                        <option value="<?php echo htmlspecialchars($question); ?>"
                            <?php echo (isset($_POST['security_question']) && $_POST['security_question'] === $question) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($question); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="input-group">
                <i class="fas fa-check-circle"></i>
                <input type="text" name="security_answer" id="security_answer" placeholder="Security Answer" 
                    value="<?php echo htmlspecialchars($_POST['security_answer'] ?? ''); ?>" required autocomplete="off">
                <label for="security_answer">Security Answer</label>
            </div>
            <!-- Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat -->
            <?php
            if(isset($error)) {
                echo "<p class='error'>$error</p>";
            }
            
            if(isset($successful)) {
                echo "<p class='successful' id='success'>$successful</p>";
            }
            ?>
            
            <input type="submit" class="btn" value="Create Account" name="signup">
        </form>
        
        <br>
        <div class="back">
            <div class="space">
                <i class="fas fa-angle-left"></i>
                <a href="admin_status.php" class="back">Cancel</a>
            </div>
        </div>
    </div>

    <script>
        const inputIds = ['password', 'confirmPass'];
        inputIds.forEach(id => {
            const input = document.getElementById(id);
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\s/g, ''); // Remove spaces
            });
        });

        var success = document.getElementById('success');
        if (success) {
            success.style.color = "#4caf50";
            success.style.backgroundColor = "#e8f5e9";
            success.style.padding = "15px";
            success.style.marginBottom = "10px";
            success.style.fontSize = "15px";
        }
    </script>
</body>
</html>