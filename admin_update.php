<?php
session_start();
include 'db-connection.php';

require_once 'security_check.php';
checkAdminAccess();


$id = "";
$lot = "";
$mem_lots = "";
$mem_sts = "";
$name = "";
$address = "";
$errorMessage = "";
$successMessage = "";

// Function to display messages
function displayMessage($message, $type) {
    if (!empty($message)) {
        $alertType = ($type === 'error') ? 'warning' : 'success';
        echo "
            <div class='floating-alert alert alert-{$alertType} alert-dismissible fade show' role='alert'>
                <strong>{$message}</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("Location: home.php");
        exit;
    }

    $id = $_GET["id"];
    $sql = "SELECT * FROM records WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: home.php");
        exit;
    }

    $lot = $row["Lot_No"];
    $mem_lots = $row["mem_lots"];
    $mem_sts = $row["mem_sts"];
    $name = $row["LO_name"];
    $address = $row["mem_address"];
} else {
    $id = $_POST["id"];
    $lot = $_POST["Lot_No"];
    $mem_lots = $_POST["mem_lots"];
    $mem_sts = $_POST["mem_sts"];
    $name = $_POST["LO_name"];
    $address = $_POST["mem_address"];

    do {
        if (empty($lot) || empty($mem_lots) || empty($mem_sts) || empty($name)) {
            $errorMessage = "All fields are required";
            break;
        }

        // Check for duplicates
        $checkSql = "SELECT * FROM records WHERE Lot_No = ? AND mem_sts = ? AND id != ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("sss", $lot, $mem_sts, $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $errorMessage = "The lot has already been sold.";
            break;
        }

        // Update the record
        $sql = "UPDATE records SET Lot_No = ?, mem_lots = ?, mem_sts = ?, LO_name = ?, mem_address = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $lot, $mem_lots, $mem_sts, $name, $address, $id);
        $result = $stmt->execute();

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $fullname = $_SESSION['fullname'];
        $userRole = $_SESSION['role'];
        $action = "updated";
        $logSql = "INSERT INTO record_logs (role,fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("sssss", $userRole, $fullname, $lot, $mem_sts, $action);
        $logStmt->execute();

        $successMessage = "Record updated successfully";
    } while (false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Records</title>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" ></script>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" >
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        @font-face {
  font-family: 'MyFont';
  src: url('fonts/Inter.ttf') format('ttf'),
}

        body {
           font-family: 'MyFont';
            height: 100vh;
            background-color: #005434;
            justify-content: center;
            align-items: center;
            display: flex;
        }
        .container {
            background: #f4f4f4;
            width: 850px;
            padding: 1.5rem;
            margin: 10px auto;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 1, 0.9);
        }
        .form-control {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .floating-alert {
            position: fixed;
            top: 40%;
            right: 40%;
            z-index: 1050;
            width: auto;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Clients Information</h2>
        <?php
        displayMessage($errorMessage, 'error');
        displayMessage($successMessage, 'success');
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lot No.</label>
                <div class="col-sm-6">
                <input 
                        type="number" 
                        class="form-control" 
                        name="Lot_No" 
                        value="<?php echo htmlspecialchars($lot) ?>" 
                        oninput="validateNumber(this)">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Memorial Lots</label>
                <div class="col-sm-6">
                    <select class="form-control" name="mem_lots">
                        <option value="Family Estate" <?php if ($mem_lots == "Family Estate") echo "selected"; ?>>Family Estate</option>
                        <option value="Garden Lots" <?php if ($mem_lots == "Garden Lots") echo "selected"; ?>>Garden Lots</option>
                        <option value="Lawn Lots" <?php if ($mem_lots == "Lawn Lots") echo "selected"; ?>>Lawn Lots</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Memorial Name</label>
        <div class="col-sm-6">
            <select class="form-control" name="mem_sts">
            <option value="St. Michael" <?php if ($mem_sts == "St. Michael") echo "selected"; ?>>St. Michael</option>
            <option value="St. Patrick" <?php if ($mem_sts == "St. Patrick") echo "selected"; ?>>St. Patrick</option>
            <option value="St. Mark" <?php if ($mem_sts == "St. Mark") echo "selected"; ?>>St. Mark</option>
            <option value="St. Lukes" <?php if ($mem_sts == "St. Lukes") echo "selected"; ?>>St. Lukes</option>
            <option value="St. Matthew" <?php if ($mem_sts == "St. Matthew") echo "selected"; ?>>St. Matthew</option>
            <option value="St. Isidore" <?php if ($mem_sts == "St. Isidore") echo "selected"; ?>>St. Isidore</option>
            <option value="St. Rafael" <?php if ($mem_sts == "St. Rafael") echo "selected"; ?>>St. Rafael</option>
            <option value="St. Peter" <?php if ($mem_sts == "St. Peter") echo "selected"; ?>>St. Peter</option>
            <option value="St. Paul" <?php if ($mem_sts == "St. Paul") echo "selected"; ?>>St. Paul</option>
            <option value="St. Augustin" <?php if ($mem_sts == "St. Augustin") echo "selected"; ?>>St. Augustin</option>
            <option value="St. Joseph" <?php if ($mem_sts == "St. Joseph") echo "selected"; ?>>St. Joseph</option>
            <option value="St. John" <?php if ($mem_sts == "St. John") echo "selected"; ?>>St. John</option>
            <option value="St. Dominic" <?php if ($mem_sts == "St. Dominic") echo "selected"; ?>>St. Dominic</option>
            <option value="St. James" <?php if ($mem_sts == "St. James") echo "selected"; ?>>St. James</option>
            <option value="St. Rafael" <?php if ($mem_sts == "St. Rafael") echo "selected"; ?>>St. Rafael</option>
            <option value="St. Jude" <?php if ($mem_sts == "St. Jude") echo "selected"; ?>>St. Jude</option>
            <option value="Apartment1" <?php if ($mem_sts == "Apartment1") echo "selected"; ?>>Apartment1</option>
            <option value="Apartment2" <?php if ($mem_sts == "Apartment2") echo "selected"; ?>>Apartment2</option>
            <option value="Apartment3" <?php if ($mem_sts == "Apartment3") echo "selected"; ?>>Apartment3</option>
            <option value="Columbarium1" <?php if ($mem_sts == "Columbarium1") echo "selected"; ?>>Columbarium1</option>
            <option value="Columbarium2" <?php if ($mem_sts == "Columbarium2") echo "selected"; ?>>Columbarium2</option>
                <!-- Add more options as needed -->
            </select>
        </div>
    </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lot Owner</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="LO_name" value="<?php echo htmlspecialchars($name) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="mem_address" value="<?php echo htmlspecialchars($address) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-outline-primary">Update Record</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="admin_records.php" role="button">Back</a>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Auto-hide the alert after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alert = document.querySelector('.floating-alert');
                if (alert) {
                    alert.classList.remove('show');
                }
            }, 1000);
        });


        //validate the number for the lotno
        function validateNumber(input) {
    let value = parseInt(input.value, 10);

    if (isNaN(value) || value < 0) {
        input.value = 0;
    }
}
    </script>
</body>
</html>
