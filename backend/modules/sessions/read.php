<?php
require "../../config/database.php";

$query = "
SELECT 
    s.session_id,
    e.title AS event,
    v.name AS venue,
    s.start_datetime,
    s.end_datetime,
    s.status
FROM sessions s
JOIN events e ON s.event_id = e.event_id
JOIN venues v ON s.venue_id = v.venue_id
ORDER BY s.start_datetime
";

$result = $conn->query($query);
$sessions = [];

while ($row = $result->fetch_assoc()) {
    $sessions[] = $row;
}

echo json_encode($sessions);
