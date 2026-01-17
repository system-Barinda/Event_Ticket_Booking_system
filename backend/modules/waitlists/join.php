<?php
require "../../config/database.php";

$user    = $_POST['user_id'];
$session = $_POST['session_id'];

/* Check if already on waitlist */
$check = $conn->prepare("
    SELECT * FROM waitlists
    WHERE user_id=? AND session_id=?
");
$check->bind_param("ii", $user, $session);
$check->execute();

if ($check->get_result()->num_rows > 0) {
    echo json_encode(["error" => "Already on waitlist"]);
    exit;
}

/* Add to waitlist */
$stmt = $conn->prepare("
    INSERT INTO waitlists (user_id, session_id)
    VALUES (?,?)
");
$stmt->bind_param("ii", $user, $session);

echo $stmt->execute()
    ? json_encode(["success" => "Added to waitlist"])
    : json_encode(["error" => "Failed"]);
