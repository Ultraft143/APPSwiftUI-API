<?php

require_once '../includes/config.php';
require_once '../includes/connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Using array() constructor
$data1 = array(1, 2, 3);

// Using short syntax []
$data2 = [4, 5, 6];

// Print or use the arrays
print_r($data1);
print_r($data2);

// Flush output buffer
ob_flush();

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql = "SELECT * FROM `track`";
$query = mysqli_query($conn, $sql);
$arraydata = [];
echo("asuh");
while($row = mysqli_fetch_assoc($query)){
    $arraydata[] = $row;
}
?>  