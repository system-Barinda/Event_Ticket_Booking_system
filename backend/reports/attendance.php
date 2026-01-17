<?php
require "../config/database.php";

$query = "
SELECT
    e.title AS event,
    COUNT(t.ticket_id) AS total_tickets,
    SUM(t.checked_in = 1) AS checked_in,
    SUM(t.checked_in = 0) AS not_checked_in
FROM tickets t
JOIN order_items oi ON t.order_item_id = oi.order_item_id
JOIN orders o ON oi.order_id = o.order_id
JOIN sessions s ON o.session_id = s.session_id
JOIN events e ON s.event_id = e.event_id
GROUP BY e.event_id
";

$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
