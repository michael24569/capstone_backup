<?php
$error = NULL;
$successful = NULL;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);
    $mysqli = require __DIR__ . "/db-connection.php";

    // Check both staff and admin tables for the token
    $sql = "SELECT 'staff' AS type, id, token_expiry FROM staff WHERE token_reset = ?
            UNION
            SELECT 'admin' AS type, id, token_expiry FROM admin WHERE token_reset = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $token_hash, $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user === null) {
        $error = "Token not found.";
    } elseif (strtotime($user["token_expiry"]) <= time()) {
        $error = "Token has expired.";
    } elseif (strlen($_POST["password"]) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif (!preg_match("/[a-z]/i", $_POST["password"])) {
        $error = "Password must contain at least one letter.";
    } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
        $error = "Password must contain at least one number.";
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $error = "Passwords must match.";
    } else {
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $table = $user['type'];
        $sql = "UPDATE $table SET password = ?, token_reset = NULL, token_expiry = NULL WHERE id = ?";
        $stmt->close();
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $password_hash, $user["id"]);

        if ($stmt->execute()) {
            $successful = "Password updated. You can now login.";
        } else {
            $error = "Failed to update the password.";
        }
    }
    $stmt->close();
    $mysqli->close();
}
?>
