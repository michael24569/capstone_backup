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

// Handle password verification AJAX request
if (isset($_POST['verify_password'])) {
    $id = mysqli_real_escape_string($conn, $_POST['staff_id']);
    $current_password = $_POST['current_password'];
    
    $query = "SELECT password, accountStatus FROM tbl_staff WHERE id = ?";
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
            $upgrade_query = "UPDATE tbl_staff SET password = ? WHERE id = ?";
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
    $query = "SELECT * FROM tbl_staff WHERE id = '$staff_id'";
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
    $security_question = mysqli_real_escape_string($conn, $_POST['security_question']);
    
    // Initialize the update query
    $update_query = "UPDATE tbl_staff SET 
        fullname = '$fullname',
        username = '$username',
        security_question = '$security_question'";

    // Check if a new security question is selected
    $security_answer = trim($_POST['security_answer']);
    
    // If a new security answer is provided, hash and update it
    if (!empty($security_answer)) {
        $hashed_security_answer = password_hash(strtolower($security_answer), PASSWORD_DEFAULT);
        $update_query .= ", security_answer = '$hashed_security_answer'";
    }

    // Rest of the password update logic remains the same...
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Check if username already exists (excluding current user)
    $check_username = mysqli_query($conn, "SELECT id FROM tbl_staff WHERE username = '$username' AND id != '$id'");
    if (mysqli_num_rows($check_username) > 0) {
        $error_message = "Username already exists";
    } else {
        // Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
        // Check if new password is provided and is valid
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
            } elseif (!preg_match("/[\W_]/", $new_password)) { // Must contain at least one special character
                $error_message = "Password must contain at least one special character (e.g., !@#$%^&*).";
            } else {
                // If new password is valid, hash it and prepare to update it
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query .= ", password = '$hashed_password'"; // Append to update query
            }
        }

        // Proceed only if no error message
        if (empty($error_message)) {
            $update_query .= " WHERE id = '$id'";  // Append the WHERE condition to the query

            if (mysqli_query($conn, $update_query)) {
                $success_message = "Staff information updated successfully";
                // Refresh staff data
                $result = mysqli_query($conn, "SELECT * FROM tbl_staff WHERE id = '$id'");
                $staff = mysqli_fetch_assoc($result);
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
    <title>Edit Staff Account</title>
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-verify:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-edit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-edit svg {
            margin-right: 8px;
        }
        .btn-edit:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-cancel {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-cancel:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
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
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        </style>
</head>
<body style="background: #071c14;">
    <!-- Add the modal HTML structure -->
    <div id="confirmationModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Confirm Changes</h3>
            <p>Are you sure you want to save these changes?</p>
            <div class="modal-buttons">
                <button id="confirmSave" class="btn-edit">Yes, Save Changes</button>
                <button id="cancelSave" class="btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <div class="edit-form-container">
        <h2>Edit Staff Account</h2>
        <br>
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
    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars(toProperCase($staff['fullname'])); ?>" required autocomplete="off">
</div>

<div class="form-group">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars(toProperCase($staff['username'])); ?>" required autocomplete="off">
</div>
<div class="input-group">
                <i class="fas fa-question-circle"></i>
                <select name="security_question">
        <option value="">Select Security Question</option>
        <?php foreach ($securityQuestions as $question): ?>
            <option value="<?php echo htmlspecialchars($question); ?>"
                <?php echo ($staff['security_question'] === $question) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($question); ?>
            </option>
        <?php endforeach; ?>
    </select>
            </div>
            
            <div class="input-group">
    <i class="fas fa-check-circle"></i>
    <input type="text" name="security_answer" id="security_answer" placeholder="Security Answer" autocomplete="off">
    <label for="security_answer">Security Answer</label>
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
                <button type="submit" class="btn-edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16"><!--! Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. --><path d="M433.9 129.9L318.1 14.1C312.4 8.4 304.3 5.1 296 5.1H48C21.5 5.1 0 26.6 0 53.1V458.9C0 485.4 21.5 506.9 48 506.9H400C426.5 506.9 448 485.4 448 458.9V152C448 143.7 444.6 135.6 438.9 129.9zM224 416C206.3 416 192 401.7 192 384C192 366.3 206.3 352 224 352C241.7 352 256 366.3 256 384C256 401.7 241.7 416 224 416zM320 288H128V64H288V160H320V288z"/></svg>
                    Save Changes
                </button>
                <a href="admin_status.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <script>
const inputIds = ['current_password', 'new_password','confirm_password'];
    inputIds.forEach(id => {
    const input = document.getElementById(id);
        input.addEventListener('input', function() {
        this.value = this.value.replace(/\s/g, ''); // Remove spaces
        });
    });

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


document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alert = document.querySelector('.success-message');
                if (alert) {
                    alert.classList.remove('show');
                    alert.style.display = 'none';
                }
            }, 2000); //S
        });

        // Add form submission handling
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission
            document.getElementById('confirmationModal').style.display = 'flex';
        });

        // Handle confirmation modal buttons
        document.getElementById('confirmSave').addEventListener('click', function() {
            document.getElementById('confirmationModal').style.display = 'none';
            document.getElementById('editForm').submit(); // Actually submit the form
        });

        document.getElementById('cancelSave').addEventListener('click', function() {
            document.getElementById('confirmationModal').style.display = 'none';
        });

        // Close modal if clicking outside
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('confirmationModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

    </script>
</body>
</html>