<?php
session_start();
require_once 'security_check.php';
checkAdminAccess();
require("db-connection.php");

if (!isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
function toProperCase($str) {
    return ucwords(strtolower(trim($str)));
}

$error_message = "";
$success_message = "";

// Handle password verification AJAX request
if (isset($_POST['verify_password'])) {
    $id = mysqli_real_escape_string($conn, $_POST['staff_id']);
    $current_password = $_POST['current_password'];
    
    $query = "SELECT password, accountStatus FROM staff WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    $response = array(
        'status' => 'invalid',
        'message' => 'Invalid password'
    );
    
    if ($user) {
        $stored_password = trim($user['password']); // Remove any whitespace
        $is_valid = false;
        
        // First try direct comparison with MD5
        $md5_password = md5($current_password);
        if ($md5_password === $stored_password) {
            $is_valid = true;
            
            // Upgrade to modern hash if you want
            $modern_hash = password_hash($current_password, PASSWORD_DEFAULT);
            $upgrade_query = "UPDATE staff SET password = ? WHERE id = ?";
            $upgrade_stmt = mysqli_prepare($conn, $upgrade_query);
            mysqli_stmt_bind_param($upgrade_stmt, "ss", $modern_hash, $id);
            mysqli_stmt_execute($upgrade_stmt);
        } 
        // If MD5 doesn't match, try password_verify for modern hashes
        elseif (strlen($stored_password) > 32) {
            $is_valid = password_verify($current_password, $stored_password);
        }
        
        if ($is_valid) {
            $response['status'] = 'valid';
            $response['message'] = 'Password verified successfully';
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
// Fetch staff member data
if (isset($_GET['id'])) {
    $staff_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM staff WHERE id = '$staff_id'";
    $result = mysqli_query($conn, $query);
    $staff = mysqli_fetch_assoc($result);

    if (!$staff) {
        header("Location: admin_status.php");
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['verify_password'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } else {
        // Check if username already exists (excluding current user)
        $check_username = mysqli_query($conn, "SELECT id FROM staff WHERE username = '$username' AND id != '$id'");
        if (mysqli_num_rows($check_username) > 0) {
            $error_message = "Username already exists";
        } else {
            // Initialize the update query
            $update_query = "UPDATE staff SET 
                fullname = '$fullname',
                username = '$username',
                email = '$email'";
            
            // If new password is provided and verified, add to update query
            if (!empty($new_password)) {
                if ($new_password !== $confirm_password) {
                    $error_message = "New passwords do not match";
                } elseif (strlen($new_password) < 8) {
                    $error_message = "New password must be at least 8 characters long";
                } else {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query .= ", password = '$hashed_password'";
                }
            }
            
            if (empty($error_message)) {
                $update_query .= " WHERE id = '$id'";
                
                if (mysqli_query($conn, $update_query)) {
                    $success_message = "Staff information updated successfully";
                    // Refresh staff data
                    $result = mysqli_query($conn, "SELECT * FROM staff WHERE id = '$id'");
                    $staff = mysqli_fetch_assoc($result);
                } else {
                    $error_message = "Error updating information: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Account</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        .edit-form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
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
            border: 1px solid #ddd;
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

        .password-feedback {
            position: absolute;
            right: 10px;
            top: 35px;
            color: #666;
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

        .btn-edit:hover, .btn-cancel:hover, .btn-verify:hover {
            opacity: 0.9;
        }

        .password-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
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
    </style>
</head>
<body style="background: #071c14;">
    <div class="edit-form-container">
        <h2>Edit Staff Account</h2>
        
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="" id="editForm">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($staff['id']); ?>">
            
            <div class="form-group">
    <label for="fullname">Full Name</label>
    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars(toProperCase($staff['fullname'])); ?>" required>
</div>

<div class="form-group">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars(toProperCase($staff['username'])); ?>" required>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars(strtolower($staff['email'])); ?>" required>
</div>

            <div id="passwordVerificationSection">
                <h3>Password Verification</h3>
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
        document.getElementById('verifyPasswordBtn').addEventListener('click', function() {
    const currentPassword = document.getElementById('current_password').value;
    const staffId = document.querySelector('input[name="id"]').value;
    const statusDiv = document.getElementById('passwordStatus');
    const newPasswordSection = document.getElementById('newPasswordSection');
    
    if (!currentPassword) {
        statusDiv.textContent = 'Please enter your current password';
        statusDiv.className = 'password-status error';
        return;
    }

    // Send AJAX request to verify password
    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `verify_password=1&staff_id=${staffId}&current_password=${encodeURIComponent(currentPassword)}`
    })
    .then(response => response.json())
    .then(result => {
        statusDiv.textContent = result.message;
        if (result.status === 'valid') {
            statusDiv.className = 'password-status success';
            newPasswordSection.style.display = 'block';
            document.getElementById('current_password').readOnly = true;
            this.disabled = true;
        } else {
            statusDiv.className = 'password-status error';
            newPasswordSection.style.display = 'none';
        }
    })
    .catch(error => {
        statusDiv.textContent = 'Error verifying password';
        statusDiv.className = 'password-status error';
    });
});
    </script>
</body>
</html>