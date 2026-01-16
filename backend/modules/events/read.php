<?php
require "../../config/database.php";

$query = "
SELECT 
    e.event_id,
    e.title,
    e.category,
    e.city,
    e.status,
    u.name AS organizer
FROM events e
JOIN users u ON e.organizer_id = u.user_id
ORDER BY e.created_at DESC
";

$result = $conn->query($query);
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
