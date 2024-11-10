<?php
session_start();
include 'db-connection.php';

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
            <div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
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
        if (empty($lot) || empty($mem_lots) || empty($mem_sts) || empty($name) || empty($address)) {
            $errorMessage = "All fields are required";
            break;
        }

        // Check if a record with the same Lot_No and mem_sts exists (excluding the current ID)
        $checkSql = "SELECT * FROM records WHERE Lot_No = ? AND mem_sts = ? AND id != ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("sss", $lot, $mem_sts, $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $errorMessage = "Record with same Lot No. and Memorial Name exists.";
            break;
        }

        // Proceed with the update if no duplicate is found
        $sql = "UPDATE records SET Lot_No = ?, mem_lots = ?, mem_sts = ?, LO_name = ?, mem_address = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $lot, $mem_lots, $mem_sts, $name, $address, $id);
        $result = $stmt->execute();

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $fullname = $_SESSION['fullname'];  // Get the logged-in user's full name
        $action = "updated";
        $logSql = "INSERT INTO record_logs (fullname, Lot_No, mem_sts, action, timestamp) VALUES (?, ?, ?, ?, NOW())";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ssss", $fullname, $lot, $mem_sts, $action);
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
    width: 900px;
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
                    <input type="text" class="form-control" name="Lot_No" value="<?php echo htmlspecialchars($lot) ?>">
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
                <option value="St. Michael">St. Michael</option>
                <option value="St. Patrick">St. Patrick</option>
                <option value="St. Mark">St. Mark</option>
                <option value="St. Lukes">St. Lukes</option>
                <option value="St. Matthew">St. Matthew</option>
                <option value="St. Isidore">St. Isidore</option>
                <option value="St. Rafael">St. Rafael</option>
                <option value="St. Peter">St. Peter</option>
                <option value="St. Paul">St. Paul</option>
                <option value="St. Augustine">St. Augustin</option>
                <option value="St. Joseph">St. Joseph</option>
                <option value="St. John">St. John</option>
                <option value="St. Dominic">St. Dominic</option>
                <option value="St. James">St. James</option>
                <option value="St. Rafael">St. Rafael</option>
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
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="records.php" role="button">Back</a>
                </div>
            </div>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
