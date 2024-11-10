<?php 
$servername = "localhost";
$uname = "root";
$pword = "";
$database = "simenteryo";

$conn = mysqli_connect($servername, $uname, $pword, $database);

if(!$conn) {
    echo "Connection failed";
}
return $conn;
?>