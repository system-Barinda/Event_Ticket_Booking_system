<?php
require_once "../../config/database.php";

$notif_id = intval($_POST['notif_id'] ?? 0);

if ($notif_id <= 0) {
    echo json_encode(["success" => false]);
    exit;
}

$stmt = $conn->prepare(
    "UPDATE notifications SET is_read = 1 WHERE notif_id = ?"
);
$stmt->bind_param("i", $notif_id);
$stmt->execute();

echo json_encode(["success" => true]);

$stmt->close();
$conn->close();