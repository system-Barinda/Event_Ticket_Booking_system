<?php
require "../../config/database.php";

$userId = $_GET['user_id'];

$result = $conn->query("
    SELECT * FROM notifications
    WHERE user_id=$userId
    ORDER BY sent_at DESC
");

$notes = [];

while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}

echo json_encode($notes);
