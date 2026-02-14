<?php
$host = "127.0.0.1";   
$user = "root";
$pass = "";
$db   = "ticket_system";
$port = 3307;          

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
