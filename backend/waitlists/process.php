<?php
require "../../config/database.php";
require "../../modules/notifications/send.php";

$sessionId = $_POST['session_id'];

$conn->begin_transaction();

try {

    /* Get next user in waitlist */
    $wait = $conn->query("
        SELECT * FROM waitlists
        WHERE session_id=$sessionId
        ORDER BY created_at ASC
        LIMIT 1
    ")->fetch_assoc();

    if (!$wait) {
        throw new Exception("No waitlist users");
    }

    /* Find one available seat */
    $seat = $conn->query("
        SELECT seat_number FROM seats
        WHERE session_id=$sessionId
        AND seat_number NOT IN (
            SELECT seat_number FROM order_items oi
            JOIN orders o ON oi.order_id=o.order_id
            WHERE o.session_id=$sessionId AND o.status='paid'
        )
        LIMIT 1
    ")->fetch_assoc();

    if (!$seat) {
        throw new Exception("No seats available");
    }

    /* Create seat hold (10 minutes) */
    $expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));
    $seatList = json_encode([$seat['seat_number']]);

    $stmt = $conn->prepare("
        INSERT INTO seat_holds (user_id, session_id, seat_list, expires_at)
        VALUES (?,?,?,?)
    ");
    $stmt->bind_param(
        "iiss",
        $wait['user_id'],
        $sessionId,
        $seatList,
        $expires
    );
    $stmt->execute();

    /* Remove from waitlist */
    $conn->query("
        DELETE FROM waitlists
        WHERE waitlist_id={$wait['waitlist_id']}
    ");

    /* ✅ COMMIT FIRST */
    $conn->commit();

    /* ✅ SEND WAITLIST NOTIFICATION */
    sendNotification(
        $wait['user_id'],
        "A seat is now available for your event. You have 10 minutes to complete booking.",
        "waitlist"
    );

    echo json_encode(["success" => "Waitlist user notified"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => $e->getMessage()]);
}
