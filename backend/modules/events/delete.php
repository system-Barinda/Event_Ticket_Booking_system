<?php
require "../../config/database.php";

$id = $_POST['event_id'];

$stmt = $conn->prepare("DELETE FROM events WHERE event_id=?");
$stmt->bind_param("i", $id);

echo $stmt->execute()
    ? json_encode(["success" => "Event deleted"])
    : json_encode(["error" => "Delete failed"]);
