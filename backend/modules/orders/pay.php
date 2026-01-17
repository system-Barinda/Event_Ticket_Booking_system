<?php
require "../../config/database.php";
require "../../modules/notifications/send.php";

$orderId = $_POST['order_id'];

$conn->begin_transaction();

try {

    /* Get order */
    $order = $conn->query("
        SELECT * FROM orders
        WHERE order_id = $orderId
    ")->fetch_assoc();

    if (!$order) {
        throw new Exception("Invalid order");
    }

    /* Mark order paid */
    $stmt = $conn->prepare("
        UPDATE orders SET status='paid'
        WHERE order_id=?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Payment failed");
    }

    /* ✅ COMMIT FIRST */
    $conn->commit();

    /* ✅ SEND PAYMENT NOTIFICATION */
    sendNotification(
        $order['user_id'],
        "Payment successful. Thank you for your purchase.",
        "payment"
    );

    echo json_encode(["success" => "Payment successful"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Payment failed"]);
}
