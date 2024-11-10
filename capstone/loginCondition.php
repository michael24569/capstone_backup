<?php
$error = null;
include 'db-connection.php';

if (isset($_POST['signin'])) {
    session_start();

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = validate($_POST['email']);
        $password = validate($_POST['password']);

        if (empty($email) && empty($password)) {
            $error = "Email and Password are required";
        } else if (empty($email)) {
            $error = "Email is required";
        } else if (empty($password)) {
            $error = "Password is required";
        } else {
            $sql = "SELECT *, 'staff' AS role FROM staff WHERE email = ? 
                    UNION 
                    SELECT *, 'admin' AS role FROM admin WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $email, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                // Check if the account is active
                if ($row['accountStatus'] !== 'Active') {
                    $error = "Account is not active. Please contact the administrator.";
                }
                // Scenario 1: Password stored in plain text
                else if ($row['password'] === $password) {
                    loginUser($row, $row['role']);
                } 
                // Scenario 2: Password is hashed
                else if (password_verify($password, $row['password'])) {
                    loginUser($row, $row['role']);
                } else {
                    $error = "Incorrect Email or Password";
                }
            } else {
                $error = "Incorrect Email or Password";
            }
        }
    } else {
        header("Location: index.php");
        exit();
    }

    if ($error !== null) {
        $_SESSION['error'] = $error;  // Store error in the session
        header("Location: index.php");
        exit();
    }
}

function loginUser($row, $role) {
    echo "Successfully Logged in";
    $_SESSION['email'] = $row['email'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['role'] = $role;
   $_SESSION['fullname'] = $row['fullname'];

    if ($role === 'admin') {
        header('Location: admin_map.php'); // Redirect admin to admin dashboard
    } else if ($role === 'staff') {
        header('Location: home.php'); // Redirect staff to staff dashboard
    }
    exit();
}
?>
