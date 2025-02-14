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

    // Initialize login attempts if not set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // Updated lockout check: check session or persistent cookie
    if ((isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) ||
        (isset($_COOKIE['persistent_lockout_time']) && time() < $_COOKIE['persistent_lockout_time'])) {
        $lockout_expiry = isset($_SESSION['lockout_time']) ? $_SESSION['lockout_time'] : $_COOKIE['persistent_lockout_time'];
        $remaining_time = $lockout_expiry - time();
        $_SESSION['error'] = "Too many failed login attempts. Please try again in $remaining_time seconds.";
        header("Location: index.php");
        exit();
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
        $sql = "SELECT *, 'Staff' AS role FROM tbl_staff WHERE username = ? 
                UNION 
                SELECT *, 'System Administrator' AS role FROM tbl_admin WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        // Developers: Backend Developer: Michael Enoza , Frontend Developer Kyle Ambat
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['accountStatus'] !== 'Active') {
                $error = "Account is not active. Please contact the administrator.";
            } else if (password_verify($password, $row['password'])) {
                // Reset login attempts and clear persistent lockout cookie on successful login
                $_SESSION['login_attempts'] = 0;
                unset($_SESSION['lockout_duration']);
                if (isset($_COOKIE['persistent_lockout_time'])) {
                    setcookie('persistent_lockout_time', '', time()-3600, "/");
                }
                loginUser($row, $row['role']);
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
        }
    }

    if ($error !== null) {
        $_SESSION['login_attempts'] += 1;

        // Lockout logic
        if ($_SESSION['login_attempts'] >= 3) {
            $lockout_duration = 180; // 3 minutes
            if (isset($_SESSION['lockout_duration'])) {
                $_SESSION['lockout_duration'] += 120; // Add 2 minutes
            } else {
                $_SESSION['lockout_duration'] = $lockout_duration;
            }
            $_SESSION['lockout_time'] = time() + $_SESSION['lockout_duration'];
            // Set persistent cookie valid for the lockout duration
            setcookie('persistent_lockout_time', $_SESSION['lockout_time'], time() + $_SESSION['lockout_duration'], "/");
            $_SESSION['login_attempts'] = 0; // Reset attempts after lockout
            $_SESSION['error'] = "Too many failed login attempts. Please try again in " . $_SESSION['lockout_duration'] . " seconds.";
        } else {
            $_SESSION['error'] = $error;
        }

        header("Location: index.php");
        exit();
    } else {
        // Reset login attempts on successful login
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['lockout_duration']);
    }
}

function loginUser($row, $role) {
    $_SESSION['username'] = $row['username'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['role'] = $role;
    $_SESSION['fullname'] = $row['fullname'];

    if ($role === 'System Administrator') {
        header('Location: admin_map.php');
    } else if ($role === 'Staff') {
        header('Location: home.php');
    }
    exit();
}
?>
