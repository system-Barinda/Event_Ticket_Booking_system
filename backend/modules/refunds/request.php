<?php
require "../../config/database.php";

$orderId = $_POST['order_id'];

/* Check order */
$order = $conn->query("
    SELECT * FROM orders
    WHERE order_id=$orderId AND status='paid'
")->fetch_assoc();

if (!$order) {
    echo json_encode(["error" => "Refund not allowed"]);
    exit;
}

/* Create refund request */
$stmt = $conn->prepare("
    INSERT INTO refunds (order_id, amount)
    VALUES (?,?)
");
$stmt->bind_param("id", $orderId, $order['total_amount']);
$stmt->execute();

echo json_encode(["success" => "Refund requested"]);
