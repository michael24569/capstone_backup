<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_simenteryo";

// Establish a connection to the database
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';
$searchTerm = '%' . $searchTerm . '%'; // Add wildcards for LIKE query
// Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat
$query = $connection->prepare("SELECT LO_name FROM tbl_records WHERE LO_name LIKE ?");
$query->bind_param('s', $searchTerm);
$query->execute();
$result = $query->get_result();

$names = [];
while ($row = $result->fetch_assoc()) {
    $names[] = $row['LO_name'];
}

$query->close();
$connection->close();

echo json_encode($names);
?>
