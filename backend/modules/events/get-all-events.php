<?php
require_once "../../config/database.php";

header("Content-Type: application/json");

// Check database connection
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

$sql = "
SELECT 
    event_id,
    title,
    date,
    location,
    price,
    available_tickets,
    created_at
FROM events
ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => "Query failed"
    ]);
    exit;
}

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode([
    "success" => true,
    "events" => $events
]);

$conn->close();
?>