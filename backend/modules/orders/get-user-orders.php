<?php
require_once "../../config/database.php";

header("Content-Type: application/json");

$user_id = intval($_GET['user_id'] ?? 0);

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID missing"]);
    exit;
}

$sql = "
SELECT 
    orders.order_id,
    events.title,
    events.date,
    events.location,
    orders.quantity,
    orders.total_price
FROM orders
JOIN events ON orders.event_id = events.event_id
WHERE orders.user_id = ?
ORDER BY orders.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode([
    "success" => true,
    "orders" => $orders
]);