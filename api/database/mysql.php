<?php 
session_start();

$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$db = getenv('MYSQL_DATABASE');

$conn = mysqli_connect($host, $user, $pass, $db);

echo "Connected to MySQL<br>";

$_SESSION['mysql_conn'] = $conn;
?>