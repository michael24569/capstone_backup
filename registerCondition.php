<?php
$error = null; 
$successful = null;  

include 'db-connection.php';  

// Predefined security questions
$securityQuestions = [
 'In what city were you born?',
    'What was the name of your first school?',
    'What was the first exam you failed?',
    'What was the name of your first pet?',
    'What is your favorite book?',
    'What was your favorite subject in school?',
    'Who was your childhood hero?'
];

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
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // New security question and answer fields
    $security_question = trim($_POST['security_question'] ?? '');
    $security_answer = trim($_POST['security_answer'] ?? '');

    // Determine the account status based on the number of active accounts
    $status = determineAccountStatus($conn);

    // Check if username already exists in the database using prepared statements
    $stmt = $conn->prepare("SELECT * FROM staff WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If username exists, store an error message in a variable
        $error = "The username you entered already exists in the database.";
    } else {
        // Additional validation for security question and answer
        if (empty($security_question)) {
            $error = "Please select a security question.";
        } elseif (empty($security_answer)) {
            $error = "Please provide a security answer.";
        } elseif (strlen($security_answer) < 3) {
            $error = "Security answer must be at least 3 characters long.";
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
                
                // Hash the security answer 
                $hashedSecurityAnswer = password_hash(strtolower($security_answer), PASSWORD_DEFAULT);
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
                // Insert the new user data into the database using prepared statements
                $stmt = $conn->prepare("INSERT INTO staff (username, fullName, accountStatus, password, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", 
                    $username, 
                    $fullname, 
                    $status, 
                    $hashedPassword,
                    $security_question,
                    $hashedSecurityAnswer
                );

                if ($stmt->execute()) {
                    // Store a success message instead of redirecting
                    $successful = "Successfully registered!";

                    // Clear form fields
                    $_POST['fullname'] = '';
                    $_POST['username'] = '';
                    $_POST['security_question'] = '';
                    $_POST['security_answer'] = '';
                } else {
                    // Store an error message if the query fails
                    $error = "Error during registration. Please try again.";
                }
            }
        }
    }

    $stmt->close(); // Close the prepared statement
}
?>