<?php
require "../config/database.php";

$query = "
SELECT
    e.title AS event,
    COUNT(t.ticket_id) AS tickets_sold,
    SUM(oi.price) AS revenue
FROM tickets t
JOIN order_items oi ON t.order_item_id = oi.order_item_id
JOIN orders o ON oi.order_id = o.order_id
JOIN sessions s ON o.session_id = s.session_id
JOIN events e ON s.event_id = e.event_id
WHERE o.status = 'paid'
GROUP BY e.event_id
ORDER BY revenue DESC
";

$result = $conn->query($query);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
