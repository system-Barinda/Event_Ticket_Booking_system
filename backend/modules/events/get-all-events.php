<?php
require_once "../../config/database.php";

header("Content-Type: application/json");

$sql = "
SELECT 
    event_id,
    title,
    date,
    location,
    price,
    available_tickets
FROM events
ORDER BY created_at DESC
";

$result = $conn->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode([
    "success" => true,
    "events" => $events
]);