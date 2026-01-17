<?php
require "../../config/database.php";

function sendNotification($userId, $message, $type) {
    global $conn;

    $stmt = $conn->prepare("
        INSERT INTO notifications (user_id, message, type)
        VALUES (?,?,?)
    ");
    $stmt->bind_param("iss", $userId, $message, $type);
    $stmt->execute();
}
