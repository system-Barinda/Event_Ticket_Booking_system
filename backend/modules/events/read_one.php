<?php
require "../../config/database.php";

header("Content-Type: application/json");

$event_id = intval($_GET['id'] ?? 0);

if ($event_id === 0) {
    echo json_encode(["success" => false, "message" => "Invalid event ID"]);
    exit;
}

$sql = "
SELECT 
    e.event_id,
    e.title,
    e.category,
    e.city,
    e.language,
    e.description,
    e.accessibility_notes,
    e.event_image,
    e.status,
    u.name AS organizer
FROM events e
JOIN users u ON e.organizer_id = u.user_id
WHERE e.event_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Event not found"]);
    exit;
}

echo json_encode([
    "success" => true,
    "data" => $result->fetch_assoc()
]);

$stmt->close();
$conn->close();