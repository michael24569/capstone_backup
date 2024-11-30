<?php
$error = null;
$successful = null;

include 'db-connection.php';

function determineAccountStatus($conn) {
    // Check the number of active accounts
    $result = mysqli_query($conn, "SELECT COUNT(*) as active_count FROM staff WHERE accountStatus = 'Active'");
    $row = mysqli_fetch_assoc($result);

    if ($row['active_count'] >= 3) {
        return 'Inactive'; // Set to 'Inactive' if there are already 3 active accounts
    } else {
        return 'Active'; // Otherwise, set to 'Active'
    }
}

if (isset($_POST['signup'])) {
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Determine the account status based on the number of active accounts
    $status = determineAccountStatus($conn);

    // Check if email already exists in the database using prepared statements
    $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If email exists, store an error message in a variable
        $error = "The email you entered is already existing in the database.";
    } else {
        // Validate password
        if (strlen($password) < 8) {
            $error = "Password must be at least 8 characters.";
        } elseif (!preg_match("/[a-z]/", $password)) {
            $error = "Password must contain at least one lowercase letter.";
        } elseif (!preg_match("/[A-Z]/", $password)) {
            $error = "Password must contain at least one uppercase letter.";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $error = "Password must contain at least one number.";
        } elseif (!preg_match("/[\W_]/", $password)) { // Special characters
            $error = "Password must contain at least one special character (e.g., !@#$%^&*).";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user data into the database using prepared statements
            $stmt = $conn->prepare("INSERT INTO staff (username, fullName, email, accountStatus, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $fullname, $email, $status, $hashedPassword);

            if ($stmt->execute()) {
                // Store a success message instead of redirecting
                $successful = "Successfully registered!";
                
                $_POST['fullname'] = '';
                $_POST['username'] = '';
                $_POST['email'] = '';
            } else {
                // Store an error message if the query fails
                $error = "Error during registration. Please try again.";
            }
        }
    }

    $stmt->close(); // Close the prepared statement
}
?>
