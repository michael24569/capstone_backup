<?php
session_start();
require_once 'security_check.php';
checkAdminAccess(); // Make sure only admin can access
require("db-connection.php");

// Verify admin is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

$error_message = "";
$success_message = "";
$admin_id = $_SESSION['id']; // Use session ID instead of GET parameter

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
$query = "SELECT * FROM admin WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

if (!$admin) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['verify_password'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } else {
        // Initialize the update query with prepared statement
        $update_fields = ["fullname = ?", "email = ?"];
        $param_types = "ss";
        $params = [$fullname, $email];
        
        // If new password is provided and verified
        if (!empty($new_password)) {
            if ($new_password !== $confirm_password) {
                $error_message = "New passwords do not match";
            } elseif (strlen($new_password) < 8) {
                $error_message = "New password must be at least 8 characters long";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin Profile</title>
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
        <h2>Edit Admin Profile</h2>
        
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="" id="editForm">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($admin['fullname']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
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
                <a href="dashboard.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('verifyPasswordBtn').addEventListener('click', function() {
            const currentPassword = document.getElementById('current_password').value;
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
                body: `verify_password=1&current_password=${encodeURIComponent(currentPassword)}`
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