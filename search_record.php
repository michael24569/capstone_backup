<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simenteryo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_GET['name'];
$sql = "SELECT Lot_No, mem_sts FROM records WHERE LO_name LIKE ?";
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
