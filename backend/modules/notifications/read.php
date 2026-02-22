<?php
require_once "../../config/database.php";

$user_id = intval($_GET['user_id'] ?? 0);

if ($user_id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid user"
    ]);
    exit;
}

$sql = "SELECT notif_id, message, type, sent_at, is_read
        FROM notifications
        WHERE user_id = ?
        ORDER BY sent_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode([
    "success" => true,
    "count" => count($notifications),
    "data" => $notifications
]);

$stmt->close();
$conn->close();