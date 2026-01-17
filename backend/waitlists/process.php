<?php
require "../../config/database.php";

$session = $_POST['session_id'];

/* Check available tickets */
$available = $conn->query("
    SELECT SUM(quantity_remaining) AS total
    FROM ticket_types
    WHERE session_id=$session
")->fetch_assoc();

if ($available['total'] <= 0) {
    exit; // no seats available
}

/* Get first user in waitlist */
$next = $conn->query("
    SELECT * FROM waitlists
    WHERE session_id=$session
    ORDER BY created_at ASC
    LIMIT 1
")->fetch_assoc();

if (!$next) {
    exit;
}

/* Create temporary seat hold (10 minutes) */
$expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

$conn->query("
    INSERT INTO seat_holds (user_id, session_id, seat_list, hold_expires_at)
    VALUES ({$next['user_id']}, $session, '[]', '$expires')
");

/* Remove from waitlist */
$conn->query("
    DELETE FROM waitlists
    WHERE wait_id={$next['wait_id']}
");

/* Notify user (simulated) */
$conn->query("
    INSERT INTO notifications (user_id, message, type)
    VALUES (
        {$next['user_id']},
        'A seat is now available for your event. Complete booking within 10 minutes.',
        'waitlist'
    )
");
