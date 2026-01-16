<?php
require "../../config/database.php";

$session = $_GET['session_id'];

/* Get held seats */
$result = $conn->query("
SELECT seat_list FROM seat_holds
WHERE session_id = $session
AND hold_expires_at > NOW()
");

$blocked = [];

while ($row = $result->fetch_assoc()) {
    $blocked = array_merge(
        $blocked,
        json_decode($row['seat_list'], true)
    );
}

echo json_encode($blocked);
