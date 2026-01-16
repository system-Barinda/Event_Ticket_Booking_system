<?php
require "../../config/database.php";

$event  = $_POST['event_id'];
$venue  = $_POST['venue_id'];
$start  = $_POST['start_datetime'];
$end    = $_POST['end_datetime'];

if (strtotime($start) >= strtotime($end)) {
    echo json_encode(["error" => "Invalid session time"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO sessions
    (event_id, venue_id, start_datetime, end_datetime)
    VALUES (?,?,?,?)"
);

$stmt->bind_param("iiss", $event, $venue, $start, $end);

echo $stmt->execute()
    ? json_encode(["success" => "Session created"])
    : json_encode(["error" => "Failed to create session"]);
