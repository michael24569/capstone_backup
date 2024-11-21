<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("db-connection.php");

    // Retrieve email and password from POST data
    $newEmail = $_POST['email'] ?? '';
    $enteredPassword = $_POST['password'] ?? '';
    $userId = $_SESSION['id']; // Assuming user ID is stored in session

    // Validate email and password inputs
    if (!empty($newEmail) && !empty($enteredPassword)) {
        // Fetch the stored hashed password for the logged-in user
        $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        // Verify entered password
        if (password_verify($enteredPassword, $hashedPassword)) {
            // Update email in the database
            $updateStmt = $conn->prepare("UPDATE admin SET email = ? WHERE id = ?");
            $updateStmt->bind_param("si", $newEmail, $userId);
            if ($updateStmt->execute()) {
                $_SESSION['successful'] = "Email updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update email.";
            }
            $updateStmt->close();
        } else {
            $_SESSION['error'] = "Invalid password. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Please provide both email and password.";
    }

    // Redirect to self to display messages
    header("Location: admin_emailUpdate.php");
    exit();
}

// Retrieve and clear session messages
$error = $_SESSION['error'] ?? '';
$successful = $_SESSION['successful'] ?? '';
unset($_SESSION['error'], $_SESSION['successful']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Email</title>
    
    
    <link rel="stylesheet" href="backupButton.css">
    <link rel="stylesheet" href="style1.css">

    <style>
        #responseMessage {
            position: absolute;
            top: 20px;
            left: 20px;
            width: calc(100% - 40px);
            z-index: 100;
        }
        .error, .successful {
            position: relative;
            margin: 0;
            padding: 10px;
            border-radius: 5px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 10px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            gap: 10px;
        }
        .btn-confirm, .btn-cancel {
            padding: 10px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-confirm {
            background-color: #28a745;
            color: white;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }
    </style>

    <script>
        function confirmEmailChange() {
        const emailInput = document.getElementById('email').value;
        if (emailInput === "") {
            alert("Please enter an email address.");
            return;
        }
        // Show password entry modal
        document.getElementById('passwordModal').style.display = "flex";
    }

    function closeModal() {
        document.getElementById('passwordModal').style.display = "none";
    }

    function submitForm() {
        const passwordInput = document.getElementById('password').value;
        if (passwordInput === "") {
            alert("Please enter your password.");
            return;
        }
        // Add password input to form as a hidden field
        const form = document.getElementById('updateEmailForm');
        form.appendChild(createHiddenInput('password', passwordInput));
        form.submit();
    }

    function createHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
    }
    </script>
</head>
<body  style="background: #071c14;">

<div class="center_record">
    <div class="container">
        <h1 class="form-title" style="font-size:30px;">Update Email</h1>

        <!-- Form for email update -->
        <form id="updateEmailForm" action="" method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Enter new Email" required>
                <label for="email">Enter New Email</label>
            </div>

            <button type="button" class="btn btn-confirm" onclick="confirmEmailChange()">Confirm</button>
            <a href="admin_status.php" class="back-link">← Back</a>

            <!-- Display success or error messages -->
            <div id="responseMessage">
                <?php if ($error): ?>
                    <p class="error" style="color: red; background-color: #fdd; padding: 10px; margin-bottom: 10px;">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endif; ?>
                <?php if ($successful): ?>
                    <p class="successful" style="color: green; background-color: #dfd; padding: 10px; margin-bottom: 10px;">
                        <?= htmlspecialchars($successful) ?>
                    </p>
                <?php endif; ?>
            </div>
        </form>

        <!-- Password Modal -->
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2><i class="fas fa-lock"></i> Enter Password</h2>
                <input type="password" id="password" placeholder="Enter your password" required>
                <br>
                <div class="modal-buttons">
                    <button type="button" onclick="submitForm()" class="btn btn-confirm" >Confirm</button>
                    <button type="button" onclick="closeModal()" class="btn btn-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
