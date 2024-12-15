
<?php

$error = null;
$databaseError = null;

try {
    include 'db-connection.php';
    if (!$conn) {
        throw new Exception("Database connection failed");
        
    }
} catch (Exception $e) {
    $_SESSION['database_error'] = true;
    header("Location: setup-database.php");
    exit();
}
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

            if ($row['accountStatus'] !== 'Active') {
                $error = "Account is not active. Please contact the administrator.";
            } else if (password_verify($password, $row['password'])) {
                loginUser($row, $row['role']);
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
        }
    }

    if ($error !== null) {
        $_SESSION['error'] = $error;
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
    } else if ($role === 'Staff') {
        header('Location: home.php');
    }
    exit();
}
?>
