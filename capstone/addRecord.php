<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "simenteryo";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$lot = "";
$mem_lots = "";
$mem_sts = "";
$name = "";
$address = "";

$errorMessage = "";
$successMessage = "";

function recordExists($connection, $lot, $mem_sts) {
    // Check for duplicate Lot_No within a specific mem_sts
    $sqlLotCheck = "SELECT * FROM records WHERE Lot_No = ? AND mem_sts = ?";
    $stmtLotCheck = $connection->prepare($sqlLotCheck);
    $stmtLotCheck->bind_param("ss", $lot, $mem_sts);
    $stmtLotCheck->execute();
    $resultLotCheck = $stmtLotCheck->get_result();

    if ($resultLotCheck->num_rows > 0) {
        return "Error: Duplicate Lot No. found within the same Memorial Name.";
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
        $duplicateCheck = recordExists($connection, $lot, $mem_sts);
        if ($duplicateCheck) {
            $errorMessage = $duplicateCheck;
        } else {
            $sql = "INSERT INTO records (Lot_No, mem_lots, mem_sts, LO_name, mem_address) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssss", $lot, $mem_lots, $mem_sts, $name, $address);

            if (!$stmt->execute()) {
                $errorMessage = "Invalid query: " . $connection->error;
            } else {
                $fullname = $_SESSION['fullname'];  // Get the logged-in user's full name
                $action = "created";
                $logSql = "INSERT INTO record_logs (fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, NOW())";
                $logStmt = $connection->prepare($logSql);
                $logStmt->bind_param("ssss", $fullname, $lot, $mem_sts, $action);
                $logStmt->execute();
                
                $lot = "";
                $mem_lots = "";
                $mem_sts = "";
                $name = "";
                $address = "";

                $successMessage = "Client added successfully";
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
    <title>Edit Records</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Michroma&display=swap">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Michroma", sans-serif;
            height: 100vh;
            background-color: #005434;
            justify-content: center;
            align-items: center;
            display: flex;
        }
        .container {
            background: #f4f4f4;
            width: 450px;
            padding: 1.5rem;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 1, 0.9);
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h2 style="font-weight: bold; text-align: center;">Add New Record</h2>
        
        <?php
        if (!empty($errorMessage)) {
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
        if (!empty($successMessage)) {
            echo "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
        ?>
        
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lot No.</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lot" value="<?php echo htmlspecialchars($lot) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Memorial Lots</label>
                <div class="col-sm-6">
                    <select class="form-control" name="mem_lots">
                        <option value="Family Estate">Family Estate</option>
                        <option value="Garden Lots">Garden Lots</option>
                        <option value="Lawn Lots">Lawn Lots</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Memorial Name</label>
                <div class="col-sm-6">
                    <select class="form-control" name="mem_sts">
                        <option value="St. Michael">St. Michael</option>
                        <option value="St. Patrick">St. Patrick</option>
                        <option value="St. Mark">St. Mark</option>
                        <option value="St. Lukes">St. Lukes</option>
                        <option value="St. Matthew">St. Matthew</option>
                        <option value="St. Isidore">St. Isidore</option>
                        <option value="St. Rafael">St. Rafael</option>
                        <option value="St. Peter">St. Peter</option>
                        <option value="St. Paul">St. Paul</option>
                        <option value="St. Augustine">St. Augustine</option>
                        <option value="St. Joseph">St. Joseph</option>
                        <option value="St. John">St. John</option>
                        <option value="St. Dominic">St. Dominic</option>
                        <option value="St. James">St. James</option>
                        <option value="St. Jude">St. Jude</option>
                        <option value="Apartment1">Apartment1</option>
                        <option value="Apartment2">Apartment2</option>
                        <option value="Apartment3">Apartment3</option>
                        <option value="Columbarium1">Columbarium1</option>
                        <option value="Columbarium2">Columbarium2</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Lot Owner</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="records.php" role="button" onclick="showRecords()">Back</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
