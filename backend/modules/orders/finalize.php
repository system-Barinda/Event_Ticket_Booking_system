<?php
require "../../config/database.php";
require "../../libs/phpqrcode/qrlib.php";
require "../../modules/notifications/send.php"; // ✅ ADD THIS

$orderId = $_POST['order_id'];

$conn->begin_transaction();

try {

    /* Get order */
    $order = $conn->query("
        SELECT * FROM orders
        WHERE order_id = $orderId AND status='paid'
    ")->fetch_assoc();

    if (!$order) {
        throw new Exception("Invalid or unpaid order");
    }

    /* Get seat hold */
    $hold = $conn->query("
        SELECT * FROM seat_holds
        WHERE user_id={$order['user_id']}
        AND session_id={$order['session_id']}
    ")->fetch_assoc();

    if (!$hold) {
        throw new Exception("Seat hold not found");
    }

    $seats = json_decode($hold['seat_list'], true);

    foreach ($seats as $seat) {

        /* Get one ticket type */
        $type = $conn->query("
            SELECT * FROM ticket_types
            WHERE session_id={$order['session_id']}
            AND quantity_remaining > 0
            LIMIT 1
        ")->fetch_assoc();

        if (!$type) {
            throw new Exception("No tickets available");
        }

        /* Create order item */
        $stmt = $conn->prepare("
            INSERT INTO order_items
            (order_id, ticket_type_id, seat_number, price)
            VALUES (?,?,?,?)
        ");
        $stmt->bind_param(
            "iisd",
            $orderId,
            $type['type_id'],
            $seat,
            $type['price']
        );
        $stmt->execute();

        $orderItemId = $conn->insert_id;

        /* Reduce quantity */
        $conn->query("
            UPDATE ticket_types
            SET quantity_remaining = quantity_remaining - 1
            WHERE type_id = {$type['type_id']}
        ");

        /* Generate ticket code */
        $ticketCode = strtoupper(uniqid("TKT-"));

        /* Generate QR */
        $qrPath = "../../tickets/{$ticketCode}.png";
        QRcode::png($ticketCode, $qrPath);

        /* Save ticket */
        $stmt = $conn->prepare("
            INSERT INTO tickets
            (order_item_id, ticket_code, qr_code_url)
            VALUES (?,?,?)
        ");
        $stmt->bind_param(
            "iss",
            $orderItemId,
            $ticketCode,
            $qrPath
        );
        $stmt->execute();
    }

    /* Delete seat hold */
    $conn->query("
        DELETE FROM seat_holds
        WHERE user_id={$order['user_id']}
        AND session_id={$order['session_id']}
    ");

    /* ✅ COMMIT FIRST */
    $conn->commit();

    /* ✅ SEND NOTIFICATION AFTER SUCCESS */
    sendNotification(
        $order['user_id'],
        "Your tickets have been issued successfully. Please bring your QR code.",
        "booking"
    );

    echo json_encode(["success" => "Tickets generated"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => $e->getMessage()]);
}
