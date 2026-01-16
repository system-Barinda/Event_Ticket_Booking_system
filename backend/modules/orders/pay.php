<?php
require "../../config/database.php";

$orderId = $_POST['order_id'];

$conn->begin_transaction();

try {
    /* Mark order paid */
    $stmt = $conn->prepare("
        UPDATE orders SET status='paid'
        WHERE order_id=?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Invalid order");
    }

    echo json_encode(["success" => "Payment successful"]);

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Payment failed"]);
}
