<?php
require "../../config/database.php";

$id     = $_POST['session_id'];
$status = $_POST['status'];

$stmt = $conn->prepare(
    "UPDATE sessions SET status=? WHERE session_id=?"
);

$stmt->bind_param("si", $status, $id);

echo $stmt->execute()
    ? json_encode(["success" => "Session updated"])
    : json_encode(["error" => "Update failed"]);
