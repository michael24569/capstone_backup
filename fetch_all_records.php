<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simenteryo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM records";
$result = $conn->query($sql);

$records = [];

while($row = $result->fetch_assoc()) {
    $records[] = $row;
}

header('Content-Type: application/json');
echo json_encode($records);

$conn->close();
?>
