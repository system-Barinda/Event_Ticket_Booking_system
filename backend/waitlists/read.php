<?php
require "../../config/database.php";

$query = "
SELECT 
    w.wait_id,
    u.name AS user,
    e.title AS event,
    s.start_datetime
FROM waitlists w
JOIN users u ON w.user_id = u.user_id
JOIN sessions s ON w.session_id = s.session_id
JOIN events e ON s.event_id = e.event_id
ORDER BY w.created_at ASC
";

$result = $conn->query($query);
$list = [];

while ($row = $result->fetch_assoc()) {
    $list[] = $row;
}

echo json_encode($list);
