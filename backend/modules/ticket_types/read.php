<?php
require "../../config/database.php";

$query = "
SELECT
    t.type_id,
    s.session_id,
    e.title AS event,
    t.name,
    t.price,
    t.quantity_remaining
FROM ticket_types t
JOIN sessions s ON t.session_id = s.session_id
JOIN events e ON s.event_id = e.event_id
";

$result = $conn->query($query);
$types = [];

while ($row = $result->fetch_assoc()) {
    $types[] = $row;
}

echo json_encode($types);
