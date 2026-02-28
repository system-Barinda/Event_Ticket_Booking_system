<?php
require_once "../../config/database.php";

header("Content-Type: application/json");

// Enable error reporting (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check database connection
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

$sql = "
SELECT 
    event_id,
    organizer_id,
    title,
    description,
    category,
    city,
    language,
    accessibility_notes,
    status,
    event_image,
    created_at
FROM events
ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => "Query failed: " . $conn->error
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