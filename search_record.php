<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_simenteryo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
$name = $_GET['name'];
$sql = "SELECT Lot_No, mem_sts FROM tbl_records WHERE LO_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $conn->real_escape_string($name) . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$records = [];

while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode($records);

$stmt->close();
$conn->close();
?>
