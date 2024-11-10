<?php
$error = null;
include 'db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username'] ?? '');
    $password = validate($_POST['password'] ?? '');

    if (empty($username) && empty($password)) {
        $error = "Username and Password are required";
    } else if (empty($username)) {
        $error = "Username is required";
    } else if (empty($password)) {
        $error = "Password is required";
    } else {
        $sql = "SELECT *, 'Staff' AS role FROM staff WHERE username = ? 
                UNION 
                SELECT *, 'Admin' AS role FROM admin WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // Check if the account is active
            if ($row['accountStatus'] !== 'Active') {
                $error = "Account is not active. Please contact the administrator.";
            }
            // Check plain text password or hashed password
            else if (password_verify($password, $row['password'])) {
                loginUser($row, $row['role']);
            } else {
                $error = "Incorrect Username or Password";
            }
        } else {
            $error = "Incorrect Username or Password";
        }
    }

    if ($error !== null) {
        $_SESSION['error'] = $error;  // Store error in the session
        header("Location: index.php");
        exit();
    }
}

function loginUser($row, $role) {
    $_SESSION['username'] = $row['username'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['role'] = $role;
    $_SESSION['fullname'] = $row['fullname'];

    if ($role === 'Admin') {
        header('Location: admin_map.php');
         // Redirect admin to admin dashboard
    } else if ($role === 'Staff') {
        header('Location: home.php'); // Redirect staff to staff dashboard
    }
    exit();
}
?>
