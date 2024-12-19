<?php
session_start();
require_once 'security_check.php';
checkAdminAccess(); 
require("db-connection.php");

function toProperCase($str) {
    return ucwords(strtolower(trim($str)));
}

$securityQuestions = [
  'In what city were you born?',
    'What was the name of your first school?',
    'What was the first exam you failed?',
    'What was the name of your first pet?',
    'What is your favorite book?',
    'What was your favorite subject in school?',
    'Who was your childhood hero?'
];

$error_message = "";
$success_message = "";
$admin_id = $_SESSION['id'];

// Handle password verification AJAX request
if (isset($_POST['verify_password'])) {
    $current_password = $_POST['current_password'];
    
    $query = "SELECT password FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    $response = array(
        'status' => 'invalid',
        'message' => 'Invalid password'
    );
    
    if ($user && password_verify($current_password, $user['password'])) {
        $response = array(
            'status' => 'valid',
            'message' => 'Password verified successfully'
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Fetch admin data
$query = "SELECT fullname, username, security_question FROM admin WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

// Check if admin exists
if (!$admin) {
    header("Location: index.php");
    exit();
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['verify_password'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $security_question = trim($_POST['security_question']);
    $security_answer = trim($_POST['security_answer']);
    
    // Check if username already exists (excluding current admin)
    $check_username = "SELECT id FROM admin WHERE username = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $check_username);
    mysqli_stmt_bind_param($stmt, "si", $username, $admin_id);
    mysqli_stmt_execute($stmt);
    $username_result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($username_result) > 0) {
        $error_message = "Username already exists";
    } else {
        // Initialize the update query with prepared statement
        $update_fields = ["fullname = ?", "username = ?", "security_question = ?"];
        $param_types = "sss";
        $params = [$fullname, $username, $security_question];
        
        // Only include security answer in update if it's provided
        if (!empty($security_answer)) {
            $hashed_security_answer = password_hash(strtolower($security_answer), PASSWORD_DEFAULT);
            $update_fields[] = "security_answer = ?";
            $param_types .= "s";
            $params[] = $hashed_security_answer;
        }
        
        // Handle password update if provided
        if (!empty($new_password)) {
            if ($new_password !== $confirm_password) {
                $error_message = "New passwords do not match";
            } elseif (strlen($new_password) < 8) {
                $error_message = "New password must be at least 8 characters long";
            } elseif (!preg_match("/[a-z]/", $new_password)) {
                $error_message = "Password must contain at least one lowercase letter.";
            } elseif (!preg_match("/[A-Z]/", $new_password)) {
                $error_message = "Password must contain at least one uppercase letter.";
            } elseif (!preg_match("/[0-9]/", $new_password)) {
                $error_message = "Password must contain at least one number.";
            } elseif (!preg_match("/[\W_]/", $new_password)) {
                $error_message = "Password must contain at least one special character (e.g., !@#$%^&*).";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_fields[] = "password = ?";
                $param_types .= "s";
                $params[] = $hashed_password;
            }
        }
        
        if (empty($error_message)) {
            $param_types .= "i";
            $params[] = $admin_id;
            
            $update_query = "UPDATE admin SET " . implode(", ", $update_fields) . " WHERE id = ?";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, $param_types, ...$params);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Your information has been updated successfully";
                // Update session username if username was changed
                if ($_SESSION['username'] !== $username) {
                    $_SESSION['username'] = $username;
                }
                // Refresh admin data
                $result = mysqli_query($conn, "SELECT * FROM admin WHERE id = $admin_id");
                $admin = mysqli_fetch_assoc($result);
            } else {
                $error_message = "Error updating information: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!-- Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin Account</title>
    <link rel="stylesheet" href="style1.css">
    <style>
.edit-form-container {
            margin-top:90px;
            margin-left:35%;
            width: 500px;
            align-items:center;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            position: relative;
        }
       

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #333;
            border-radius: 4px;
            font-size: 16px;
        }

        .error-message {
            color: #f44336;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffebee;
            border-radius: 4px;
        }

        .success-message {
            color: #4CAF50;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #E8F5E9;
            border-radius: 4px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-verify {
            background-color: #2196F3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 22px;
            margin-left: 10px;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        #passwordVerificationSection {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .current-password-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .password-status {
            font-size: 14px;
            margin-top: 5px;
        }

        .password-status.error {
            color: #f44336;
        }

        .password-status.success {
            color: #4CAF50;
        }    
        .input-group select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .input-group label {
            margin-left: 10px;
            margin-top: 6px;
        }
        .input-group input {
            height: 30px;
            padding-left: 10px;
        }
        </style>
</head>
<body style="background: #071c14;">
    <div class="edit-form-container">
        <h2>Edit Admin Account</h2>
        <br>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="" id="editForm">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars(toProperCase($admin['fullname'])); ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars(toProperCase($admin['username'])); ?>" required autocomplete="off">
            </div>
            <div class="input-group">
                <i class="fas fa-question-circle"></i>
                <select name="security_question" id="security_question">
        <option value="">Select Security Question</option>
        <?php foreach ($securityQuestions as $question): ?>
            <option value="<?php echo htmlspecialchars($question); ?>" 
                <?php echo ($admin['security_question'] === $question) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($question); ?>
            </option>
        <?php endforeach; ?>
    </select>
            </div>
            
            <div class="input-group">
                <i class="fas fa-check-circle"></i>
                <input type="text" name="security_answer" id="security_answer" placeholder="Security Answer" 
                    value="<?php echo htmlspecialchars($_POST['security_answer'] ?? ''); ?>" autocomplete="off">
                <label for="security_answer">Security Answer</label>
            </div>
            <div id="passwordVerificationSection">
                <h3>Change Password</h3>
                <div class="current-password-container">
                    <div class="form-group" style="flex-grow: 1; margin-bottom: 0;">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>
                    <button type="button" id="verifyPasswordBtn" class="btn-verify">Verify Password</button>
                </div>
                <div id="passwordStatus" class="password-status"></div>
            </div>

            <div id="newPasswordSection" style="display: none;">
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" minlength="8">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" minlength="8">
                </div>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-edit">Save Changes</button>
                <a href="admin_status.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <script>
const inputIds = ['current_password', 'new_password','confirm_password',];
    inputIds.forEach(id => {
    const input = document.getElementById(id);
        input.addEventListener('input', function() {
        this.value = this.value.replace(/\s/g, ''); // Remove spaces
        });
    });

        document.getElementById('verifyPasswordBtn').addEventListener('click', function() {
            var currentPassword = document.getElementById('current_password').value;
            
            if (currentPassword === "") {
                document.getElementById('passwordStatus').innerText = "Please enter your current password.";
                return;
            }
            
            var formData = new FormData();
            formData.append('verify_password', true);
            formData.append('current_password', currentPassword);
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    var response = JSON.parse(xhr.responseText);
                    passwordStatus.className = 'password-status ' + (response.status === 'valid' ? 'success' : 'error');
                    passwordStatus.innerText = response.message;
                    
                    if (response.status === 'valid') {
                        document.getElementById('newPasswordSection').style.display = 'block';
                    }
                }
            };
            xhr.send(formData);
        });


        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alert = document.querySelector('.success-message');
                if (alert) {
                    alert.classList.remove('show');
                    alert.style.display = 'none';
                }
            }, 2000); //S
        });
    </script>
</body>
</html>