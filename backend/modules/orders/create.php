<?php
require "../../config/database.php";

$user    = $_POST['user_id'];
$session = $_POST['session_id'];

$conn->begin_transaction();

try {
    /* Check active seat hold */
    $check = $conn->prepare("
        SELECT * FROM seat_holds
        WHERE user_id=? AND session_id=?
        AND hold_expires_at > NOW()
    ");
    $check->bind_param("ii", $user, $session);
    $check->execute();
    $hold = $check->get_result()->fetch_assoc();

    if (!$hold) {
        throw new Exception("Seat hold expired");
    }

    /* Create order */
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, session_id)
        VALUES (?,?)
    ");
    $stmt->bind_param("ii", $user, $session);
    $stmt->execute();

    $orderId = $conn->insert_id;

    echo json_encode([
        "success" => true,
        "order_id" => $orderId
    ]);

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => $e->getMessage()]);
}
