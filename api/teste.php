<?php

require_once '../includes/config.php';
require_once '../includes/connect.php';

$name='teste';
$password='teste';

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql = "SELECT * FROM `users` WHERE `user_name`='$name' AND `user_password`='$password'";
echo($sql);
$query = mysqli_query($conn, $sql);
$row_num = mysqli_num_rows($query);
echo($row_num);

?>