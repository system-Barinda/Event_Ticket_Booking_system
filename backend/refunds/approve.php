<?php
require "../../config/database.php";

$refundId = $_POST['refund_id'];

$conn->begin_transaction();

try {

    /* Get refund */
    $refund = $conn->query("
        SELECT r.*, o.session_id
        FROM refunds r
        JOIN orders o ON r.order_id=o.order_id
        WHERE refund_id=$refundId
    ")->fetch_assoc();

    if (!$refund) {
        throw new Exception("Invalid refund");
    }

    /* Cancel order */
    $conn->query("
        UPDATE orders SET status='cancelled'
        WHERE order_id={$refund['order_id']}
    ");

    /* Restore ticket quantities */
    $items = $conn->query("
        SELECT ticket_type_id FROM order_items
        WHERE order_id={$refund['order_id']}
    ");

    while ($item = $items->fetch_assoc()) {
        $conn->query("
            UPDATE ticket_types
            SET quantity_remaining = quantity_remaining + 1
            WHERE type_id={$item['ticket_type_id']}
        ");
    }

    /* Delete tickets */
    $conn->query("
        DELETE FROM tickets
        WHERE order_item_id IN (
            SELECT order_item_id FROM order_items
            WHERE order_id={$refund['order_id']}
        )
    ");

    /* Update refund */
    $conn->query("
        UPDATE refunds
        SET status='approved', processed_at=NOW()
        WHERE refund_id=$refundId
    ");

    $conn->commit();
    echo json_encode(["success" => "Refund approved"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Refund failed"]);
}
