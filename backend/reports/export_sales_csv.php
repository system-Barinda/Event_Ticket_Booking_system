<?php
require "../config/database.php";

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=sales_report.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["Event", "Tickets Sold", "Revenue"]);

$result = $conn->query("
SELECT e.title, COUNT(t.ticket_id), SUM(oi.price)
FROM tickets t
JOIN order_items oi ON t.order_item_id = oi.order_item_id
JOIN orders o ON oi.order_id = o.order_id
JOIN sessions s ON o.session_id = s.session_id
JOIN events e ON s.event_id = e.event_id
WHERE o.status='paid'
GROUP BY e.event_id
");

while ($row = $result->fetch_row()) {
    fputcsv($output, $row);
}

fclose($output);
