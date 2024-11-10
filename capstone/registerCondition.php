<?php
$error = null;
$successful = null;

include 'db-connection.php';



function determineAccountStatus($fullname, $email, $password) {
    // Check if fullname, email, and password are not empty
    if (!empty($fullname) && !empty($email) && !empty($password)) {
        return 'Active'; // Assign 'active' status if all fields are provided
    } 
}

if (isset($_POST['signup'])) {
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Determine the account status based on whether the fields are empty
    $status = determineAccountStatus($fullname, $email, $password);

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
        } elseif (!preg_match("/[a-zA-Z]/", $password)) {
            $error = "Password must contain at least one letter.";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $error = "Password must contain at least one number.";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user data into the database using prepared statements
            $stmt = $conn->prepare("INSERT INTO staff (fullName, email, accountStatus, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $email, $status, $hashedPassword);

            if ($stmt->execute()) {
                // Store a success message instead of redirecting
                $successful = "Successfully registered!";
            } else {
                // Store an error message if the query fails
                $error = "Error during registration. Please try again.";
            }
        }
    }

    $stmt->close(); // Close the prepared statement
}
?>
