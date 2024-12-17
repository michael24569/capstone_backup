<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simenteryo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lotNo = $_GET['lotno'] ?? '';
$memSts = $_GET['memsts'] ?? '';
$sql = "SELECT * FROM records WHERE Lot_No = ? AND mem_sts = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $lotNo, $memSts);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
    echo json_encode($record);
} else {
    echo json_encode(["message" => "No record found"]);
}

$stmt->close();
$conn->close();
?>
