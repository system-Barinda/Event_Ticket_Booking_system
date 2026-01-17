<?php
require "../config/database.php";

$query = "
SELECT
    e.title AS event,
    v.name AS venue,
    v.capacity,
    COUNT(t.ticket_id) AS occupied_seats,
    ROUND((COUNT(t.ticket_id) / v.capacity) * 100, 2) AS occupancy_rate
FROM tickets t
JOIN order_items oi ON t.order_item_id = oi.order_item_id
JOIN orders o ON oi.order_id = o.order_id
JOIN sessions s ON o.session_id = s.session_id
JOIN events e ON s.event_id = e.event_id
JOIN venues v ON s.venue_id = v.venue_id
WHERE o.status = 'paid'
GROUP BY s.session_id
";

$result = $conn->query($query);
$stats = [];

while ($row = $result->fetch_assoc()) {
    $stats[] = $row;
}

echo json_encode($stats);
