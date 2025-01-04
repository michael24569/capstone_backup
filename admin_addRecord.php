<?php
session_start();

require_once 'security_check.php';
checkAdminAccess();

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_simenteryo";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

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
function normalizeLotNumber($lot) {
    return intval($lot); 
}
$lot = "";
$mem_lots = "";
$mem_sts = "";
$name = "";
$address = "";

$errorMessage = "";
$successMessage = "";

function recordExists($connection, $lot, $mem_sts) {

    $normalizedLot = normalizeLotNumber($lot);

    $sqlLotCheck = "SELECT * FROM tbl_records WHERE Lot_No = ? AND mem_sts = ?";
    $stmtLotCheck = $connection->prepare($sqlLotCheck);
    $stmtLotCheck->bind_param("ss", $lot, $mem_sts);
    $stmtLotCheck->execute();
    $resultLotCheck = $stmtLotCheck->get_result();

    if ($resultLotCheck->num_rows > 0) {
        return "The lot has already been sold.";
    }

    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST["lot"];
    $mem_lots = $_POST["mem_lots"];
    $mem_sts = $_POST["mem_sts"];
    $name = $_POST["name"];
    $address = $_POST["address"];

    if (empty($lot) || empty($mem_lots) || empty($mem_sts) || empty($name)) {
        $errorMessage = "All fields are required";
    } else {
        $normalizedLot = normalizeLotNumber($lot);
        $duplicateCheck = recordExists($connection, $lot, $mem_sts);
        if ($duplicateCheck) {
            $errorMessage = $duplicateCheck;
        } else {
            $sql = "INSERT INTO tbl_records (Lot_No, mem_lots, mem_sts, LO_name, mem_address) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssss", $normalizedLot, $mem_lots, $mem_sts, $name, $address);

            if (!$stmt->execute()) {
                $errorMessage = "Invalid query: " . $connection->error;
            } else {
                $fullname = $_SESSION['fullname']; 
                $userRole = $_SESSION['role']; // Get the logged-in user's full name
                $action = "created";
                $logSql = "INSERT INTO tbl_record_logs (role,fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, ?, NOW())";
                $logStmt = $connection->prepare($logSql);
                $logStmt->bind_param("sssss",$userRole, $fullname, $normalizedLot, $mem_sts, $action);
                $logStmt->execute();
                
                $lot = "";
                $mem_lots = "";
                $mem_sts = "";
                $name = "";
                $address = "";

                $successMessage = "Record added successfully";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client Records</title>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" >
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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
            padding: 1.5rem;
            width: 850px;
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
        <h2 style="font-weight: bold;">Add New Record</h2>
        
        <?php
        displayMessage($errorMessage, 'error');
        displayMessage($successMessage, 'success');
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lot No.</label>
                <div class="col-sm-6">
                    <input 
                        type="number" 
                        class="form-control" 
                        name="lot" 
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
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lot Owner</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name) ?>" autocomplete='off'>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address) ?>" autocomplete='off'>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
                <div class="col-sm-3 d-grid">
                    <button type="button" class="btn btn-danger" onclick="goBack()">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alert = document.querySelector('.floating-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.style.display = 'none';
                }
            }, 2000); //S
        });

        function validateNumber(input) {
            let value = input.value.replace(/^0+/, '');
            
            // If the value is empty after removing zeros,
            if (value === '') {
                input.value = '0';
            } else {
                input.value = value;
            }
        }

        function goBack() {
            window.location.href = "admin_records.php";
        }
    </script>
</body>
</html>
