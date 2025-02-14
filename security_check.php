<?php
function checkAdminAccess() {
    if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
        header("Location: index.php");
        exit();
    }
    if ($_SESSION['role'] !== 'System Administrator') {
        header("Location: index.php");
        exit();
    }
    
}

function checkStaffAccess() {
    if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
        header("Location: index.php");
        exit();
    }
    if ($_SESSION['role'] !== 'Staff') {
        header("Location: index.php");
        exit();
    }
}
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
function userCheckLogin() {
    if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'System Administrator') {
        header("Location: admin_map.php");
        exit();
    } elseif ($_SESSION['role'] == 'Staff') {
        header("Location: home.php");
        exit();
    }
}
}

?>

