<?php
require "../../config/database.php";
header("Content-Type: application/json");

$user_id    = $_POST['user_id'] ?? null;
$session_id = $_POST['session_id'] ?? null;

if (!$user_id || !$session_id) {
    echo json_encode(["success" => false, "message" => "Missing data"]);
    exit;
}

$conn->begin_transaction();

try {

    /* 1️⃣ Check active seat hold */
    $check = $conn->prepare("
        SELECT seat_count, price_per_seat
        FROM seat_holds
        WHERE user_id = ? 
          AND session_id = ?
          AND hold_expires_at > NOW()
    ");
    $check->bind_param("ii", $user_id, $session_id);
    $check->execute();
    $hold = $check->get_result()->fetch_assoc();

    if (!$hold) {
        throw new Exception("Seat hold expired or not found");
    }

    /* 2️⃣ Calculate total amount */
    $total_amount = $hold['seat_count'] * $hold['price_per_seat'];

    /* 3️⃣ Create order (status defaults to 'pending') */
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, session_id, total_amount, status)
        VALUES (?, ?, ?, 'pending')
    ");
    $stmt->bind_param("iid", $user_id, $session_id, $total_amount);
    $stmt->execute();

    $order_id = $conn->insert_id;

    /* 4️⃣ Remove seat hold after successful order */
    $deleteHold = $conn->prepare("
        DELETE FROM seat_holds
        WHERE user_id = ? AND session_id = ?
    ");
    $deleteHold->bind_param("ii", $user_id, $session_id);
    $deleteHold->execute();

    $conn->commit();

    echo json_encode([
        "success" => true,
        "order_id" => $order_id,
        "total_amount" => $total_amount,
        "status" => "pending"
    ]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}