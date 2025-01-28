<?php
session_start();
include 'db-connection.php';

require_once 'security_check.php';
checkStaffAccess();


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

function validateMemorialLots($mem_sts, $mem_lots) {
    // Check for Apartments and Columbarium
    $specialLots = ['Apartment1', 'Apartment2', 'Apartment3', 'Columbarium1', 'Columbarium2'];
    if (in_array($mem_sts, $specialLots) && $mem_lots !== 'None') {
        return ['valid' => false, 'message' => "This memorial name only accept None memorial type"];
    }

    // Check for specific saints that only accept Family Estate
    $familyEstateSaints = ['St. Michael', 'St. Patrick', 'St. Mark', 'St. Lukes'];
    if (in_array($mem_sts, $familyEstateSaints) && $mem_lots !== 'Family Estate') {
        return ['valid' => false, 'message' => "This memorial name only accept Family Estate memorial type"];
    }

    // Check for saints that only accept Garden Lots
    $gardenLotsSaints = ['St. Matthew', 'St. Isidore'];
    if (in_array($mem_sts, $gardenLotsSaints) && $mem_lots !== 'Garden Lots') {
        return ['valid' => false, 'message' => "This memorial name only accept Garden Lots memorial type"];
    }

    // Check for saints that only accept Lawn Lots
    $lawnLotsSaints = ['St. Jude', 'St. John', 'St. Joseph', 'St. James', 'St. Dominic', 
                       'St. Augustin', 'St. Paul', 'St. Peter', 'St. Rafael'];
    if (in_array($mem_sts, $lawnLotsSaints) && $mem_lots !== 'Lawn Lots') {
        return ['valid' => false, 'message' => "This memorial name only accept Lawn Lots memorial type"];
    }

    return ['valid' => true, 'message' => ''];
}

function validateLotNumber($mem_sts, $lot) {
    // Define lot limits for each saint/location
    $lotLimits = [
        'St. Mark' => 7,
        'St. Lukes' => 12,
        'St. Matthew' => 6,
        'St. Jude' => 186,
        'St. John' => 135,
        'St. Joseph' => 173,
        'St. James' => 273,
        'St. Michael' => 6,
        'St. Patrick' => 6,
        'St. Dominic' => 303,
        'St. Isidore' => 19,
        'St. Augustin' => 151,
        'St. Rafael' => 58,
        'St. Peter' => 71,
        'St. Paul' => 71
    ];

    // Check for specific saint limits
    if (isset($lotLimits[$mem_sts])) {
        if ($lot < 1 || $lot > $lotLimits[$mem_sts]) {
            return ['valid' => false, 'message' => "$mem_sts lots must be between 1 and {$lotLimits[$mem_sts]}"];
        }
    }

    // Validate Apartments
    if (strpos($mem_sts, 'Apartment') !== false) {
        if ($lot < 1 || $lot > 100) {
            return ['valid' => false, 'message' => "Apartment lots must be between 1 and 100"];
        }
    }
    
    // Validate Columbarium
    if (strpos($mem_sts, 'Columbarium') !== false) {
        if ($lot < 1 || $lot > 640) {
            return ['valid' => false, 'message' => "Columbarium lots must be between 1 and 640"];
        }
    }
    
    return ['valid' => true, 'message' => ''];
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("Location: home.php");
        exit;
    }

    $id = $_GET["id"];
    $sql = "SELECT * FROM tbl_records WHERE id = ?";
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
    // Sanitize the input
$id = $_POST["id"];
$lot = ltrim($_POST["Lot_No"], '0'); // Remove leading zeros
$mem_lots = $_POST["mem_lots"];
$mem_sts = $_POST["mem_sts"];
$name = $_POST["LO_name"];
$address = $_POST["mem_address"];

do {
    if (empty($lot) || empty($mem_lots) || empty($mem_sts) || empty($name)) {
        $errorMessage = "All fields are required";
        break;
    }

    // First validate lot number
    $lotValidation = validateLotNumber($mem_sts, $lot);
    if (!$lotValidation['valid']) {
        $errorMessage = $lotValidation['message'];
        break;
    }

    // Validate memorial lots
    $validation = validateMemorialLots($mem_sts, $mem_lots);
    if (!$validation['valid']) {
        $errorMessage = $validation['message'];
        break;
    }

    // Check for duplicates
    $checkSql = "SELECT * FROM tbl_records WHERE Lot_No = ? AND mem_sts = ? AND id != ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("sss", $lot, $mem_sts, $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $errorMessage = "The lot has already been sold.";
        break;
    }

    // Update the record
    $sql = "UPDATE tbl_records SET Lot_No = ?, mem_lots = ?, mem_sts = ?, LO_name = ?, mem_address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $lot, $mem_lots, $mem_sts, $name, $address, $id);
    $result = $stmt->execute();

    if (!$result) {
        $errorMessage = "Invalid query: " . $conn->error;
        break;
    }

    // Log the update action
    $fullname = $_SESSION['fullname'];
    $userRole = $_SESSION['role'];
    $action = "updated";
    $logSql = "INSERT INTO tbl_record_logs (role, fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("sssss", $userRole, $fullname, $lot, $mem_sts, $action);
    $logStmt->execute();

    $successMessage = "Record updated successfully";
} while (false);
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
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
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            height: 100vh;
            background-color: #071c14;
            justify-content: center;
            align-items: center;
            display: flex;

        }
        .container {
            background: #f4f4f4;
            width: 700px;
            padding:1rem;
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
        
        /* Add button hover animation */
        .btn {
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn:active {
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2 style="font-weight: bold;">Edit Clients Information</h2>
        <br>
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
                    <option value="None" <?php if ($mem_lots == "None") echo "selected"; ?>>None</option>
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
                <label class="col-sm-3 col-form-label">Property Owner</label>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
                <div class="col-sm-3 d-grid">
                    <button type="button" class="btn btn-danger" onclick="window.location.href='records.php'">Cancel</button>
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
                    alert.style.display = 'none';
                }
            }, 1000);
        });


        function validateNumber(input) {
    // Remove leading zeros and convert to number
    let value = input.value.replace(/^0+/, '');
    
    // If the input was all zeros, keep a single zero
    if (value === '') {
        value = '0';
    }
    
    // Convert to integer
    let numValue = parseInt(value, 10);
    
    // Validate the number
    if (isNaN(numValue) || numValue < 0) {
        input.value = '0';
    } else {
        // Update the input value with the cleaned number
        input.value = numValue.toString();
    }
}

// Add an input event listener to handle the validation as the user types
document.addEventListener('DOMContentLoaded', function() {
    const lotNoInput = document.querySelector('input[name="Lot_No"]');
    if (lotNoInput) {
        lotNoInput.addEventListener('input', function(e) {
            validateNumber(this);
        });
    }
});

// Prevent form resubmission when going back
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
    </script>
</body>
</html>
