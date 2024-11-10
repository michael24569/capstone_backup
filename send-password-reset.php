<?php
$error = null;
$successful = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["email"])) {
        $error = "Please enter your email address.";
    } else {
        $email = $_POST["email"];
        $mysqli = require __DIR__ . "/db-connection.php";

        // Check if email exists in either staff or admin table
        $sql = "SELECT 'staff' AS type, id, email FROM staff WHERE email = ?
                UNION
                SELECT 'admin' AS type, id, email FROM admin WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($result->num_rows === 0) {
            $error = "Invalid email address.";
        } else {
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

            $table = $user['type'];
            $sql = "UPDATE $table SET token_reset = ?, token_expiry = ? WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sss", $token_hash, $expiry, $email);
            $stmt->execute();

            if ($stmt->affected_rows) {
                $mail = require __DIR__ . "/mailer.php";
                $mail->setFrom("enozamichael12@gmail.com");
                $mail->addAddress($email);
                $mail->Subject = "Password Reset";
                $mail->Body = <<<END
Click <a href="http://localhost/capstone/create-newpass.php?token=$token">Here</a> to reset your password.
END;
                try {
                    $mail->send();
                    $successful = "Message sent, please check your inbox.";
                } catch (Exception $e) {
                    $error = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                }
            } else {
                $error = "Failed to update reset token.";
            }
        }
        $stmt->close();
        $mysqli->close();
    }
}
?>
