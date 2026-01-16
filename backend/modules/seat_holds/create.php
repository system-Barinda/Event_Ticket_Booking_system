<?php
require "../../config/database.php";

$user    = $_POST['user_id'];
$session = $_POST['session_id'];
$seats   = json_encode($_POST['seats']); // array from frontend

$expires = date(
    "Y-m-d H:i:s",
    strtotime("+10 minutes")
);

/* CHECK if seats already held */
$stmt = $conn->prepare("
SELECT * FROM seat_holds
WHERE session_id = ?
AND hold_expires_at > NOW()
AND JSON_OVERLAPS(seat_list, ?)
");
$stmt->bind_param("is", $session, $seats);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["error" => "Seats already reserved"]);
    exit;
}

/* CREATE HOLD */
$stmt = $conn->prepare("
INSERT INTO seat_holds
(user_id, session_id, seat_list, hold_expires_at)
VALUES (?,?,?,?)
");
$stmt->bind_param("iiss", $user, $session, $seats, $expires);

echo $stmt->execute()
    ? json_encode(["success" => "Seats held for 10 minutes"])
    : json_encode(["error" => "Hold failed"]);
